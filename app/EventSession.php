<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UUID;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\EventSession
 *
 * @property string $id
 * @property string $room
 * @property string|null $name
 * @property string $type
 * @property string|null $vimeo_url
 * @property string|null $zoom_webinar_id
 * @property string|null $zoom_password
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $start_time
 * @property \Illuminate\Support\Carbon|null $end_time
 * @property string|null $region
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SessionModerator[] $moderators
 * @property-read int|null $moderators_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SessionPoll[] $polls
 * @property-read int|null $polls_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SessionSpeaker[] $speakers
 * @property-read int|null $speakers_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\EventSession onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereRoom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereVimeoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereZoomPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EventSession whereZoomWebinarId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EventSession withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\EventSession withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $past_video
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\EventSubscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @method static \Illuminate\Database\Eloquent\Builder|EventSession wherePastVideo($value)
 */
class EventSession extends Model
{
    use UUID;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'start_time',
        'end_time',
        'room',
        'type',
        'vimeo_url',
        'zoom_webinar_id',
        'zoom_password',
        'past_video',
    ];

    protected $dates = ["start_time", "end_time"];

    public $incrementing = false;

    public function speakers(){
        return $this->hasMany("\App\SessionSpeaker", "session_id")->select(["speaker_id", "session_id"]);
    }

    public function moderators(){
        return $this->hasMany("\App\SessionModerator", "session_id");
    }

    public function polls(){
        return $this->hasMany("\App\SessionPoll", "session_id");
    }

    public function subscriptions(){
        return $this->hasMany("\App\EventSubscription", "session_id");
    }
    public function subscribe(){
        $user = \Auth::user();
        EventSubscription::firstOrCreate([
            "session_id" => $this->id,
            "user_id" => $user->id,
        ]);
    }

    public function unsubscribe(){
        $user = \Auth::user();
        EventSubscription::where([
            "session_id" => $this->id,
            "user_id" => $user->id,
        ])->delete();
    }
}
