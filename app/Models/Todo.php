<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'description']; //Allow you to do mass assignment(한번에 여러 속성 값 채움)
}
