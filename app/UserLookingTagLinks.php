<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UserLookingTagLinks
 *
 * @property int $id
 * @property int $tag_id
 * @property string $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\UserTag $tag
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserLookingTagLinks newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLookingTagLinks newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLookingTagLinks query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLookingTagLinks whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLookingTagLinks whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLookingTagLinks whereTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLookingTagLinks whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLookingTagLinks whereUserId($value)
 * @mixin \Eloquent
 */
class UserLookingTagLinks extends Model
{
    protected $table = "user_tag_looking_links";

    protected $fillable = ["tag_id", "user_id"];

    public function tag(){
        return $this->belongsTo("\App\UserTag");
    }

    public function user(){
        return $this->belongsTo("\App\User");
    }
}
