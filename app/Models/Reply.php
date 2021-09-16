<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['body', 'question_id','user_id', 'is_best_reply'];

     /**
    * Get the question that owns the reply.
    */
   public function question()
   {
       return $this->belongsTo(Question::class);
   }

     /**
    * Get the user that owns the reply.
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

     /**
     * Get the like associated with the reply.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

     /**  
    *Create user id before creating model
    */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($reply) {
            $reply->user_id = auth()->id();
        });
    }
}
