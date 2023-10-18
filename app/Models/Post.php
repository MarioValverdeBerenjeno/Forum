<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'forum_id', 
        'user_id', 
        'title', 
        'description',
    ];

    protected static function boot() {
        parent::boot();
        static::creating(function($post) {
            if( ! App::runningInConsole() ) {
            $post->user_id = auth()->id();
            }
        });

        static::deleting(function($post) {
            if( ! App()->runningInConsole() ) {
                if($post->replies()->count()) {
                    // foreach($post->replies as $reply) {
                    // 	if($reply->attachment) {
                    // 		Storage::delete('replies/' . $reply->attachment);
                    // 	}
                    // }
                    $post->replies()->delete();
                }
    
                // if($post->attachment) {
                // 	Storage::delete('posts/' . $post->attachment);
                // }
            }
        });
    }

    public function forum(): BelongsTo {
    	return $this->belongsTo(Forum::class, 'forum_id');
    }

    public function owner(): BelongsTo {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function replies(): HasMany {
        return $this->hasMany(Reply::class);
    }
    
    public function isOwner() {
        return $this->owner->id === auth()->id();
        // También es posible ponerlo de la siguiente forma
        // return $this->owner == auth()->user();
    }
}