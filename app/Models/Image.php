<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'image_url', 'path', 'user_id'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Get comments with user data, ordered by newest first
    public function commentsWithUser()
    {
        return $this->hasMany(Comment::class)->with('user')->orderBy('created_at', 'desc');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
