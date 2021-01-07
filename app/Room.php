<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\UUID;


/**
 * App\Room
 *
 * @property string $id
 * @property string $name
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $position
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Booth[] $booths
 * @property-read int|null $booths_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Room onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Room withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Room withoutTrashed()
 * @mixin \Eloquent
 */
class Room extends Model
{
    use SoftDeletes;
    use UUID;
    public $incrementing = false;
    public function booths(){
        return $this->hasMany("\App\Booth")->where("status", 1);
    }
    //For mass assignment whitelisting
    protected $fillable = [
        "name",
        "type",
        "position"
    ];
}
