<?php

namespace Laravelcity\Comments\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravelcity\Comments\Lib\CommentStatus;

class Comments extends Model
{
    use SoftDeletes;

    protected $table = 'comments';
    protected $guarded = [];

    /**
     * scopes ******************
     **/
    public function scopeIsAccepted ($query)
    {
        return $query->where('status' , CommentStatus::accepted);
    }

    public function scopeIsPending ($query)
    {
        return $query->where('status' , CommentStatus::pending);
    }

    public function scopeIsRejected ($query)
    {
        return $query->where('status' , CommentStatus::rejected);
    }

    public function scopeIsParent ($query)
    {
        return $query->where('parent' , 0);
    }

    /**
     * other methods ******************
     **/

    /**
     * set read comment
     */
    public function read ()
    {
        $this->attributes['read_at'] = 1;
        $this->save();
    }

    /**
     * set comment status
     * @param $status
     */
    public function setStatus ($status)
    {
        $this->attributes['status'] = $status;
        $this->save();
    }

    /**
     * return child of comment
     * @return mixed
     */
    public function child ()
    {
        return self::where('parent' , $this->attributes['id'])->get();
    }

    /**
     * return parent comment
     * @return mixed
     */
    public function parent ()
    {
        return self::where('id' , $this->attributes['parent'])->first();
    }

    /**
     * return depth of comment
     * @param int $parent
     * @return int
     */
    static function getDepth ($parent = 0)
    {
        $counter = 0;
        $r = true;

        while ($r) {
            $comment = self::where('id' , $parent)->first();
            if ($comment) {
                $counter++;
                $parent = $comment->parent;
                if ($comment->parent == 0) {
                    break;
                }
            } else
                break;
        }
        return $counter;
    }

    /**
     * Relations ******************
     **/

    public function commentable ()
    {
        return $this->morphTo();
    }

    function user ()
    {
        return $this->belongsTo(config('comments.user.class') , 'user_id' , config('comments.user.primary_key'));
    }

}
