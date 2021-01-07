<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\UUID;

/**
 * App\ProvisionalGroup
 *
 * @property string $id
 * @property string|null $title
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Resource[] $resource
 * @property-read int|null $resource_count
 * @property-read \App\Video|null $video
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProvisionalGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProvisionalGroup newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\ProvisionalGroup onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProvisionalGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProvisionalGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProvisionalGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProvisionalGroup whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProvisionalGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProvisionalGroup whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProvisionalGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProvisionalGroup withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ProvisionalGroup withoutTrashed()
 * @mixin \Eloquent
 */
class ProvisionalGroup extends Model
{
    use SoftDeletes;
    use UUID;
    public $incrementing = false;
    public function video(){
        return $this->hasOne("\App\Video","owner");
    }
    public function resource(){
        return $this->hasMany("\App\Resource","booth_id");
    }
    protected $fillable = [ "title", "description"];
}
