<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\ArchiveVideos
 *
 * @property int $id
 * @property string $title
 * @property string $video_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArchiveVideos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArchiveVideos newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\ArchiveVideos onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArchiveVideos query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArchiveVideos whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArchiveVideos whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArchiveVideos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArchiveVideos whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArchiveVideos whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ArchiveVideos whereVideoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ArchiveVideos withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ArchiveVideos withoutTrashed()
 * @mixin \Eloquent
 */
class ArchiveVideos extends Model
{
    use SoftDeletes;
    protected $fillable = [ "title", "video_id"];
}
