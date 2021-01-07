<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\UUID;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Option
 *
 * @property string $id
 * @property string $question_id
 * @property string $text
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\VoteOption[] $vote_options
 * @property-read int|null $vote_options_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Option onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Option withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Option withoutTrashed()
 * @mixin \Eloquent
 */
class Option extends Model
{
    use UUID;
    use SoftDeletes;

    protected $fillable = ["text", "sort_order"];

    protected $hidden = ["question_id", "created_at", "updated_at", "deleted_at"];

    public function vote_options()
    {
        return $this->hasMany("App\VoteOption");
    }
}
