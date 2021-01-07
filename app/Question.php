<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\UUID;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Question
 *
 * @property string $id
 * @property string $text
 * @property string $poll_id
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Option[] $options
 * @property-read int|null $options_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\VoteOption[] $vote_options
 * @property-read int|null $vote_options_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Question onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question wherePollId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Question whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Question withoutTrashed()
 * @mixin \Eloquent
 */
class Question extends Model
{
    use UUID;
    use SoftDeletes;

    //
    protected $fillable = ["text", "sort_order"];

    protected $hidden = ["poll_id", "created_at", "updated_at", "deleted_at"];

    public function options()
    {
        return $this->hasMany("App\Option")->orderBy("sort_order", "ASC");
    }

    public function vote_options()
    {
        return $this->hasMany("App\VoteOption");
    }
}
