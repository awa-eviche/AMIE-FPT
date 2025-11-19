<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryFile extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['libelle','access', 'user_id'];
    protected $casts = [
        'access' => 'json',
    ];

    /**
     * Get the user that owns the CategoryFile
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the fichiers for the CategoryFile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fichiers(): HasMany
    {
        return $this->hasMany(Fichier::class, 'category_file_id');
    }
}
