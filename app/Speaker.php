<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UUID;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Speaker
 *
 * @property string $id
 * @property string|null $name
 * @property string|null $photo
 * @property string|null $bio
 * @property string|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SessionSpeaker[] $sessions
 * @property-read int|null $sessions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Speaker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Speaker newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Speaker onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Speaker query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Speaker whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Speaker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Speaker whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Speaker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Speaker whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Speaker wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Speaker whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Speaker whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Speaker withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Speaker withoutTrashed()
 * @mixin \Eloquent
 */
class Speaker extends Model
{
    use UUID;
    use SoftDeletes;

    public $incrementing = false;

    protected $guarded = [];

    public function sessions(){
        return $this->hasMany("\App\SessionSpeaker");
    }

}
