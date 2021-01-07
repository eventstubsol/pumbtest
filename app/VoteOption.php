<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\UUID;

/**
 * App\VoteOption
 *
 * @property string $id
 * @property string $vote_id
 * @property string $question_id
 * @property string $option_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Option $option
 * @property-read \App\Vote $vote
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VoteOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VoteOption newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\VoteOption onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VoteOption query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VoteOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VoteOption whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VoteOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VoteOption whereOptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VoteOption whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VoteOption whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VoteOption whereVoteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\VoteOption withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\VoteOption withoutTrashed()
 * @mixin \Eloquent
 */
class VoteOption extends Model
{
    use UUID;
    use SoftDeletes;

    protected $fillable = [ "question_id", "option_id" ];

    protected $hidden = [ "id", "vote_id", "created_at", "updated_at", "deleted_at" ];

    public function option(){
        return $this->belongsTo("\App\Option");
    }

    public function vote(){
        return $this->belongsTo("\App\Vote");
    }
}
