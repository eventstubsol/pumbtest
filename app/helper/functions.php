<?php
//All functions defined in this file will be accessible all through the project including View
use App\Content;
use App\Poll;
use App\User;
use App\Vote;
use App\EventSession;
use App\SessionPoll;
use App\ArchiveVideos;
use App\UserConnection;
use App\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use \SendGrid\Mail\From as From;
use \SendGrid\Mail\To as To;
use \SendGrid\Mail\Mail as Mail;
use Illuminate\Support\Facades\Date;
use Carbon\Carbon;

include_once "clickableAreasConfig.php";

define("USER_TYPE_DELEGATE", "delegate");
define("BY_LAWS_POLL", "b0e7dbbd-a6f3-4898-9a08-a188de3a0884");

define("SUPPORT_USER", "996a2068-2a26-482b-bcdb-8baa4c9ba1d7");


define("SESSION_POLL_TIME", 60); //Session Poll Timing in minutes

define("BOOTH_TYPES", [
    "candidate_standard",
    "candidate_gold",
    "candidate_platinum",
    "sponsor_standard",
    "sponsor_gold",
    "sponsor_platinum",
    "vendor",
    "national_partners",
    "foundation",
    "american_family"
]);

define("PERMANANT_SWAGS",[
//     ["id" => "souvenir","resource"=>["url"=>"https://jjoainc.ams3.cdn.digitaloceanspaces.com/uploads/Souvenir%20Journal%20.pdf","title"=>"Souvenir Journal .pdf"],"permanent"=>true]
]);

define("CMS_SECTIONS", [
    "General",
    "Creatives",
]);

define("CMS_FIELD_TYPES", [
    "text",
    "number",
    "textarea",
    "url",
    "youtube",
    "image",
    "video",
]);

define("ROOM_TYPES", [
    "standard",
    "gold",
    "platinum",
]);

define("REGIONS", [
    "central",
    "eastern",
    "far-west",
    "mid-atlantic",
    "mid-western",
    "south-central",
    "south-eastern",
]);

define("REGIONS_NAMES_TO_VALUE", [
    "east" => REGIONS[1],
    "far west" => REGIONS[2],
    "mid atlantic" => REGIONS[3],
    "mid western" => REGIONS[4],
    "south central" => REGIONS[5],
    "south eastern" => REGIONS[6],
    "south east" => REGIONS[6],
]);

define("CAUCUS_REGIONS", [
    "Central",
    "Eastern",
    "Far West",
    "Mid Atlantic",
    "Mid Western",
    "South Central",
    "South Eastern",
]);

define("USER_TYPE_MODERATOR", "moderator");
define("USER_TYPE_SPEAKER", "speaker");

define("USER_TYPES", [
    "attendee",
    "exhibiter",
    USER_TYPE_SPEAKER,
]);

define("USER_TYPES_TO_LOGIN_WITH_MEMBERSHIP_ID", [
    "attendee",
]);

define("NOT_ATTENDEE_USER_TYPES", [
    "admin",
    "super_admin",
]);

define("NUMBER_OF_CONTACTS_TO_SHOW", 20);

define("CANDIDATES_BOOTH_ROOM", "9371ce28-c9c8-4851-a877-74a9f7b1ab7c");
define("ONLINE_KEEPING_TIME", 3600);
//define("ONLINE_KEEPING_TIME", 3600);

/**
 * Safe one is without email address
 */
define("USER_COLUMNS_TO_GET_SAFE", [
    "id",
    "name",
    "last_name",
    "job_title",
    "company_name",
    "country",
    "industry",
    "profileImage",
    "updated_at",
    "bio",
    "facebook_link",
    "twitter_link",
    "linkedin_link",
    "website_link",
    "company_website_link",
]);

