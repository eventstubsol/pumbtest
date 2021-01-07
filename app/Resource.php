<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\UUID;

/**
 * App\Resource
 *
 * @property string $id
 * @property string $title
 * @property string $url
 * @property string $booth_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Booth $booth
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Swagbag[] $swagbag
 * @property-read int|null $swagbag_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Resource newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Resource newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Resource onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Resource query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Resource whereBoothId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Resource whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Resource whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Resource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Resource whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Resource whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Resource whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Resource withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Resource withoutTrashed()
 * @mixin \Eloquent
 */
class Resource extends Model
{
    use SoftDeletes;
    use UUID;
    public $incrementing = false;
    public function booth(){
        return $this->belongsTo("\App\Booth");
    }
    public function swagbag()
    {
    	return $this->hasMany("\App\Swagbag","resources_id");
    }
    protected $fillable = [ "booth_id","url","title"];
}
