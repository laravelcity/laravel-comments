<?php
namespace Laravelcity\Comments\Facade;

use Illuminate\Support\Facades\Facade;

class Comment extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'CommentsClass';
    }
}