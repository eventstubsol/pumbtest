<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UUID;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\SessionModerator
 *
 * @property string $id
 * @property string|null $user_id
 * @property string|null $session_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\EventSession|null $session
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionModerator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionModerator newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\SessionModerator onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionModerator query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionModerator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionModerator whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionModerator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionModerator whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionModerator whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SessionModerator whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SessionModerator withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\SessionModerator withoutTrashed()
 * @mixin \Eloquent
 */
class SessionModerator extends Model
{
    use UUID;
    use SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        "session_id",
        "user_id"
    ];

    protected $hidden = [ "id", "session_id", "created_at", "updated_at", "deleted_at" ];

    public function user(){
        return $this->belongsTo("\App\User");
    }

    public function session(){
        return $this->belongsTo("\App\EventSession", 'session_id');
    }
}
