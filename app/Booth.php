<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\UUID;

/**
 * App\Booth
 *
 * @property string $id
 * @property string $room_id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $admins
 * @property-read int|null $admins_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Image[] $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Resource[] $resources
 * @property-read int|null $resources_count
 * @property-read \App\Room $room
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Video[] $videos
 * @property-read int|null $videos_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Booth onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booth whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Booth withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Booth withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $boothurl
 * @method static \Illuminate\Database\Eloquent\Builder|Booth whereBoothurl($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\BoothInterest[] $interests
 * @property-read int|null $interests_count
 * @property int $status 0 = Not Published / 1 = Published
 * @property string|null $calendly_link
 * @method static \Illuminate\Database\Eloquent\Builder|Booth onlyPublished()
 * @method static \Illuminate\Database\Eloquent\Builder|Booth whereCalendlyLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booth whereStatus($value)
 */
class Booth extends Model
{
    use SoftDeletes;
    use UUID;
    public $incrementing = false;

    //For mass assignment whitelisting
    protected $guarded = [
        "id",
    ];
    public function admins(){
        return $this->hasManyThrough("\App\User", "\App\BoothAdmin", "booth_id", "id", "id", "user_id");
    }

    public function room(){
        return $this->belongsTo("\App\Room");
    }

    public function resources(){
        return $this->hasMany("\App\Resource");
    }

    public function images(){
        return $this->hasMany("\App\Image", "owner");
    }

    public function videos(){
        return $this->hasMany("\App\Video", "owner");
    }

    public function interests(){
        return $this->hasMany("\App\BoothInterest");
    }

    public function scopeOnlyPublished($query){
        return $query->where("status", 1);
    }

    public function isPublished(){
        return $this->status == 1;
    }

    public function publish(){
        $this->status = 1;
        $this->save();
        return $this;
    }

    public function unpublish(){
        $this->status = 0;
        $this->save();
        return $this;
    }
}
