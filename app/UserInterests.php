<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UserInterests
 *
 * @property int $id
 * @property string $interest
 * @property string $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserInterests newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserInterests newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserInterests query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserInterests whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInterests whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInterests whereInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInterests whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserInterests whereUserId($value)
 * @mixin \Eloquent
 */
class UserInterests extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo("\App\User");
    }
}
