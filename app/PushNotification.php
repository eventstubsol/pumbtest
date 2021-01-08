<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;
use App\UUID;
use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    use UUID;
    use SoftDeletes;
    
    public $table = "push_notification";
    protected $fillable = ["title","url","message","roles"];
}
