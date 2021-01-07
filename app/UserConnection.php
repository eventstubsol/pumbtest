<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UserConnection
 *
 * @property int $id
 * @property string $user_id
 * @property string $connection_id
 * @property int $status [-1 = Declined, 0 = Pending, 1 = Accepted]
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $receiver
 * @property-read \App\User $sender
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnection query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnection whereConnectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnection whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnection whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnection whereUserId($value)
 * @mixin \Eloquent
 */
class UserConnection extends Model
{
    protected $fillable = [ "user_id", "connection_id" ];

    public function sender(){
        return $this->belongsTo("\App\User", "user_id")->select(USER_COLUMNS_TO_GET_SAFE);
    }

    public function receiver(){
        return $this->belongsTo("\App\User", "connection_id")->select(USER_COLUMNS_TO_GET_SAFE);
    }

    public function setStatus($status){
        if($this->status !== $status){
            $authenticatedUser = \Auth::user();
            if(!$this->sender){
                $this->load("sender");
            }
            $this->status = $status;
            $this->sender->notifications()->create([
                "type" => $status == 1 ? "success" : "info",
                "action_type" => "connection_status",
                "title" => "Your connection request to ".$authenticatedUser->getFullName()." has been ".($status == 1 ? "accepted" : "declined"),
                "user_id" => $this->sender->id,
                "action_id" => $authenticatedUser->id,
            ]);
            $this->save();
        }
        return $this;
    }

}
