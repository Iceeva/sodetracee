<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bale extends Model
{
    use HasFactory;

    protected $fillable = ['reference', 'quality', 'weight', 'private_data'];

    protected $hidden = ['private_data']; // Masquer les données privées par défaut
}