define("USER_COLUMNS_TO_GET", [
    "id",
    "name",
    "email",
    "last_name",
    "job_title",
    "profileImage",
    "company_name",
    "country",
    "industry",
    "updated_at",
    "bio",
    "facebook_link",
    "twitter_link",
    "linkedin_link",
    "website_link",
    "company_website_link",
]);
/*
 * 1. Candidate Booth
 * 2. Sponsors & National Partners (With Foundation Booth)
 * 3. Vendors Booth
 */

define('EXPO_HALL_ROOMS', [
    [ "ca9d92bd-e5a1-4392-9659-b65d9c857310", "ExpoFloor 1" ],
    [ "d4021162-16a5-43a2-aba1-005ac9507717", "ExpoFloor 2" ],
]);

//Event Session Rooms
define('EVENT_ROOM_AUDI', "AUDITORIUM");
define('EVENT_ROOM_CAUCUS', "CAUCUS");
define('EVENT_ROOM_WORKSHOP', "WORKSHOP");

define('EVENT_ROOMS', [
    EVENT_ROOM_AUDI,
    EVENT_ROOM_WORKSHOP,
]);

//Event Session Types
define('ZOOM_SESSION', "ZOOM_SESSION");
define('AUDI_SESSION', "AUDI_SESSION");
define('VIMEO_SESSION', "VIMEO_SESSION");

define("EVENT_SESSION_TYPES", [
    ZOOM_SESSION,
    AUDI_SESSION,
    VIMEO_SESSION,
]);

define("CREATOR_TELLER_LINKS", [
    "51b46d28-6923-444d-9ab8-e3478bb6ff07" => "d01c8491-fd30-434b-bead-f17ddbe843e4", //NNC TELLER => NNC Moderator
    "500474c9-0227-4d30-a6c5-610cc30390fd" => "9ddfb8f9-799a-4b7e-bb52-eaa59fce6d6a", //NRS TELLER => NRS Moderator
]);

define("BY_LAWS_TELLER_ID", "280fd217-8106-46fc-a36b-c5c38b1a3823");

function getAllFields()
{
    return Content::all();
}

function getField($name, $default = "")
{
    $content = Content::where("name", $name)->first();
    return $content ? $content->value : $default;
}

function getBooths()
{
    return Auth::User()->load("booths")->booths;
}

function getModeratorSessions()
{
    return Auth::User()->load("event_session.session")->event_session;
}

function getboothImages()
{
    return BOOTH_IMAGE_AREA_SLOTS;
}


function areaStyles($area)
{
    if(count($area) == 3){
        return "top: $area[0]%;left: $area[1]%;width: $area[2]%;";
    }
    return "top: $area[0]%;left: $area[1]%;width: $area[2]%;height: $area[3]%;";
}

function assetUrl($url = "")
{
    return env("DO_PUBLIC_URL") . $url;
}

function storageUrl($url = "")
{
    return "https://storage.googleapis.com/fits/" . $url;
}

function getScavengerItems($page)
{
    return "";
    $toReturn = "";
    if (isset(SCAVENGER_HUNT[$page])) {
        foreach (SCAVENGER_HUNT[$page] as $index => $item) {
            $toReturn .= "
            <div class='scavenger-item positioned' data-page='$page' data-index='$index' style='" . areaStyles($item['area']) . "' data-name='" . $item['name'] . "' title='" . $item['name'] . "' >
                <img class='fill positioned' src='" . asset($item['image']) . "' style='object-fit:contain;' alt='' />
            </div>
            ";
        }
    }
    return $toReturn;
}

/**
 * @param string $templateId Template ID
 * @param string $email Email to which you want to send the mail
 * @param array $content Associative array for populating the data in the template
 * @return bool **TRUE** if response status is `2xx`, otherwise **FALSE**
 */
function sendMail($templateId, $email, $content)
{
    $sg = new SendGrid(env("SG_API"));
    $email = strtolower($email);
    $from = new From(env("SG_FROM_MAIL"), env("SG_FROM_NAME"));

    $to = new To($email);

    $sgmail = new Mail($from, $to);
    $sgmail->setTemplateId($templateId);
    $sgmail->addDynamicTemplateDatas($content);
    try {
        $response = $sg->send($sgmail);
        return $response->statusCode() == 202;
    } catch (Exception $th) {
        return FALSE;
    }
}

