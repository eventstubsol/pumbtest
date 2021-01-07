<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\UUID;

/**
 * App\Swagbag
 *
 * @property string $id
 * @property string $user_id
 * @property string $resources_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\ProvisionalGroup $provision
 * @property-read \App\Report $report
 * @property-read \App\Resource $resource
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Swagbag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Swagbag newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Swagbag onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Swagbag query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Swagbag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Swagbag whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Swagbag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Swagbag whereResourcesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Swagbag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Swagbag whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Swagbag withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Swagbag withoutTrashed()
 * @mixin \Eloquent
 */
class Swagbag extends Model
{
    use SoftDeletes;
    use UUID;

    public $table = "swagbag";
    public $incrementing = false;

    protected $guarded = [];

    public function resource(){
        return $this->belongsTo("\App\Resource","resources_id");
    }

    public function report()
    {
        return $this->belongsTo("\App\Report","resources_id");
    }
    public function provision()
    {
        return $this->belongsTo("\App\ProvisionalGroup","resources_id");
    }

    public function user(){
        return $this->belongsTo("\App\User");
    }

}
