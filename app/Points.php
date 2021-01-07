<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\UUID;


/**
 * App\Points
 *
 * @property string $id
 * @property string $for
 * @property string $to
 * @property int $points
 * @property string $details
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Points newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Points newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Points onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Points query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Points whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Points whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Points whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Points whereFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Points whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Points wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Points whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Points whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Points withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Points withoutTrashed()
 * @mixin \Eloquent
 * @property string $points_for
 * @property string $points_to
 * @method static \Illuminate\Database\Eloquent\Builder|Points wherePointsFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Points wherePointsTo($value)
 */
class Points extends Model
{
    use SoftDeletes;
    use UUID;
    public $incrementing = false;

    protected $fillable = [
        "points_to",
        "points_for",
        "points",
        "details",
    ];

    public function user(){
        return $this->belongsTo("\App\User", "to");
    }
}
