<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTerm extends Model
{
    protected $fillable = ['studentId','termId'];

    protected $primarkey =  'studentTermId';
    protected $table = 'studentterm';
}
