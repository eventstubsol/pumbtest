<?php

namespace App;

use App\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Poll
 *
 * @property string $id
 * @property string $name
 * @property int $status
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Question[] $questions
 * @property-read int|null $questions_count
 * @property-read \App\SessionPoll|null $session_poll
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Vote[] $votes
 * @property-read int|null $votes_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Poll newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Poll newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Poll onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Poll query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Poll whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Poll whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Poll whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Poll whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Poll whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Poll whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Poll whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Poll whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Poll withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Poll withoutTrashed()
 * @mixin \Eloquent
 */
class Poll extends Model
{
    use UUID;
    use SoftDeletes;

    //
    protected $fillable = ["name", "end_date", "start_date", "time", "status"];

    protected $dates = ["end_date", "start_date"];

    public function questions()
    {
        return $this->hasMany("App\Question")->orderBy("sort_order", "ASC");
    }

    public function votes()
    {
        return $this->hasMany("App\Vote")->where("status", 1);
    }

    public function session_poll()
    {
        return $this->hasOne("\App\SessionPoll");
    }
}
