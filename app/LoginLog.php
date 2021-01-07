<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\LoginLog
 *
 * @property string $id
 * @property string $ip
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LoginLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LoginLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LoginLog query()
 * @mixin \Eloquent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LoginLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LoginLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LoginLog whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LoginLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LoginLog whereUserId($value)
 */
class LoginLog extends Model
{
    protected $fillable = ["ip", "user_id"];
}

