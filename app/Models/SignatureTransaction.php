<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignatureTransaction extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }


    protected $fillable = [
        "idTransaction",
        "etat",
        "projet_id",
        "plusieur",
        "lien_signature",
        "lien_doc_signe",
        "user_id",
        "document_id"
    ];



}
