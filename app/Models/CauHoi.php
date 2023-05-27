<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CauHoi extends Model
{
    protected $fillable = ['NoiDung'];

    protected $primarkey =  'MaCauHoi';
    protected $table = 'CauHoi';
}
