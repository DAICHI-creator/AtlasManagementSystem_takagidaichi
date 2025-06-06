<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
    ];

    public function user(){
        return $this->belongsTo('App\Models\Users\User');
    }

    public function likes(){
        return $this->hasMany(Like::class, 'like_post_id');
    }


    public function postComments(){
        return $this->hasMany(PostComment::class, 'post_id');
    }

    public function subCategories(){
        return $this->belongsToMany(
            \App\Models\Posts\SubCategory::class,
            'post_sub_categories',
            'post_id',
            'sub_category_id'
        );
    }

}
