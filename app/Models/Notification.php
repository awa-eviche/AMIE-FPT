<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['type', 'model_id', 'model_type', 'content', 'user_id'];

    public function notifiable()
    {
        return $this->morphTo('model', 'model_type', 'model_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
