<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Notification
 *
 * @property int $id
 * @property string $title
 * @property string $user_id
 * @property string|null $details
 * @property string $type
 * @property string $action_type
 * @property string $action_id
 * @property string|null $action_status
 * @property string|null $meta
 * @property int $sent
 * @property int $read
 * @property int $clicked
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereActionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereActionStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereActionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereClicked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereUserId($value)
 * @mixin \Eloquent
 */
class Notification extends Model
{
    protected $guarded = [];
    protected $hidden = [
        "clicked",
        "read",
        "sent",
        "updated_at",
        "created_at",
        "user_id",
    ];

    public function user(){
        return $this->belongsTo("\App\User");
    }
}
