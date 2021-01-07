<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\UserTag
 *
 * @property int $id
 * @property string $tag
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $user_id
 * @property-read int|null $user_id_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|UserTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTag newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserTag onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTag query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTag whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTag whereTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|UserTag withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserTag withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $looking_users
 * @property-read int|null $looking_users_count
 */
class UserTag extends Model
{
    use SoftDeletes;
    protected $fillable = ['tag'];

    public function users(){
        return $this->belongsToMany('\App\User', 'user_tag_links', 'tag_id')->select([
            "user_id",
            "name",
            "last_name",
            "job_title",
            "company_name",
            "country",
            "industry",
            "type",
            "profileImage"
        ]);
    }

    public function user_id(){
        return $this->belongsToMany('\App\User', 'user_tag_links', 'tag_id')->select([
            "user_id",
        ]);
    }

    public function looking_users(){
        return $this->belongsToMany('\App\User', 'user_tag_looking_links', 'tag_id')
                ->where("users.updated_at", ">=", Carbon::now()->subtract(ONLINE_KEEPING_TIME, "seconds"))
                ->select([ "user_id" ]);
    }
}
