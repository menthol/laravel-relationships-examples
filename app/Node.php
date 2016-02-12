<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
