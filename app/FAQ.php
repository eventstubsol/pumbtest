<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\UUID;

/**
 * App\FAQ
 *
 * @property string $id
 * @property string $question
 * @property string $answer
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\FAQ onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FAQ whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\FAQ withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\FAQ withoutTrashed()
 * @mixin \Eloquent
 */
class FAQ extends Model
{
    use SoftDeletes;
    use UUID;
    public $incrementing = false;
    public $table = "faqs";

    //For mass assignment whitelisting
    protected $fillable = [
        "question",
        "answer",
    ];


    //For mass assignment blacklisting
//    protected $guarded = [];
}
