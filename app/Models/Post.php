<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    // Ta linia pozwala na zapisywanie wszystkich pól, które podajemy w kontrolerze
    protected $guarded = [];

    // Definiujemy relacje, które faktycznie istnieją
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->latest();
    }
}