<?php

namespace App\Models;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable=[
        'title',
        'content',
        'user_id',
        'category_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function tags()
{
    return $this->belongsToMany(Tag::class);
}
    public function attachments()
{
    return $this->hasMany(PostAttachment::class);
}

public function corps()
{
    return $this->belongsToMany(Corp::class);
}





}
