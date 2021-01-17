<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Sichikawa\LaravelSendgridDriver\Transport\SendgridTransport;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(["verify" => true]);

Route::get("/", "HomeController@index")->name("home"); //Landing Page

Route::get("/event/login", "AttendeeAuthController@show")->name("attendee_login");
Route::post("/event/login", "AttendeeAuthController@login");
Route::get("/event/register", "AttendeeAuthController@showRegistrationForm")->name("attendee_register");
Route::post("/event/register", "AttendeeAuthController@saveRegistration");
Route::get("/event/session-notifications", "EventController@sendSessionNotifications");

Route::get("privacy-policy", "HomeController@privacyPolicy")->name("privacyPolicy");
Route::get("faq", "HomeController@faqs")->name("faq");
Route::get("schedule", "EventSessionsController@schedule")->name("schedule");
Route::get("/notifications/send", "NotificationController@send")->name("sendNotifications");
Route::get("/confirm-login", "HomeController@confirmLogin")->name("confirmLogin");

Route::middleware(["auth", "verified"])->group(function () { //All Routes here would need authentication to access
    Route::get("/home", "HomeController@dashboard");
    Route::get("/event", "EventController@index")->name("event");
    Route::post("/uploadFile", "CMSController@uploadFile")->name("cms.uploadFile");
    Route::get("/me", "EventController@profileInfo")->name("event.profile");

    Route::post("/contacts/suggested", "UserController@suggestedContacts")->name("suggestedContacts");
    Route::post("/contacts/attendees", "UserController@allEventAttendees")->name("attendeesURL");
    Route::get("/contacts/attendees", "UserController@allEventAttendees")->name("attendeesURL");
    Route::post("/contacts/connection/request", "UserController@sendConnectionRequest")->name("sendConnectionRequest");
    Route::post("/contacts/connection/update", "UserController@updateConnectionRequest")->name("updateConnectionRequest");
    Route::post("/contacts/add", "UserController@addToContacts")->name("addToContacts");
    Route::post("/contacts/remove", "UserController@removeContact")->name("removeContact");
    Route::post("/contacts/saved", "UserController@mySavedContacts")->name("savedContacts");
    Route::post("/contacts/requests", "UserController@myConnectionRequests")->name("myConnectionRequests");
    Route::post("/contacts/export", "UserController@exportContacts")->name("exportContacts");
    Route::post("/contacts/mail", "UserController@sendContactsOnMail")->name("sendContactsOnMail");
    Route::post("/user/details", "UserController@fetchUserDetails")->name("fetchUserDetails");
    Route::post("/user/register-device", "UserController@registerDevice")->name("registerDevice");

    /**
     * POLL ROUTE START
     */
    Route::get("/polls", "PollController@index")->name("poll.manage"); // list all polls
    Route::get("/polls/create", "PollController@create")->name("poll.create.get"); // get create form
    Route::post("/polls/create", "PollController@save")->name("poll.create.post"); // create in db
    Route::get("/polls/{poll}/edit", "PollController@update")->name("poll.update.get");
    Route::put("/polls/{poll}/edit", "PollController@update")->name("poll.update.put");
    Route::delete("/polls/{poll}", "PollController@destroy")->name("poll.delete");
    Route::put("/polls/{poll}/status/{status}", "PollController@updateStatus")->name("poll.status.update");
    Route::get("/polls/{poll}/results", "PollController@resultsView")->name("poll.results"); // View results of poll
    Route::post("/polls/{poll}/results", "PollController@resultsView")->name("poll.results.api"); // View results of poll

    Route::get("by-laws", "PollController@getByLaws")->name("byLaws.get");
    Route::post("by-laws", "PollController@submitByLaws")->name("byLaws.submit");
    Route::post("by-laws/option-select", "PollController@submitByLawsOption")->name("byLaws.optionSubmit");
    /**
     * POLL ROUTE END
     */

    //Admin Prefixed Routes and also will check if user is admin or not
    Route::prefix("admin")->middleware("checkAccess:admin")->group(function () {

        Route::resources([
            "faq" => "FaqController",
            "room" => "RoomController",
            "booth" => "BoothController",
            "user" => "UserController",
            "report" => "ReportController",
            "prize" => "PrizeController",
            //            "provisional" => "ProvisionalController",
        ]);

        /**
         * CHAT USER START
         */
        Route::get("/chat-user/sync", "UserController@syncUserChat")->name("sync-users");
        Route::get("/chat-group/sync", "UserController@syncGroupChat")->name("sync-groups");
        /**
         * CHAT USER END
         */

        Route::get("/options", "CMSController@optionsList")->name("options");
        Route::post("/options/update", "CMSController@optionsUpdate")->name("cms.updateContent");
        Route::get("SortRooms", "RoomController@sort")->name("room.sort");
        Route::get("storesorting", "RoomController@storesort")->name("room.storesorting");

        Route::get("/notifications", "NotificationController@index")->name("notifications.list.get");
        Route::get("/notification/create", "NotificationController@create")->name("notifications.create.get");
        Route::post("/notifications", "NotificationController@store")->name("notifications.create.post");

        //        Route::get("/prizes/distribute", "PrizeController@distributePrize")->name("distribute_prizes");

        Route::post("/user-bulk-upload", "UserController@bulk_create")->name("users.bulk_upload");

        Route::post("/booth/{booth}/publish", "BoothController@publish")->name("booth.publish");
        Route::post("/booth/{booth}/unpublish", "BoothController@unpublish")->name("booth.unpublish");


        /**
         * Event Sessions Routes start
         */
        Route::get("/sessions", "EventSessionsController@index")->name("eventSession.manage");
        Route::post("/sessions", "EventSessionsController@save")->name("eventSession.save");
        Route::get("/session/video-archive", "EventSessionsController@pastSessionVideosArchive")->name("eventSession.videoArchive");
        Route::post("/session/video-archive", "EventSessionsController@savePastSessionVideosArchive")->name("eventSession.saveVideoArchive");
        /**
         * Event Sessions Routes End
         */

        /**
         * Reports and Analytics
         */
        Route::get("/reports/general", "EventController@generalReports")->name("reports.general");
        Route::post("/reports/general", "EventController@generalReportsData")->name("reports.general.api");
        Route::get("/reports/auditorium", "EventController@auditoriumReports")->name("reports.auditorium");
        Route::post("/reports/auditorium", "EventController@auditoriumReportsData")->name("reports.auditorium.api");
        Route::get("/reports/leaderboard/", "EventController@leaderboardView")->name("reports.leaderboard");
    });

    Route::prefix("exhibiter")->middleware("checkAccess:exhibiter")->group(function () {
        Route::get("/booth/edit/{booth}", "BoothController@adminEdit")->name("exhibiter.edit");
        Route::post("/booth/edit/{booth}", "BoothController@adminUpdate")->name("exhibiter.update");
        Route::get("/booth/{booth}/enquiries", "BoothController@boothEnquiries")->name("exhibiter.enquiries");
        // Route::post("/booth/edit/{booth}","BoothController@adminUpdateImages")->name("exhibiter.updateimages");
    });

    Route::prefix("cms")->middleware("checkAccess:cms_manager")->group(function () {
        Route::get("/field/create", "CMSController@createField")->name("cmsField.create");
        Route::post("/field/create", "CMSController@storeField")->name("cmsField.store");
        Route::get("/field/{field}/", "CMSController@editField")->name("cmsField.edit");
        Route::post("/field/{field}/", "CMSController@updateField")->name("cmsField.update");
        Route::post("/field/{field}/delete", "CMSController@deleteField")->name("cmsField.delete");
    });

    Route::post("/event/track", "EventController@trackEvent")->name("trackEvent");
    Route::get("/event/auditorium", "EventController@auditoriumEmbed")->name("auditoriumEmbed");
    Route::get("/event/meet", "EventController@meetEmbed")->name("meetEmbed");
    Route::get("/event/current-session", "EventController@getCurrentSession")->name("currentSession");
    Route::get("/event/webinar", "EventController@webinar")->name("webinar");
    Route::get("/event/ended", "EventController@webinarEnded")->name("webinarEnded");
    Route::post("/event/{event}/subscribe", "EventSessionsController@subscribe")->name("event.subscribe");
    Route::post("/event/{event}/unsubscribe", "EventSessionsController@unsubscribe")->name("event.unsubscribe");

    Route::post("/leaderboard", "EventController@leaderboard")->name("leaderboard");
    Route::get("/add-to-bag", "EventController@addToBag")->name("addToBag");
    Route::get("/delete-from-bag", "EventController@deleteFromBag")->name("deleteFromBag");
    Route::get("/get-swag-bag", "EventController@getSwagBag")->name("getSwagBag");
    //Add Profile Image
    Route::post("/save-profile-image", "EventController@saveprofile")->name("saveprofile");
    Route::post("/saveprofile", "EventController@updateProfile")->name("updateProfile");
    Route::middleware(["checkAccess:exhibiter"])->group(function () {
        Route::get("/changepassword", "UserController@changePassword")->name("changePassword");
        Route::post("/updatepassword", "UserController@updatePassword")->name("updatePassword");
    });
    Route::get("/send-swags-to-email", "EventController@sendSwagsToEmail")->name("sendSwagsToEmail");
    Route::get("/booth/{booth}", "EventController@getBoothDetails")->name("boothDetails");
    Route::post("/booth/{booth}/show-interest", "EventController@showInterestInBooth")->name("showInterestInBooth");
    Route::get("/delegates-list", "EventController@getDelegatesList")->name("delegateList");
    Route::post("/updates/check", "EventController@contentTicker")->name("contentTicker");
    Route::get("/updates/check", "EventController@contentTicker")->name("contentTicker");
});

Route::get("/refresh-online-users-status", function () {
    $loginLastTime = Carbon::now()->subtract(ONLINE_KEEPING_TIME, "seconds");
    $a = \App\User::where("updated_at", ">=", $loginLastTime)->count();
    $minToShowOnline = 2500;
    $q = \App\User::where("updated_at", "<=", $loginLastTime);
    $users = $q->orderBy("email")->limit($minToShowOnline - $a)->select("id")->get();
    foreach ($users as $user) {
        $user->touch();
    }
    $a = \App\User::where("updated_at", ">=", $loginLastTime)->count();
    return $a;
});

Route::get("/delete-users", function () {
    //    $user = \App\User::create([
    //        "name" => "Admin",
    //        "email" => "dev@fitsmea.com",
    //        "type" => "admin",
    //        "password" => Hash::make("chintan"),
    //    ]);
    $user = \App\User::find("420f7f67-e4d2-4316-9071-e2ad5c805900");
    $user->markEmailAsVerified();
    $user->update([
        "type" => "cms_manager",
    ]);
    //    User::find(3)
    return \App\User::all();
});


Route::get('lv-logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
