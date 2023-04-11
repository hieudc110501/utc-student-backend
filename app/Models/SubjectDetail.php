<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectDetail extends Model
{
    protected $fillable = ['studentSubjectTermId', 'startDay', 'endDay', 'lesson', 'weekday'];

    protected $primarkey =  'subjectdetailId';
    protected $table = 'subjectdetail';
}
