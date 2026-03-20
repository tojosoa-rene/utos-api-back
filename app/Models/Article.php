<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    // Autorise la création/mise à jour de ces colonnes via assignation de masse
    protected $fillable = ['title', 'content'];
}
