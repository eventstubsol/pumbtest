<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\UUID;

/**
 * App\User
 *
 * @property string $id
 * @property string $name
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string $type
 * @property \Illuminate\Database\Eloquent\Collection|\App\Points[] $points
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $profileImage
 * @property bool $isCometChatAccountExist
 * @property string|null $middle_name
 * @property string|null $last_name
 * @property string|null $member_id
 * @property string|null $region_name
 * @property string|null $salutation
 * @property string|null $phone_number
 * @property string|null $street
 * @property string|null $street_2
 * @property string|null $street_3
 * @property string|null $state
 * @property string|null $postal
 * @property string|null $city
 * @property string|null $role
 * @property string|null $tshirt_size
 * @property int $online_status
 * @property string|null $current_page
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Booth[] $booths
 * @property-read int|null $booths_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SessionModerator[] $event_session
 * @property-read int|null $event_session_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read int|null $points_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Swagbag[] $swagbag
 * @property-read int|null $swagbag_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Vote[] $votes
 * @property-read int|null $votes_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCurrentPage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsCometChatAccountExist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereOnlineStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePostal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereProfileImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRegionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSalutation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStreet2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStreet3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTshirtSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\User withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\LoginLog[] $login_logs
 * @property-read int|null $login_logs_count
 * @property string|null $phone
 * @property string|null $job_title
 * @property string|null $company_name
 * @property string|null $country
 * @property string|null $industry
 * @property string|null $bio
 * @property string|null $facebook_link
 * @property string|null $twitter_link
 * @property string|null $linkedin_link
 * @property string|null $website_link
 * @property string|null $company_website_link
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Contact[] $contact_users
 * @property-read int|null $contact_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Contact[] $contacts
 * @property-read int|null $contacts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UserTag[] $looking_for_tags
 * @property-read int|null $looking_for_tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UserConnection[] $requests
 * @property-read int|null $requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UserConnection[] $requests_sent
 * @property-read int|null $requests_sent_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UserTagLinks[] $tagLinks
 * @property-read int|null $tag_links_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UserLookingTagLinks[] $tagLookingLinks
 * @property-read int|null $tag_looking_links_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UserTag[] $tags
 * @property-read int|null $tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Notification[] $unread_notifications
 * @property-read int|null $unread_notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Notification[] $unsent_notifications
 * @property-read int|null $unsent_notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCompanyWebsiteLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFacebookLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIndustry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereJobTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLinkedinLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwitterLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereWebsiteLink($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Device[] $devices
 * @property-read int|null $devices_count
 * @property string|null $company_size
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UserInterests[] $interests
 * @property-read int|null $interests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\EventSubscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCompanySize($value)
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;
    use UUID;
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone',
        'job_title',
        'company_name',
        'country',
        'industry',
        'profileImage',
        'bio',
        'online_status',
        'current_page',
        'company_size',
        'password',
        'type',
        'last_name',
        'points',
        'facebook_link',
        'twitter_link',
        'linkedin_link',
        'website_link',
        'company_website_link',
        'isCometChatAccountExist',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function points()
    {
        return $this->hasMany("\App\Points", "to");
    }

    public function getFullName()
    {
        return $this->name . " " . $this->last_name;
    }

    public function swagbag()
    {
        return $this->hasMany("\App\Swagbag");
    }

    public function booths()
    {
        return $this->hasManyThrough("\App\Booth", "\App\BoothAdmin", "user_id", "id", "id", "booth_id");
    }

    public function votes()
    {
        return $this->hasMany("App\Vote");
    }

    public function event_session()
    {
        return $this->hasMany("\App\SessionModerator");
    }

    public function tags()
    {
        return $this->belongsToMany('\App\UserTag', 'user_tag_links', 'user_id', 'tag_id')->orderBy("tag");
    }

    public function tagLinks()
    {
        return $this->hasMany('\App\UserTagLinks', 'user_id');
    }
    public function tagLookingLinks()
    {
        return $this->hasMany('\App\UserLookingTagLinks', 'user_id');
    }

    public function looking_for_tags()
    {
        return $this->belongsToMany('\App\UserTag', 'user_tag_looking_links', 'user_id', 'tag_id')->orderBy("tag");
    }

    public function requests()
    {
        return $this->hasMany("\App\UserConnection", "connection_id")->where("status", "0");
    }

    public function requests_sent()
    {
        return $this->hasMany("\App\UserConnection", "user_id")->where("status", "0");
    }

    public function requestConnection()
    {
        $authenticatedUser = \Auth::user();
        $this->requests()->create([
            "user_id" => $authenticatedUser->id
        ]);
        $this->notifications()->create([
            "type" => "info",
            "action_type" => "connection_received",
            "title" => "You have received a connection request from " . $authenticatedUser->getFullName(),
            "user_id" => $this->id,
            "action_id" => $authenticatedUser->id,
        ]);
        return $this;
    }

    public function sendNotification($action, $title, $type = "info", $action_id = "")
    {
        if(!$this->id && $this->user_id){
            $this->id = $this->user_id;
        }
        if($this->id){
            $this->notifications()->create([
                "type" => $type,
                "action_type" => $action,
                "title" => $title,
                "action_id" => $action_id,
            ]);
        }
        return $this;
    }

    public function contacts()
    {
        return $this->hasMany("\App\Contact");
    }

    public function contact_users()
    {
        return $this->hasMany("\App\Contact");
    }

    public function notifications()
    {
        return $this->hasMany("\App\Notification");
    }

    public function unread_notifications()
    {
        return $this->hasMany("\App\Notification")->where("read", 0);
    }

    public function unsent_notifications()
    {
        return $this->hasMany("\App\Notification")->where("sent", 0);
    }

    public function markNotificationsAsSent()
    {
        $this->unsent_notifications()->update([
            "sent" => 1,
        ]);
        return $this;
    }

    public function isOnline()
    {
        return $this->updated_at->isAfter(\Carbon\Carbon::now()->subtract(ONLINE_KEEPING_TIME, "seconds"));
    }

    public function subscriptions()
    {
        return $this->hasMany("\App\EventSubscription")->select(["session_id", "user_id"]);
    }

    public function markNotificationsAsRead()
    {
        $this->unsent_notifications()->update([
            "read" => 1,
        ]);
        return $this;
    }

    public function devices()
    {
        return $this->hasMany("\App\Device");
    }

    public function interests()
    {
        return $this->hasMany("\App\UserInterests");
    }

    public function sendPushNotification($title, $link = false)
    {
        //TODO: Send Onesignal notification to all the current user's devices here
    }
}
