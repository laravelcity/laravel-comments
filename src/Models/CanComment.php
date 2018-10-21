<?php

namespace Laravelcity\Comments\Models;

use Laravelcity\Comments\Lib\CommentStatus;

trait CanComment
{
    /**
     * insert new comment
     * @param $commentable
     * @param $content
     * @param int $parent
     * @param string $status
     * @return $this
     */
    public function comment ($commentable , $content , $parent = 0 , $status = CommentStatus::pending)
    {

        $comment = new Comments([
            'content' => $content ,
            'parent' => $parent ,
            'user_id' => $this->id ,
            'status' => $status
        ]);

        $commentable->comments()->save($comment);
        return $this;
    }

    /**
     * get all comments with model type filter
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments ()
    {
        return $this->morphMany(Comments::class , 'commentable');
    }

}
