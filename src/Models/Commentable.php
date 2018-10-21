<?php

namespace Laravelcity\Comments\Models;

trait Commentable
{

    /**
     * @return mixed
     */
    public function comments ()
    {
        return $this->morphMany(Comments::class , 'commentable');
    }
}
