<?php

namespace App\Http\Controllers;

use App\Poll;
use App\Vote;
use App\VoteOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Auth;

class PollController extends Controller
{
    public function index()
    {
        $polls = Poll::orderBy("created_at", "DESC")
            ->withCount("questions")
            ->withCount("votes")
            ->get();
        return view("poll.list")->with(compact("polls"));
    }

    public function create()
    {
        return view("poll.create");
    }

    public function save(Request $request)
    {
        $data = $request->except(["_token"]);
        $poll = Poll::create([
            "name" => $data["pollName"],
            "start_date" => Date::parse($data["startDate"]),
            "end_date" => Date::parse($data["endDate"])
        ]);

        foreach ($data["questions"] as $key => $question) {
            $q = $poll->questions()->create(["sort_order" => $key, "text" => $question["text"]]);

            foreach ($question["options"] as $key => $option) {
                $q->options()->create(["sort_order" => $key, "text" => $option]);
            }
        }

        return ["success" => TRUE];
    }

    public function update(Request $request, Poll $poll)
    {
        if ($request->isMethod("get")) {
            $poll->load("questions.options");
            $question = $poll->questions->map(function ($question) {
                return [
                    "text" => $question->text,
                    "options" => $question->options->map(function ($option) {
                        return $option->text;
                    })
                ];
            })->toArray();
            unset($poll->questions);
            $poll->questions = $question;
            return view("poll.edit")->with(compact("poll"));
        } else {
            // if (checkPollStatus($poll) != 0) {
            //     return response()
            //         ->json(["success" => FALSE, "message" => "Can't edit ongoing poll"]);
            // }
            $data = $request->except(["_token"]);
            $poll->update([
                "name" => $data["pollName"],
                "start_date" => Date::parse($data["startDate"]),
                "end_date" => Date::parse($data["endDate"])
            ]);
            $poll->questions()->delete();
            foreach ($data["questions"] as $key => $question) {
                $q = $poll->questions()->create(["sort_order" => $key, "text" => $question["text"]]);

                foreach ($question["options"] as $key => $option) {
                    $q->options()->create(["sort_order" => $key, "text" => $option]);
                }
            }
            return ["success" => TRUE];
        }
    }

    public function destroy(Poll $poll)
    {
        $status = checkPollStatus($poll);
        if ($status === 0) {
            $poll->delete();
        }
        return redirect()
            ->route(
                "poll.manage",
                [
                    "message" => $status === 0
                        ? "Deleted {$poll->name}" : "Can't delete the post as its " . ($status === 1 ? "Ongoing" : "Completed")
                ]
            );
    }

    public function updateStatus(Poll $poll, $status)
    {
        if ($poll->status != 0) {
            return redirect()->route("poll.delete");
        }

        if (is_numeric($status)) {
            $status = (int) $status;
        }

        $poll->status = $status;
        $poll->save();

        return redirect()->route("poll.manage");
    }

    private function checkIfUserHasVotedForPoll($poll, $user)
    {
        $vote = Vote::where("poll_id", $poll)->where("user_id", $user)->first();
        return $vote ? $vote->isSubmitted() : false; //If vote exists and has been submitted then user has already voted
    }

    public function getByLaws(Request $request)
    {
        $user = Auth::user();
        $poll = Poll::with("questions.options")
            ->where("id", BY_LAWS_POLL)
            ->first();
        $pollStatus = checkPollStatus($poll);
        switch ($pollStatus) {
            case 1:
                $vote = Vote::where("poll_id", $poll->id)->where("user_id", $user->id)->with("vote_options.option")->first();
                $alreadyVoted = $vote ? $vote->isSubmitted() : false;
                $responses = [];
                if ($vote) {
                    foreach ($vote->vote_options as $option) {
                        $responses[$option->question_id] = $option->option_id;
                    }
                }
                $toSend = [
                    "isActive" => $pollStatus,
                    "hasVoted" => $alreadyVoted,
                    "questions" => $poll->questions,
                    "responses" => $responses,
                    "startTime" => $poll->start_date->timezone("EDT"),
                    "endTime" => $poll->end_date->timezone("EDT"),
                ];
                return $toSend;
            default:
                return [
                    "isActive" => $pollStatus,
                    "startTime" => $poll->start_date->timezone("EDT"),
                    "endTime" => $poll->end_date->timezone("EDT"),
                ];
        }
    }

