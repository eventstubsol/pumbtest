<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UserTagLinks
 *
 * @property int $id
 * @property int $tag_id
 * @property string $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\UserTag $tag
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserTagLinks newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTagLinks newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTagLinks query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTagLinks whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTagLinks whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTagLinks whereTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTagLinks whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTagLinks whereUserId($value)
 * @mixin \Eloquent
 */
class UserTagLinks extends Model
{
    protected $fillable = ["tag_id", "user_id"];

    public function tag(){
        return $this->belongsTo("\App\UserTag");
    }

    public function user(){
        return $this->belongsTo("\App\User");
    }
}
