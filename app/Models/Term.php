<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $fillable = ['termName', 'termValue'];

    protected $primarkey =  'termId';
    protected $table = 'term';
}