    public function submitByLawsOption(Request $request)
    {
        $user = Auth::user();
        $poll = Poll::with("questions.options")->where("id", BY_LAWS_POLL)->first();
        $pollStatus = checkPollStatus($poll);
        if ($pollStatus == 1) {
            $vote = Vote::where("poll_id", $poll->id)->where("user_id", $user->id)->first(); //Fetch user vote
            if (!$vote) { //Create new instance if it does not exist
                $vote = $user->votes()->create([
                    "poll_id" => $poll->id,
                ]);
            }
            $hasVoted = $vote ? $vote->isSubmitted() : false;
            if (!$hasVoted) { //Only allow to change option if he has not yet submitted the poll
                $question = $request->get("question", false);
                $option = $request->get("option", false);
                if ($question && $option) {
                    $voteOption = VoteOption::where("vote_id", $vote->id)->where("question_id", $question)->first();
                    if ($voteOption) {
                        $voteOption->update([
                            'option_id' => $option,
                        ]);
                    } else {
                        $vote->vote_options()->create([
                            'question_id' => $question,
                            'option_id' => $option,
                        ]);
                    }
                }
                return [
                    "error" => false,
                    'message' => "Your choice for question has been saved!"
                ];
            }
            return [
                "error" => true,
                'message' => "You have already voted for the poll"
            ];
        } else if ($pollStatus == 2) {
            return [
                "error" => true,
                'message' => "Poll is already completed. You cannot vote now!"
            ];
        } else {
            return [
                "error" => true,
                'message' => "Poll is yet to begin"
            ];
        }
    }

    public function submitByLaws(Request $request)
    {
        $user = Auth::user();
        $poll = Poll::with("questions.options")->where("id", BY_LAWS_POLL)->first();
        $pollStatus = checkPollStatus($poll);
        if ($pollStatus == 1) {
            $vote = Vote::where("poll_id", $poll->id)->where("user_id", $user->id)->first(); //Fetch user vote
            if (!$vote) { //Create new instance if it does not exist
                $vote = $user->votes()->create([
                    "poll_id" => $poll->id,
                ]);
            }
            if ($vote && !$vote->isSubmitted()) {
                $response = $request->get("response", false);
                if (is_array($response) && count($response)) {
                    foreach ($response as $questionId => $optionId) {
                        $voteOption = VoteOption::where("vote_id", $vote->id)->where("question_id", $questionId)->first();
                        if ($voteOption) {
                            $voteOption->update([
                                'option_id' => $optionId,
                            ]);
                        } else {
                            $vote->vote_options()->create([
                                'question_id' => $questionId,
                                'option_id' => $optionId,
                            ]);
                        }
                    }
                } else {
                    return [
                        "error" => true,
                        'message' => "Please select a response before submitting your poll!"
                    ];
                }
                $vote->submit();
                return [
                    "error" => false,
                    'message' => "Your vote has been registered. Thank you for voting!",
                    "vote" => $vote
                ];
            }
            return [
                "error" => true,
                'message' => "You have already voted for the poll"
            ];
        } else if ($pollStatus == 2) {
            return [
                "error" => true,
                'message' => "Poll is already completed. You cannot vote now!"
            ];
        } else {
            return [
                "error" => true,
                'message' => "Poll is yet to begin"
            ];
        }
    }

    public function resultsView(Request $request, Poll $poll)
    {
        $nonVoters = getPollNonVoters($poll->id, USER_TYPE_DELEGATE);
        $poll
            ->loadCount("votes")
            ->load([
                "questions.options.vote_options.vote"
            ]);
        $poll->questions->map(function ($question) {
            $question->options->map(function ($option) {
                $validOptions = $option->vote_options->filter(function ($op) {
                    return $op->vote && $op->vote->isSubmitted();
                });
                unset($option->vote_options);
                $option->vote_options = $validOptions;
            });
        });
        $poll->votes_count = Vote::where("status", 1)->where("poll_id", $poll->id)->count();
        $poll->non_submitted = count($nonVoters);
        $varsToPass = compact(['poll', 'nonVoters']);
        if ($request->isMethod('post')) {
            return view("poll.resultCharts")->with($varsToPass);
        }
        return view("poll.result")->with($varsToPass);
    }
}
