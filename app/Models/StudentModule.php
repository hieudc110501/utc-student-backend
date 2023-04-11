<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentModule extends Model
{
    protected $fillable = ['moduleId','studentId','times'];

    protected $primarkey =  'studentModuleId';
    protected $table = 'studentModule';
}
