<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UUID;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\SessionPoll
 *
 * @property string $id
 * @property string|null $poll_id
 * @property string|null $session_id
 * @property string|null $creator
 * @property string|null $start_time
 * @property string|null $end_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $timer
 * @property string|null $status
 * @property-read \App\Poll|null $poll
 * @property-read \App\EventSession|null $session
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\SessionPoll onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll wherePollId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll whereTimer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SessionPoll withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\SessionPoll withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionPoll whereCreator($value)
 */
class SessionPoll extends Model
{
    use UUID;
    use SoftDeletes;

    public $incrementing = false;

    protected $guarded = [];

    public function poll(){
        return $this->belongsTo("\App\Poll");
    }

    public function session(){
        return $this->belongsTo("\App\EventSession", "session_id");
    }
}
