<?php

namespace App\Http\Controllers;

use App\Booth;
use App\User;
use App\UserConnection;
use App\Contact;
use App\UserTag;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Log;
use Mail;
use Sichikawa\LaravelSendgridDriver\Transport\SendgridTransport;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy("created_at", "DESC")->get();
        return view("user.list")->with(compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("user.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'email' => 'required|email|unique:users,email', 'password' => 'required|min:8']);

        $userData = $request->except("_token");
        $userData["password"] = Hash::make($userData["password"]);
        $userData["isCometChatAccountExist"] = TRUE;

        $user = User::create($userData);
        // $user->sendEmailVerificationNotification();
        // create user in comet chat
        Http::withHeaders(
            [
                'appId' => env('COMET_CHAT_APP_ID'),
                'apiKey' => env('COMET_CHAT_API_KEY')
            ]
        )
            ->post(env('COMET_CHAT_BASE_URL') . '/v2.0/users', [
                'uid' => $user->id,
                'name' => $user->name
            ]);
        return redirect()->to(route("user.index"));
    }

    public function bulk_create(Request $request)
    {
        $data = $request->except("_token");
        if (isset($data["users"]) && count($data["users"]) > 0) {
            $users = $data["users"];
            foreach ($users as $user) {
                $existingUser = User::where(env('ATTENDEE_LOGIN_FIELD'), $user[env('ATTENDEE_LOGIN_FIELD')])->first();
                if (!$existingUser) {
                    $user = User::create($user);
                    $user->markEmailAsVerified();

                    Http::withHeaders(
                        [
                            "appId" => env("COMET_CHAT_APP_ID"),
                            "apiKey" => env("COMET_CHAT_API_KEY")
                        ]
                    )
                        ->post(
                            env('COMET_CHAT_BASE_URL') . "/v2.0/users",
                            [
                                "uid" => $user->id,
                                "name" => $user->name
                            ]
                        );

//                    Mail::send([], [], function (Message $message) use ($user) {
//                        $message
//                            ->to($user->email)
//                            ->from(env("MAIL_FROM_ADDRESS"), env("MAIL_FROM_NAME"))
//                            ->embedData([
//                                'personalizations' => [
//                                    [
//                                        'dynamic_template_data' => [
//                                            'user' => "{$user->name} {$user->last_name}",
//                                            'email'  => strtolower($user->email),
//                                        ],
//                                    ],
//                                ],
//                                'template_id' => config("services.sendgrid.templates.register"),
//                            ], SendgridTransport::SMTP_API_NAME);
//                    });
                } else {
                    $existingUser->update($user);
                }
            }
            return ["success" => TRUE];
        }
        return ["success" => FALSE, "message" => "Please upload some file containing user details"];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $user)
    {
        if ($request->user()->id == $user->id) {
            return redirect()->route("home");
        }
        return view("user.edit")->with(compact("user"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate(["email" => "required|email", "name" => "required"]);

        $userData = $request->except(["_token", "_method"]);

        if ($userData["password"] !== NULL) {
            $user->password = Hash::make($userData["password"]);
        } else {
            unset($userData["password"]);
        }

        if ($request->has("verify_email")) {
            $user->markEmailAsVerified();
        }

        $cometChat = isset($userData["enable_chat"]) ? 'enable' : null;
        $cometChat =  isset($userData["disable_chat"]) ? 'disable' : $cometChat;

        switch ($cometChat) {
            case 'enable':
                // attempt creating account
                $response = Http::withHeaders([
                    'appId' => env('COMET_CHAT_APP_ID'),
                    'apiKey' => env('COMET_CHAT_API_KEY')
                ])
                    ->post(env('COMET_CHAT_BASE_URL') . '/v2.0/users', [
                        'uid' => $user->id,
                        'name' => $user->name
                    ]);

                // account created, reactivate it
                if ($response->clientError()) {
                    Http::withHeaders([
                        'appId' => env('COMET_CHAT_APP_ID'),
                        'apiKey' => env('COMET_CHAT_API_KEY')
                    ])
                        ->put(env('COMET_CHAT_BASE_URL') . '/v2.0/users',  ['uidsToActivate' => [$user->id]]);
                    $user->isCometChatAccountExist = TRUE;
                }
                break;
            case 'disable':
                Http::withHeaders([
                    'appId' => env('COMET_CHAT_APP_ID'),
                    'apiKey' => env('COMET_CHAT_API_KEY')
                ])
                    ->delete(env('COMET_CHAT_BASE_URL') . '/v2.0/users/' . $user->id, ["permanent" => FALSE]);
                $user->isCometChatAccountExist = FALSE;
                break;
        }

        // update name in comet chat as well
        if ($user->name != $userData["name"] && $user->isCometChatAccountExist) {
            Http::withHeaders([
                'appId' => env('COMET_CHAT_APP_ID'),
                'apiKey' => env('COMET_CHAT_API_KEY')
            ])
                ->put(env('COMET_CHAT_BASE_URL') . '/v2.0/users/' . $user->id, ["name" => $userData["name"]]);
        }

        $user->name = $userData["name"];
        $user->email = $userData["email"];
        $user->type = $userData["type"];
        $user->save();

        return redirect()->route("user.edit", compact("user"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        Http::withHeaders([
            'appId' => env('COMET_CHAT_APP_ID'),
            'apiKey' => env('COMET_CHAT_API_KEY')
        ])
            ->delete(env('COMET_CHAT_BASE_URL') . '/v2.0/users/' . $user->id, ["permanent" => TRUE]);
        $user->delete();
        return redirect()->to(route("user.index"));
    }

    public function changePassword(Request $request)
    {
        return view("user.changePassword");
    }
    public function updatepassword(Request $request)
    {
        $request->validate([
            "oldpassword" => "required",
            "newpassword" => "required|min:8"
        ]);
        $credentials = [
            "email" => Auth::user()->email,
            "password" => $request->oldpassword
        ];
        if (Auth::attempt($credentials)) {
            //successfully update password
            if ($request->newpassword == $request->confirmnew) {
                User::find(Auth::user()->id)->update(["password" => Hash::make($request->newpassword)]);

                return redirect()
                    ->back()
                    ->withErrors([
                        "success" => "Successfully Updated Password"
                    ]);;
            } else {
                return redirect()
                    ->back()
                    ->withErrors([
                        "passmismatch" => "The New Password And Confirm Password Dont match"
                    ]);
            }
        } else {
            return redirect()
                ->back()
                ->withErrors([
                    "oldpassword" => "The Old Password is Wrong"
                ]);;
        }
    }

    public function syncUserChat()
    {
        $users = User::where("isCometChatAccountExist", FALSE)
            ->limit(rand(10, 25))
            ->get(["id", "name"]);

        if (count($users) == 0) {
            return ["success" => TRUE];
        }

        $users->each(function ($user) {
            Http::withHeaders([
                "apiKey" => env("COMET_CHAT_API_KEY"),
                "appId" => env("COMET_CHAT_APP_ID"),
                "accept" => "application/json"
            ])
                ->post(env('COMET_CHAT_BASE_URL') . "/v2.0/users", [
                    "uid" => $user->id,
                    "name" => $user->name
                ]);
            $user->isCometChatAccountExist = TRUE;
            $user->save();
        });

        $left = User::where("isCometChatAccountExist", FALSE)->count();
        $total = User::all()->count();

        return ["success" => FALSE, "left" => $left, "total" => $total];
    }

    public function syncGroupChat()
    {
        $booths = Booth::all(["id", "name"]);

        $booths->each(function ($booth) {
            Http::withHeaders([
                "apiKey" => env("COMET_CHAT_API_KEY"),
                "appId" => env("COMET_CHAT_APP_ID"),
                "accept" => "application/json"
            ])
                ->post(env('COMET_CHAT_BASE_URL') . "/v2.0/groups", [
                    "guid" => $booth->id,
                    "name" => $booth->name,
                    "type" => "public"
                ]);
        });
        return ["success" => TRUE];
    }

    public function sendConnectionRequest(Request $request)
    {
        $user = $request->get("user", false);
        if ($user) {
            $connection = getConnection($user, Auth::user()->id);
            if ($connection) {
                $connection['success'] = true;
                return $connection;
            }
            $user = User::find($user);
            if ($user) {
                $user->requestConnection();
                $connection = getConnection($user->id, Auth::user()->id);
                if ($connection) {
                    $connection['success'] = true;
                    return $connection;
                }
            }
        }
        return [
            "success" => false,
            "message" => "Please select a user"
        ];
    }

    public function updateConnectionRequest(Request $request)
    {
        $connection = $request->get("connection", false);
        $status = (int) $request->get("status", 0);
        if ($status == 0) {
            return ["message" => "Can only accept or reject connections. Cannot make them pending again!", "success" => false];
        }
        if ($connection && ($status == 1 || $status == -1)) {
            $connection = UserConnection::find($connection);
            if (Auth::user()->id === $connection->connection_id) {
                $connection->setStatus($status);
                return [
                    "success" => true,
                    'connection_status' => $connection->status,
                    'connection_id' => $connection->id,
                    'connection_type' => "received"
                ];
            }
        }
        return ["success" => false, "message" => "No actionable request found!"];
    }

    public function suggestedContacts(Request $request)
    {
        $user = Auth::user();
        $user->load("looking_for_tags.user_id");
        $suggestedIds = [];
        foreach ($user->looking_for_tags as $tag) {
            foreach ($tag->users as $userSingle) {
                if (!in_array($userSingle->user_id, $suggestedIds) && $userSingle->user_id !== $user->id) {
                    $suggestedIds[] = $userSingle->user_id;
                    $userSingle['id'] = $userSingle->user_id;
                }
            }
        }
        $page = (int) $request->get("page", 1);
        $offset = NUMBER_OF_CONTACTS_TO_SHOW * ($page - 1);
        $users = User::whereIn("id", $suggestedIds)->limit(NUMBER_OF_CONTACTS_TO_SHOW)->offset($offset)->with("tags")->select(USER_COLUMNS_TO_GET_SAFE)->get();
        $usersNew = [];
        foreach ($users as $user) {
            $user->is_online = $user->isOnline();
            $usersNew[] = $user->toArray();
        }
        $users = $usersNew;
        $totalCount = count($suggestedIds);
        return [
            "users" => setUserConnectionStatus($users),
            "total" => $totalCount,
            "page" => $page,
            "per_page" => NUMBER_OF_CONTACTS_TO_SHOW,
            "total_pages" => ceil($totalCount / NUMBER_OF_CONTACTS_TO_SHOW),
        ];
    }

    public function allEventAttendees(Request $request)
    {
        $page = (int) $request->get("page", 1);
        $offset = NUMBER_OF_CONTACTS_TO_SHOW * ($page - 1);
        $userQuery = User::whereNotIn("type", NOT_ATTENDEE_USER_TYPES)->whereNotIn("id", [Auth::user()->id]);
        if ($request->has("search") && strlen($request->get("search")) > 0) {
            $userQuery->where("name", "like", "%" . $request->get("search") . "%");
            $userQuery->orWhere("email", "like", "%" . $request->get("search") . "%");
            $userQuery->orWhere("company_name", "like", "%" . $request->get("search") . "%");
            //            $userQuery->orWhere("job_title", "like", "%" . $request->get("search") . "%");
        }
        if ($request->has("tag") && strlen($request->get("tag")) > 0) {
            $tag = UserTag::where("tag", $request->get("tag"))->with("user_id")->first();
            $ids = [];
            foreach ($tag->user_id as $user) {
                $ids[] = $user->user_id;
            }
            $userQuery->whereIn("id", $ids);
        }
        if ($request->has("industry") && strlen($request->get("industry")) > 0) {
            $userQuery->where("industry", $request->get("industry"));
        }
        if ($request->has("company_size") && strlen($request->get("company_size")) > 0) {
            $userQuery->where("company_size", $request->get("company_size"));
        }
        if ($request->has("role") && strlen($request->get("role")) > 0) {
            $userQuery->where("job_title", $request->get("role"));
        }
        $totalCount = $userQuery->count();
        $users = $userQuery->with("tags")->orderBy("points")->limit(NUMBER_OF_CONTACTS_TO_SHOW)->offset($offset)->select(USER_COLUMNS_TO_GET)->get();
        $usersNew = [];
        foreach ($users as $user) {
            $user->is_online = $user->isOnline();
            $usersNew[] = $user->toArray();
        }
        $users = $usersNew;
        return [
            "users" => setUserConnectionStatus($users),
            "total" => $totalCount,
            "page" => $page,
            "per_page" => NUMBER_OF_CONTACTS_TO_SHOW,
            "total_pages" => ceil($totalCount / NUMBER_OF_CONTACTS_TO_SHOW),
        ];
    }

    public function myConnectionRequests(Request $request)
    {
        $user = Auth::user();
        $page = (int) $request->get("page", 1);
        $offset = NUMBER_OF_CONTACTS_TO_SHOW * ($page - 1);
        $connectionRequests = UserConnection::where("connection_id", $user->id)->where("status", 0)->limit(NUMBER_OF_CONTACTS_TO_SHOW)->offset($offset)->with("sender.tags")->get();
        $users = [];
        foreach ($connectionRequests as $connectionRequest) {
            if($connectionRequest->sender){
                $connectionRequest->sender->is_online = $connectionRequest->sender->isOnline();
                $users[] = $connectionRequest->sender->toArray();
            }
        }
        $totalCount = UserConnection::where("connection_id", $user->id)->where("status", 0)->count();
        return [
            "users" => setUserConnectionStatus($users),
            "total" => $totalCount,
            "page" => $page,
            "per_page" => NUMBER_OF_CONTACTS_TO_SHOW,
            "total_pages" => ceil($totalCount / NUMBER_OF_CONTACTS_TO_SHOW),
        ];
    }

    public function mySavedContacts(Request $request)
    {
        $user = Auth::user();
        $page = (int) $request->get("page", 1);
        $offset = NUMBER_OF_CONTACTS_TO_SHOW * ($page - 1);
        $users = [];
        //        $contacts = Contact::where("user_id", $user->id)->with("user.tags")->offset($offset)->limit(NUMBER_OF_CONTACTS_TO_SHOW)->get("contact_id");
        $userQuery = Contact::where("user_id", $user->id)->with("user.tags");
        if ($request->has("search") && strlen($request->get("search")) > 0) {
            $subQuery = User::where("name", "like", "%" . $request->get("search") . "%");
            $subQuery->orWhere("email", "like", "%" . $request->get("search") . "%");
            $subQuery->orWhere("company_name", "like", "%" . $request->get("search") . "%");
            //            $subQuery->orWhere("job_title", "like", "%" . $request->get("search") . "%");
            $searchedIds = $subQuery->get("id");
            $contactIds = [];
            foreach ($searchedIds as $user) {
                $contactIds[] = $user->id;
            }
            $userQuery->whereIn("contact_id", $contactIds);
        }
        if ($request->has("tag") && strlen($request->get("tag")) > 0) {
            $tag = UserTag::where("tag", $request->get("tag"))->with("user_id")->first();
            $ids = [];
            foreach ($tag->user_id as $user) {
                $ids[] = $user->user_id;
            }
            $userQuery->whereIn("contact_id", $ids);
        }
        if ($request->has("industry") && strlen($request->get("industry")) > 0) {
            $userQuery->where("industry", $request->get("industry"));
        }
        if ($request->has("company_size") && strlen($request->get("company_size")) > 0) {
            $userQuery->where("company_size", $request->get("company_size"));
        }
        if ($request->has("role") && strlen($request->get("role")) > 0) {
            $userQuery->where("job_title", $request->get("role"));
        }

        $totalCount = $userQuery->count();
        $contacts = $userQuery->offset($offset)->limit(NUMBER_OF_CONTACTS_TO_SHOW)->get("contact_id");
        foreach ($contacts as $contact) {
            if($contact->user){
                $contact->user->is_online = $contact->user->isOnline();
                $users[] = $contact->user->toArray();
            }
        }
        return [
            "users" => setUserConnectionStatus($users),
            "total" => $totalCount,
            "page" => $page,
            "per_page" => NUMBER_OF_CONTACTS_TO_SHOW,
            "total_pages" => ceil($totalCount / NUMBER_OF_CONTACTS_TO_SHOW),
        ];
    }


    public function addToContacts(Request $request)
    {
        $user = $request->get("user");
        $currentUser = Auth::user()->id;
        $contact = Contact::firstOrCreate([
            "user_id" => $currentUser,
            "contact_id" => $user,
        ]);
        return [
            "success" => (bool) $contact
        ];
    }

    public function removeContact(Request $request)
    {
        $currentUser = Auth::user()->id;
        $user = $request->get("user");
        if ($user && User::find($user)) {
            Contact::where("user_id", $currentUser)->where("contact_id", $user)->delete();
        }
        return [
            "success" => true
        ];
    }

    public function exportContacts()
    {
        $user = Auth::user();
        $users = [];
        $contacts = Contact::where("user_id", $user->id)->with("user")->get("contact_id");
        foreach ($contacts as $contact) {
            $users[] = $contact->user->toArray();
        }
        $users = setUserConnectionStatus($users, $user, true);
        return [
            "users" => $users,
        ];
    }

    public function sendContactsOnMail()
    {
        $user = Auth::user();
        $users = [];
        $contacts = Contact::where("user_id", $user->id)->with("user")->get("contact_id");
        foreach ($contacts as $contact) {
            $_ = $contact->user->toArray();
            $_["hasAnySocial"] = $_["facebook_link"] || $_["twitter_link"]  || $_["linkedin_link"];
            $users[] = $_;
        }
        // $users = setUserConnectionStatus($users, $user, true); // emails are mandatory for mail template

        \Mail::send([], [], function (Message $message) use ($user, $users) {
            $message
                ->to($user->email, $user->name . ' ' . $user->last_name)
                ->from(env("MAIL_FROM_ADDRESS"), env("MAIL_FROM_NAME"))
                ->embedData([
                    'personalizations' => [
                        [
                            'dynamic_template_data' => [
                                'user' => "{$user->name} {$user->last_name}",
                                'users'  => $users,
                            ],
                        ],
                    ],
                    'template_id' => config("services.sendgrid.templates.contacts"),
                ], SendgridTransport::SMTP_API_NAME);
        });

        return ["success" => TRUE];
    }

    public function fetchUserDetails()
    {
        $user = User::where("id", \request()->get("user"))->select(USER_COLUMNS_TO_GET_SAFE)->with("tags")->first();
        if ($user) {
            $user->isOnline = $user->isOnline();
            $user = setUserConnectionStatus([$user->toArray()])[0];
            return [
                "success" => true,
                "user" => $user,
            ];
        }
        return [
            "success" => false,
            "error" => "User not found",
        ];
    }

    public function registerDevice(Request $request)
    {
        $request->validate(["device_id" => "required"]);
        $device_id = $request->input("device_id");
        $user = Auth::user();
        $user->devices()->create(["device_id" => $device_id]);
        return ["success" => true];
    }
}
