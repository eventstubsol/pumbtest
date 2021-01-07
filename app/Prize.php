<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\UUID;


/**
 * App\Prize
 *
 * @property string $id
 * @property int $criteria_low
 * @property int $criteria_high
 * @property string $title
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Image[] $images
 * @property-read int|null $images_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prize newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prize newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Prize onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prize query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prize whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prize whereCriteriaHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prize whereCriteriaLow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prize whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prize whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prize whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prize whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prize whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Prize withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Prize withoutTrashed()
 * @mixin \Eloquent
 */
class Prize extends Model
{
    use UUID;
    public $incrementing = false;
    use SoftDeletes;
    protected $fillable = ["title","description","criteria_high","criteria_low"];
    public function images(){
        return $this->hasMany("\App\Image", "owner");
    }
}
