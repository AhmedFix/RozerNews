<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'img'];

    protected $appends = ['img_path'];

    public function getImgPathAttribute()
    {

        if ($this->img) {
            return asset('images/notification/' . $this->img);
        }

        return asset('images/notification/notification.png');

    }// end of getImgPathAttribute
}
