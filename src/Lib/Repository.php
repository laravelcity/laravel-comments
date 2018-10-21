<?php

namespace Laravelcity\Comments\Lib;

use Laravelcity\Comments\Models\Comments;

class Repository
{
    protected $comment;

    public function __construct ()
    {
        $this->comment = new Comments();
    }

    /**
     * set model for manage comment
     * @param $model
     * @return $this
     */
    public function setCommentModel ($model)
    {
        $this->comment = app()->make($model);
        return $this;
    }

    /**
     * return all comments
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all ()
    {
        return $this->comment->with('user')->orderBy('id' , 'desc')->paginate();
    }

    /**
     * find comment with id
     * @param $id
     * @return mixed
     */
    public function find ($id)
    {
        return $this->comment->findOrFail($id);
    }

    /**
     * run action on comments
     * @throws CommentException
     */
    public function runActions ()
    {
        $action = \request()->input('action');
        $selection = \request()->input('selection');

        if ($action == '' || $selection == null)
            throw new CommentException(trans('Comments::comments.error-message.sendDataError'));

        if (!is_array($selection))
            $selection = [$selection];

        switch ($action) {
            case "delete":
                $this->comment->whereIn('id' , $selection)->forceDelete();
                break;
            case "restore":
                $this->comment->whereIn('id' , $selection)->restore();
                break;
            case "destroy":
                $this->comment->whereIn('id' , $selection)->delete();
                break;
            case "status":
                $this->comment->whereIn('id' , $selection)->update(['status' => \request()->get('value' , CommentStatus::pending)]);
                break;
        }
    }
}