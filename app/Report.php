<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Report
 *
 * @property-read \App\User $user
 * @property integer $id
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Report extends Model
{
    public function articles()
    {
        return $this->morphedByMany(Article::class, 'reportable');
    }

    public function authors()
    {
        return $this->morphedByMany(Author::class, 'reportable');
    }

    public function comments()
    {
        return $this->morphedByMany(Comment::class, 'reportable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
