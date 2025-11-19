<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    public function documentable()
    {
        return $this->morphTo();
    }

    protected $fillable = [
        "nom",
        "description",
        "lien_ressource",
        "documentable_id",
        "documentable_type",
    ];
    public static function findByEntite($entite, $id, $libelle)
    {
        return self::where([['documentable_type', $entite ],['documentable_id',$id], ['nom', $libelle]])->first();
    }
    public function signatureTransactions()
    {
        return $this->hasMany(SignatureTransaction::class, 'document_id');
    }

}
