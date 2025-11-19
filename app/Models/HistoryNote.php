<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HistoryNote extends Model
{
    use HasFactory;
    protected $fillable=[
        'evaluation_id',
        'user_id',
        'old_note_cc',
        'old_note_composition',
    ];
    /**
     * Get all of the etablissements for the Indicateur
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all of the indicateurs for the SuiviIndicateur
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class, 'evaluation_id');
    }
}
