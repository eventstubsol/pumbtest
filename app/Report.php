<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\UUID;


/**
 * App\Report
 *
 * @property string $id
 * @property string|null $title
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $region
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Resource[] $resources
 * @property-read int|null $resources_count
 * @property-read \App\Video|null $video
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Report onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Report whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Report withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Report withoutTrashed()
 * @mixin \Eloquent
 */
class Report extends Model
{
    use SoftDeletes;
    use UUID;
    public $incrementing = false;

    public function video(){
        return $this->hasOne("\App\Video","owner");
    }
    public function resources(){
        return $this->hasMany("\App\Resource", "booth_id");
    }
    protected $fillable = [ "title", "description","region" ];
}
