<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $fillable = ['content', 'feedback_id', 'user_id'];
    public function feedback()
    {
        return $this->belongsTo(Feedback::class);
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
