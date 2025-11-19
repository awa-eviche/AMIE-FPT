<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fichier extends Model
{
    use HasFactory;
    protected $fillable = ['libelle','document','user_id','category_file_id']; 

    /**
     * Get the user that owns the Fichier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,);
    }

    /**
     * Get the categoryFile that owns the Fichier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoryFile(): BelongsTo
    {
        return $this->belongsTo(CategoryFile::class,'category_file_id');
    }




}
