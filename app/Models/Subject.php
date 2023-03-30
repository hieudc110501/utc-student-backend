<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['subjectName'];

    protected $primarkey =  'subjectId';
    protected $table = 'subject';
}
