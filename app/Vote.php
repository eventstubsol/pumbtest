<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\UUID;

/**
 * App\Vote
 *
 * @property string $id
 * @property string $poll_id
 * @property string $user_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $status
 * @property-read \App\Poll $poll
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\VoteOption[] $vote_options
 * @property-read int|null $vote_options_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Vote onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote wherePollId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vote whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Vote withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Vote withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\User $user
 */
class Vote extends Model
{
    //
    use UUID;
    use SoftDeletes;

    protected $fillable = ["poll_id"];

    public function vote_options()
    {
        return $this->hasMany("App\VoteOption");
    }

    public function poll(){
        return $this->belongsTo("\App\Poll");
    }

    public function user(){
        return $this->belongsTo("\App\User");
    }

    public function isSubmitted(){
        return (boolean) $this->status;
    }

    public function submit(){
        $this->status = 1;
        return $this->save();
    }
}