function sendNotifications()
{
    $response = Http::withHeaders([
        "Authorization" => "Basic " . env("ONESIGNAL_API_KEY"),
    ])->post('https://onesignal.com/api/v1/notifications', [
        "app_id" => env("ONESIGNAL_APP_ID"),
        "template_id" => env("ONESIGNAL_POLL_START_TEMPLATE"),
        "included_segments" => [
            "Delegates"
        ],
        "url" => route("event") . "#faq", //We can customize this url to give the poll page route and frontend can show the Route as per need
    ]);
    return $response;
}

/**
 * @param string $title Title of the notification
 * @param string $message Message body of the notifiction
 * @param string $url Action URL (Optional)
 * @param array $segments Segments of users to send the message
 * @return \Illuminate\Http\Client\Response
 */
function sendGeneralNotification($title, $message, $url = NULL, $segments = ["All"])
{
    $response = NULL;
    if ($url) {
        $response = Http::withHeaders([
            "Authorization" => "Basic " . env("ONESIGNAL_API_KEY")
        ])
            ->post("https://onesignal.com/api/v1/notifications", [
                "app_id" => env("ONESIGNAL_APP_ID"),
                "url" => $url,
                "included_segments" => $segments,
                "headings" => array("en" => $title),
                "contents" => array("en" => $message)
            ]);
    } else {
        $response = Http::withHeaders([
            "Authorization" => "Basic " . env("ONESIGNAL_API_KEY")
        ])
            ->post("https://onesignal.com/api/v1/notifications", [
                "app_id" => env("ONESIGNAL_APP_ID"),
                "included_segments" => $segments,
                "headings" => array("en" => $title),
                "contents" => array("en" => $message)
            ]);
    }

    return $response;
}

/**
 * @param Poll $poll Poll to check
 * @return int Status of poll (0 = Yet to begin, 1 = Ongoing, 2 = Complete)
 */
function checkPollStatus(Poll $poll, $checkBoundaries = true, $checkStatus = false){
    if($poll->status == 2){
        return 2;
    }
    if($checkBoundaries){
        if($poll->start_date->startOf("day")->isPast()){
            if($poll->end_date->endOf("day")->isPast()){
                //End of day is in past - poll completed
                return 2;
            }
            return 1;
        }
        //Start of day is in future so not started
        return 0;
    }
    //Check precision date/time
    if($poll->start_date->isPast()){
        if($poll->end_date->isPast()){
            //End date is in past - poll completed
            return 2;
        }
        return 1;
    }
    //Start date is in future so not started
    return 0;
}
function generateSignature( $meeting_number ){
    $api_key = env("ZOOM_API_KEY");
    $api_secret = env("ZOOM_API_SECRET");
    $role = 0; //Attendee

    $time = time() * 1000 - 30000;//time in milliseconds (or close enough)

    $data = base64_encode($api_key . $meeting_number . $time . $role);

    $hash = hash_hmac('sha256', $data, $api_secret, true);

    $_sig = $api_key . "." . $meeting_number . "." . $time . "." . $role . "." . base64_encode($hash);

    //return signature, url safe base64 encoded
    return rtrim(strtr(base64_encode($_sig), '+/', '-_'), '=');
}

function getZoomParameters($meeting_number, $password){
    $user = Auth::user();
    if(!$user) return false;
    $api_key = env("ZOOM_API_KEY");
    $name = $user->name ? $user->name : "Anonymous";
    if($user->last_name){
        $name .= " ". $user->last_name;
    }
    $parameters = [
        "name" => base64_encode($name),
        "email" => base64_encode($user->email),
        "mn" => $meeting_number,
        "pwd" => $password,
        "role" => 0, //Attendee always
        "lang" => "en-US",
        "signature" => generateSignature($meeting_number),
        "china" => 0,
        "apiKey" => $api_key
    ];
    return $parameters;
}

