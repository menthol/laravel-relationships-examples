<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Node
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Article[] $articles
 * @property-read \App\Node $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Node[] $children
 */
class Node extends Model
{
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function parent()
    {
        return $this->belongsTo(Node::class);
    }

    public function children()
    {
        return $this->hasMany(Node::class, 'parent_id');
    }
}
