<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\User
 *
 * @property-read \App\Author $author
 * @property-read \App\Author $comments
 * @property-read \App\Like $likes
 * @property-read \App\Report $reports
 * @property-read \App\Review $reviews
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class User extends Model
{
    public function author()
    {
        return $this->hasOne(Author::class);
    }

    public function comments()
    {
        return $this->hasOne(Author::class);
    }

    public function likes()
    {
        return $this->hasOne(Like::class);
    }

    public function reports()
    {
        return $this->hasOne(Report::class);
    }

    public function reviews()
    {
        return $this->hasOne(Review::class);
    }
}