function getPollNonVoters($pollId,$userType = false){
    return [];
    $toShow = ["id", "name", "email", "type", "last_name", "member_id", "region_name" ];
    if($userType){
        $users = User::whereType($userType)->get(["id"]);
    }else{
        $users = User::get(["id"]);
    }
    $ids_all = array_map(function ($user) {
        return $user["id"];
    }, $users->toArray());

    $voters = Vote::whereStatus(1)->whereIn("user_id", $ids_all)->where("poll_id", $pollId)->get(["user_id"]);


    $ids_voters = array_map(function ($user) {
        return $user["user_id"];
    }, $voters->toArray());

    $result = array_diff($ids_all, $ids_voters);
    if($userType){
        $nonVoters = User::where("type", $userType)->whereIn("id", $result)->get($toShow);
    }else{
        $nonVoters = User::whereIn("id", $result)->get($toShow);
    }

    return $nonVoters;
}

function toShowCandidateBooth($id = ''){
     return true;
    if($id == CANDIDATES_BOOTH_ROOM){
        return false;
        $now = Date::now();
        $showAfter = Date::parse("Friday 4:00 PM");
        $showBefore = Date::parse("Friday 6:00 PM");
        return $now->isDayOfWeek(Carbon::FRIDAY) && $now->isBetween($showAfter, $showBefore);
    }
    return true; 
}

function getSessionPoll(EventSession $session, $sendPoll = false){
    $polls = $session->load([
        "polls.poll.questions.options"
    ])->polls;
    foreach ($polls as $poll) {
        if(
            $poll->poll->status &&
            $poll->poll->status != 2 &&
            $poll->poll->start_date &&
            $poll->poll->start_date->isPast() &&
            $poll->poll->end_date &&
            !$poll->poll->end_date->isPast()
        ){
            if($sendPoll){
                return $poll;
            }
            return $poll->poll;
        }
    }
    return false;
}

function isSessionActive(EventSession $session){
    return $session->start_time && $session->start_time->isPast() && $session->end_time && !$session->end_time->add(5, "mins")->isPast();
}

function getCurrentSession($where){
    $sessions = EventSession::where("room", $where)->get();
    foreach ($sessions as $session){
        if(isSessionActive($session)){
           return $session;
        }
    }
    return false;
}

function getTellerPolls(){
    $user = Auth::user();
    $polls = [];
    if(isset(CREATOR_TELLER_LINKS[$user->id])){
        $creator = CREATOR_TELLER_LINKS[$user->id];
        $curatedPolls = SessionPoll::where("creator", $creator)->get();
        $pollIds = [];
        foreach ($curatedPolls as $poll){
            $pollIds[] = $poll->poll_id;
        }
        $polls = Poll::with("questions")->whereIn("id", $pollIds)->orderBy("created_at", "desc")->get();
    }else if(BY_LAWS_TELLER_ID === $user->id){
        $polls[] = Poll::where("id", BY_LAWS_POLL)->orderBy("created_at", "desc")->withCount("questions")->first();
    }
    return $polls;
}

function getPastSessionVideos(){
    return ArchiveVideos::all();
}

function isOpenForPublic($item){
//     return true;
// "lounge",
// "photo-booth",
// "booths",
// "leaderboard",
// "delegates",
// "swagbag",
// "library"
$itemsLocked = [
    "meet-and-greet",
    "chat"
//        "caucus",
    ];
    return !in_array($item,$itemsLocked);
}

function getLoginVars(){
    return [
        "field" => env("ATTENDEE_LOGIN_FIELD"),
        "placeholder" => env("ATTENDEE_LOGIN_PLACEHOLDER"),
        "text" => env("ATTENDEE_LOGIN_TEXT"),
        "label" => env("ATTENDEE_LOGIN_LABEL")
    ];
}

