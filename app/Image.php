<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\UUID;

/**
 * App\Image
 *
 * @property string $id
 * @property string $owner
 * @property string $title
 * @property string $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $link
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Image onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Image withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Image withoutTrashed()
 * @mixin \Eloquent
 */
class Image extends Model
{
    use SoftDeletes;
    use UUID;
    public $incrementing = false;

    protected $fillable = ["owner", "url", "title", "link"];
    protected $hidden = ["id", "owner", "created_at", "deleted_at", "updated_at"];
}
