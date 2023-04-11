<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSubjectTerm extends Model
{
    protected $fillable = ['studentTermId','subjectId'];

    protected $primarkey =  'studentSubjectTermId';
    protected $table = 'studentsubjectterm';
}
