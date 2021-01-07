<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UUID;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\SessionSpeaker
 *
 * @property string $id
 * @property string|null $session_id
 * @property string|null $speaker_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\EventSession|null $session
 * @property-read \App\Speaker|null $speaker
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionSpeaker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionSpeaker newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\SessionSpeaker onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionSpeaker query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionSpeaker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionSpeaker whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionSpeaker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionSpeaker whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionSpeaker whereSpeakerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionSpeaker whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SessionSpeaker withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\SessionSpeaker withoutTrashed()
 * @mixin \Eloquent
 */
class SessionSpeaker extends Model
{
    use UUID;
    use SoftDeletes;

    public $incrementing = false;

    protected $guarded = [];

    public function session(){
        return $this->belongsTo("App\EventSession", "session_id");
    }

    public function speaker(){
        return $this->belongsTo("App\User", "speaker_id")->select([
            "id",
            "name",
            "last_name",
            "profileImage",
            "job_title",
            "company_name",
            "company_website_link",
            "website_link",
            "facebook_link",
            "twitter_link",
            "linkedin_link",
//            "*",
        ]);
    }
}
