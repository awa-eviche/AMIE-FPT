<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommuneIef extends Model
{
    use HasFactory;
    protected $fillable = ['commune_id','ief_id',];
}
