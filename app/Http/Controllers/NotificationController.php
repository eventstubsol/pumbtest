<?php

namespace App\Http\Controllers;

use App\Device;
use App\Notification;
use App\PushNotification;
use App\User;
use Http;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Mail;
use Sichikawa\LaravelSendgridDriver\Transport\SendgridTransport;
use URL;

class NotificationController extends Controller
{
    public function index()
    {
       $notifications = PushNotification::orderBy("created_at")->get();
        $notifications = [];
        return view("notification.list")->with(compact("notifications"));
    }

    public function create()
    {
        return view("notification.create");
    }

    public function store(Request $request)
    {
        $request->validate(["title" => "required|max:255", "message" => "required|max:255", "roles" => "required|array|min:1"]);
        if ($request->post("url", NULL)) {
            $request->validate(["url" => "url"]);
        }

        $resp = sendGeneralNotification($request->post("title"), $request->post("message"), $request->post("url", NULL), $request->post("roles"));


        if ($resp->successful()) {
           PushNotification::create([
               "title" => $request->post("title"),
               "url" => $request->post("url", NULL),
               "message" => $request->post("message"),
               "roles" => implode(", ", $request->post("roles")),
           ]);

            $notifications = PushNotification::orderBy("created_at")->get();
            return view("notification.list")->with(compact("notifications"));
        } else {
            return $resp->body();
        }
    }

    public function send(Request $request)
    {
        $key = $request->get("key");
        if ($key != env("WEBHOOK_KEY")) {
            return abort(404);
        }
        $users = User::has("unsent_notifications")
            ->with("unsent_notifications")
            ->limit(10)
            ->get(["id", "name", "email"]);

        $users->map(function (User $user) {
            $message = "You have <b>{$user->unsent_notifications()->count()}</b> updates pending";
            if ($user->unsent_notifications()->count() == 1) {
                $message = $user->unsent_notifications()->get()[0]->title;
            }

            // sending on the devices
            $devices = Device::whereUserId($user->id);
            if ($devices->count() > 0) {
                $ids = [];
                $devices->get()->map(function (Device $device) use ($ids) {
                    $ids[] .= $device->device_id;
                });

                Http::withHeaders([
                    "Authorization" => "Basic " . env("ONESIGNAL_API_KEY")
                ])
                    ->post("https://onesignal.com/api/v1/notifications", [
                        "app_id" => env("ONESIGNAL_APP_ID"),
                        "url" => URL::route('event') . '#attendees',
                        "headings" => array("en" => "Pending Updates"),
                        "contents" => array("en" => $message),
                        "include_player_ids" => $ids
                    ]);
            }

            // sending on the mail
            Mail::send([], [], function (Message $email) use ($message, $user) {
                $email
                    ->to($user->email)
                    ->from(env("MAIL_FROM_ADDRESS"), env("MAIL_FROM_NAME"))
                    ->embedData([
                        'personalizations' => [
                            [
                                'dynamic_template_data' => [
                                    'user' => "{$user->name} {$user->last_name}",
                                    'message'  => $message,
                                    'link' => URL::route("event") . '#attendees'
                                ],
                            ],
                        ],
                        'template_id' => config("services.sendgrid.templates.notifications"),
                    ], SendgridTransport::SMTP_API_NAME);
            });

            $user->markNotificationsAsRead()->save();
        });

        return "Sent";
    }
}
