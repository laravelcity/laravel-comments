<?php

namespace Laravelcity\Comments\Lib;


class CommentStatus extends Enum
{
    const pending = 'pending';
    const accepted = 'accepted';
    const rejected = 'rejected';

    function translations ()
    {
        return [
            self::pending => trans('Comments::comment.status.pending.title') ,
            self::accepted => trans('Comments::comment.status.accepted.title') ,
            self::rejected => trans('Comments::comment.status.rejected.title') ,
        ];
    }

    function attributes ()
    {
        return [
            self::pending => ['class' => config('comments.status.pending.class')] ,
            self::accepted => ['class' => config('comments.status.accepted.class')] ,
            self::rejected => ['class' => config('comments.status.rejected.class')] ,
        ];
    }
}