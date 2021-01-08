<?php

namespace App\Http\Controllers;

use App\LoginLog;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Points;
use Http;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;
use Sichikawa\LaravelSendgridDriver\Transport\SendgridTransport;

class AttendeeAuthController extends Controller
{

    public function __construct()
    {
        $this->loginT = getLoginVars();
    }

    // method to show the login page
    public function show()
    {
        $user = Auth::user();
        if ($user) {
            return redirect("/event");
        } else {
            return view("auth.attendee_login")->with([
                "login" => $this->loginT,
                "notFound" => FALSE,
                "captchaError" => FALSE
            ]);
        }
    }

    // method to attempt login
    public function login(Request $request)
    {
        $response = Http::asForm()
            ->post(
                "https://www.google.com/recaptcha/api/siteverify",
                [
                    "secret" => env("RECAPTCHA_SECRET_KEY"),
                    "response" => $request->post("token")
                ]
            );

        $Response = json_decode($response->body(), TRUE);

        if (!$response->successful() || !$Response["success"]) {
            $request->old(env("ATTENDEE_LOGIN_FIELD"), $request->post(env("ATTENDEE_LOGIN_FIELD")));
            return view("auth.attendee_login")
                ->with([
                    "notFound" => FALSE,
                    "captchaError" => TRUE,
                    "login" => $this->loginT
                ]);
        }

        $validation =  env("ATTENDEE_LOGIN_FIELD") == "email" ? "required|email" : "required";
        $request->validate([env("ATTENDEE_LOGIN_FIELD") => $validation]);
        $user = User::with('tags.looking_users')->where(env("ATTENDEE_LOGIN_FIELD"), $request->post(env("ATTENDEE_LOGIN_FIELD")))
            //            ->whereIn("type", USER_TYPES_TO_LOGIN_WITH_MEMBERSHIP_ID)
            ->whereNotIn("type", ["admin", "teller", "moderator", "exhibiter", "cms_manager"])
            ->first();

        if (!$user) {
            $request->old(env("ATTENDEE_LOGIN_FIELD"), $request->post(env("ATTENDEE_LOGIN_FIELD")));
            return view("auth.attendee_login")->with([
                "notFound" => TRUE,
                "captchaError" => FALSE,
                "login" => $this->loginT
            ]);
        } else {
            // if ($user->type == 'attendee' && env("APP_ENV") != "local") {
            //     return view("auth.attendee_login")->with([
            //         "notFound" => TRUE,
            //         "captchaError" => FALSE,
            //         "login" => $this->loginT
            //     ]);
            // }
            \DB::table("sessions")->where("user_id", $user->id)->whereNotIn("id", [session()->getId()])->delete();
            Auth::login($user);
            LoginLog::create(["ip" => $request->ip(), "user_id" => $user->id]);
            $pointsDetails = [
                "points_to" => $user->id,
                "points_for" => "login",
                "details" => "",
                "points" => LOGIN_POINTS,
            ];
            if (!Points::where($pointsDetails)->count()) {
                Points::create($pointsDetails);
                $user->update([
                    "points" => DB::raw('points+' . LOGIN_POINTS),
                ]);
            }
            //Users to whoom we have to notify about the recent login of current user
            foreach ($user->tags as $tag) {
                foreach ($tag->looking_users as $looking_user) {
                    $looking_user->sendNotification("suggested_user_login", "One of your suggested users just logged in. Visit attendees section to grow your network.", "info", $user->id);
                }
            }
            $user->touch();
            return redirect("/event");
        }
    }

    public function showRegistrationForm()
    {
        return view("auth.register_attendee");
    }

    public function saveRegistration(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'name' => 'required',
        ]);
        $user = new User($request->all());
        $user->password = Hash::make($request->get('_token'));
        $user->save();
        $user->sendEmailVerificationNotification();
        Auth::login($user);
        Mail::send([], [], function (Message $message) use ($user) {
            $message
                ->to($user->email)
                ->from(env("MAIL_FROM_ADDRESS"), env("MAIL_FROM_NAME"))
                ->embedData([
                    'personalizations' => [
                        [
                            'dynamic_template_data' => [
                                'user' => "{$user->name} {$user->last_name}",
                                'email'  => $user->email,
                            ],
                        ],
                    ],
                    'template_id' => config("services.sendgrid.templates.register"),
                ], SendgridTransport::SMTP_API_NAME);
        });
        // return redirect(route("attendee_login"));
        return redirect(route("event"));
    }
}
