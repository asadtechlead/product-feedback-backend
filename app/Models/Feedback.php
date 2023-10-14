<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $table = 'feedbacks';
    protected $fillable = ['title', 'description', 'category', 'votes', 'created_at', 'updated_at', 'user_id'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getCreatedAtAttribute($date)
    {
        return (new Carbon($date))->format('d M Y h:i A');
    }
}
