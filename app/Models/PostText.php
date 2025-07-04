<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PostText extends Model {
    public $timestamps = false;
    protected $guarded = [];
    public function post() { return $this->belongsTo(Post::class); }
}