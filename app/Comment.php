<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Comment
 *
 * @property-read \App\Comment $comment
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment query()
 * @mixin \Eloquent
 */
class Comment extends Model
{
    public function user()
    {
//        return $this->belongsTo(User::class);
        return $this->belongsTo('App\User');
    }

    public function replies() {
        return $this->hasMany(Reply::class, 'comment_id');
    }
}
