<?php

namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    protected $connection = 'mongodb';


}
