<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $table = "classes";
    protected $fillable = ['class_name', 'description', 'teacher_id'];

    public function teacher(){
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