function getProfileDetails($user = false){
    if(!$user){
        $user = Auth::user();
    }
    if(!$user->tags || !$user->looking_for_tags || !$user->interests){
        $user->load([
            "tags",
            "looking_for_tags",
            "interests",
        ]);
    }
    $toSend = [
        "user" => $user,
    ];
    return $toSend;
}

function checkUserConnection($userId, $connectionId){
    //TODO: Make Connetions table and check from table if user is connected or not
    return $userId === $connectionId;
}

function setUserConnectionStatus($users, $currentUser = false, $removeIds = false){
    if(!is_array($users)){
        $users = $users->toArray();
    }
    if(!$currentUser){
        $currentUser = Auth::user();
    }
    foreach ($users as $index => $user){
        $connection = getConnection($user['id'], $currentUser->id);
        $contact = Contact::where("user_id", $currentUser->id)->where("contact_id", $user['id'])->select("id")->first();
        if($connection){
            $users[$index] = array_merge($user, $connection);
        }
        if(!$connection || $connection['connection_status'] !== 1){
            unset($users[$index]["email"]);
        }
        if($contact){
            $users[$index]["is_contact"] = true;
        }
        if($removeIds){
            unset($users[$index]['id']);
            unset($users[$index]['is_contact']);
            unset($users[$index]['updated_at']);
        }
    }
    return $users;
}

function getConnection($userId, $connectionId, $type = "sent"){
    $conn = UserConnection::where("connection_id", $userId)->where("user_id", $connectionId)->select(["status", "id"])->first();
    if($conn){
        return [
            'connection_status' => $conn->status,
            'connection_id' => $conn->id,
            'connection_type' => $type,
        ];
    }else if($type === "sent"){
        return getConnection($connectionId, $userId,"received");
    }
    return false;
}

function getContact($user, $currentUser = false){
    if(!$currentUser){
        $currentUser = Auth::user()->id;
    }
    $contact = Contact::where("user_id", $currentUser)->where("contact_id", $user)->select("id")->first();
    if($contact){
        return $contact->id;
    }
    return false;
}

function getSuggestedTags(){
    $toSend = [
        "Cyber security",
        "Storage",
        "Infrastructure",
        "Networking",
        "DRAAS",
        "Back up and recovery",
        "VDI",
        "Display solutions",
        "AV Solutions",
        "IT/OT Security",
        "PAM",
        "Enterprise Security",
        "Other",
    ];
//    $tags = \App\UserTag::get("tag");
//    foreach ($tags as $tag) {
//        $toSend[] = $tag->tag;
//    }
    return $toSend;
}

function getSchedule(){
    $schedule = [];
    $eventsLineup = EventSession::orderBy("start_time")->with("speakers.speaker")->get();
    foreach ($eventsLineup as $event){
        if(!isset($schedule[$event->room])){
            $schedule[$event->room] = [];
        }
        $now = Carbon::now();
        $status = 0; //Not Started
        if($now->isAfter($event->end_time)){
            $status = -1; //Already ended
        }else if($now->isBetween($event->start_time,$event->end_time)){
            $status = 1; //Ongoing
        }else if($now->clone()->add(15, "minutes")->isAfter($event->start_time)){
            $status = 3; //Starting soon
        }
        $schedule[$event->room][$event->id] = [
            "start_time" => $event->start_time->utc()->toString(),
            "start_date" => [
                "m" => $event->start_time->format("l, M dS"),
                "dts" => $event->start_time->format("h:i A"),
                "dte" => $event->end_time->format("h:i A"),
            ],
            "end_time" => $event->end_time->toString(),
            "status" => $status,
            "name" => $event->name,
            "description" => $event->description,
            "speakers" => $event->speakers,
            "recording" => $event->past_video ? $event->past_video : false,
        ];
    }
    return $schedule;
}

function getRoomRoute($room){
    $roomRouteMap = [
        "AUDITORIUM" => "auditorium",
        "WORKSHOP" => "workshop",
    ];
    if(isset($roomRouteMap[$room])){
        return $roomRouteMap[$room];
    }
    return false;
}