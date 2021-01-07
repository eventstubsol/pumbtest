<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\EventSubscription
 *
 * @property int $id
 * @property string $session_id
 * @property string $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\EventSession $event
 * @property-read \App\User $user
 * @property-read \App\User $user_min
 * @method static \Illuminate\Database\Eloquent\Builder|EventSubscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventSubscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventSubscription query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventSubscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventSubscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventSubscription whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventSubscription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventSubscription whereUserId($value)
 * @mixin \Eloquent
 */
class EventSubscription extends Model
{
    protected $guarded = [];

    public function event(){
        return $this->belongsTo("\App\EventSession", "session_id");
    }

    public function user(){
        return $this->belongsTo("\App\User");
    }

    public function user_min(){
        return $this->belongsTo("\App\User", "user_id")->select(['id', "updated_at", "email"]);
    }
}
