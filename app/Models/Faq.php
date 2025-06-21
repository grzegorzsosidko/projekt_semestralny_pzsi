<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'is_hidden',
    ];

    protected $casts = [
        'is_hidden' => 'boolean',
    ];

    public function user()
    {
    return $this->belongsTo(User::class);
    }
}
