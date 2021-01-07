<?php

namespace App;

use App\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\BoothAdmin
 *
 * @property string $id
 * @property string $user_id
 * @property string $booth_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BoothAdmin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BoothAdmin newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\BoothAdmin onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BoothAdmin query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BoothAdmin whereBoothId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BoothAdmin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BoothAdmin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BoothAdmin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BoothAdmin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BoothAdmin whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BoothAdmin withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\BoothAdmin withoutTrashed()
 * @mixin \Eloquent
 */
class BoothAdmin extends Model
{
    use SoftDeletes;
    use UUID;
    public $incrementing = false;
    protected $fillable = [ "booth_id", "user_id" ];
}
