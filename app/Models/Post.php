<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'user_id'];

    /**
     * Get the user that owns the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the display name for the post author
     */
    public function getAuthorNameAttribute()
    {
        if (!$this->user) {
            return 'Anonymous User';
        }
        
        if ($this->user->is_deleted) {
            return 'Deleted User';
        }
        
        return $this->user->name;
    }
}
