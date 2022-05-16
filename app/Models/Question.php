<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'questions';
    protected $fillable = [
        'question',
        'time',
        'niveau',
        'type',

    ];
}
