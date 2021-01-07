<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Prize;
use App\Image;
use App\User;

class PrizeController extends Controller
{
    public function index()
    {
        $prizes = Prize::all();
        return view("prize.list")
            ->with(compact("prizes"));
    }


    //prize create form
    public function create()
    {
        return view("prize.createForm");
    }

    //Create new prize instance
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required",
            "description" => "required",
            "criteria_high" => "required",
            "criteria_low" => "required",
        ]);
        if ($request->criteria_high < $request->criteria_low) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    "criteria" => "Criteria high should always be higher or equal to criteria low."
                ]);
        }
        $prize = Prize::create([
            "title" => $request->title,
            "description" => $request->description,
            "criteria_high" => $request->criteria_high,
            "criteria_low" => $request->criteria_low,
        ]);
        Image::where("owner", $prize->id)->delete();
        if (!empty($request->imageurl)) {
            foreach ($request->imageurl as $image) {
                if (!empty(trim($image))) {
                    Image::create([
                        "owner" => $prize->id,
                        "title" => $request->title,
                        "url" => $image,
                    ]);
                }
            }
        }
        return redirect()->to(route("prize.index"));
    }

    //Show edit form
    public function edit(Prize $prize)
    {
        $prize->load("images");

        return view("prize.edit")
            ->with(compact("prize"));
    }

    //Update prize Instance
    public function update(Request $request, Prize $prize)
    {
        $request->validate([
            "title" => "required",
            "description" => "required",
            "criteria_high" => "required",
            "criteria_low" => "required",
        ]);
        if ($request->criteria_high < $request->criteria_low) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    "criteria" => "Criteria high should always be higher or equal to criteria low."
                ]);
        }
        $prize->update([
            "title" => $request->title,
            "description" => $request->description,
            "criteria_high" => $request->criteria_high,
            "criteria_low" => $request->criteria_low,
        ]);
        Image::where("owner", $prize->id)->delete();
        foreach ($request->imageurl as $image) {
            Image::create([
                "owner" => $prize->id,
                "title" => $request->title,
                "url" => $image,
            ]);
        }
        return redirect()->to(route("prize.index"));
    }

    //Delete prize
    public function destroy(Prize $prize)
    {
        $prize->delete();
        Image::where("owner", $prize->id)->delete();
        return redirect()->to(route("prize.index"));
    }

    public function distributePrize()
    {
        $users = User::orderBy("points", "DESC")
            ->where('email', '!=', NULL)
            ->limit((int)env("LEADERBOARD_LIMIT"))
            ->select(["email", "name", "points"])
            ->get();
        $prizes = Prize::with("images")->get();

        $users->map(function ($user, $idx) use ($prizes) {
            $tmpPrizes = array();
            $user->idx = $idx + 1;

            foreach ($prizes as $prize) {
                if ($user->idx >= $prize->criteria_low && $user->idx <= $prize->criteria_high) {
                    array_push($tmpPrizes, [
                        [
                            "title" => $prize->title,
                            "description" => $prize->description,
                            "image" => $prize->images
                        ]
                    ]);
                }
            }

            $user->prizes = $tmpPrizes;
        });

        foreach ($users as $user) {
            if (count($user->prizes) == 0) {
                sendMail("d-ac6e21f9736142e3ae5a84b663872337", $user->email, [
                    "user" => $user->name,
                    "prizes" => $user->prizes
                ]);
            }
        }
        return redirect()->route("prize.index");
    }
}
