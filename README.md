# Laravel Comments

This is a package for managing comments.

## Install laravel comments

#### STEP1:

Run below statements on your terminal :

``
    composer require laravelcity/laravel-comments
``

#### STEP2:

add **provider** and **facade** in **config/app.php**

```
    providers => [
       ...
       Laravelcity\Comments\CommentsServiceProvider::class,
    ],


    aliases => [
       ...
       'Comments' => \Laravelcity\Comments\Facade\Comment::class,
    ]
```

#### STEP3:

``
    php artisan vendor:publish --provider=Laravelcity\Comments\CommentsServiceProvider
``
or
``
    php artisan vendor:publish 
``

Now you can customize your config in file `config/comments.php`

#### STEP4:

``
    php artisan migrate
``

#### STEP5:

please add `Laravelcity\Comments\Models\CanComment` to `user` model :

``
    class User extends Authenticatable
    {
        use CanComment;
        .
        .
        .
``

#### STEP6:

please add `Laravelcity\Comments\Models\Commentable` to Any models that you want to launch for it comments system.


for example added commentable for posts : 

``
    class Post extends Model
    {
        use Commentable;
``

## how to use Comments

#### insert comment

```
   auth()->user()->comment(
            $model, //for example => App\Models\Posts
            $commentRequest->get('content'),
            $commentRequest->get('parent'),
            $status // default is pending
    );
    
```

#### get comment
```
   public function show($id){
        $comment=$this->comment->find($id);
        .
        .
        .
    }
    
```

#### update comment
```
    public function update($id){
        $comment=$this->comment->find($id);
        $comment->update(request()->only(['content']));
        .
        .
        .
    }
```

#### destroy comment
```
     public function destroy($id){
        $comment=$this->comment->find($id);
        $comment->delete();
        .
        .
        .
    }
```

#### actions to comments
```
   public function actions()
    {
        try {
            $this->comment->runActions();
            // enter code ..

        }catch (CommentException $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
```

`$this->comment->runActions();` It has three operators

- destroy
- delete
- restore
- status

To run these methods, send the following parameters


- **action**
 
    This is a parameter to save selected operator. 
    paramert is string and only => 'destroy','delete','restore','status'
 
- **selection** 
 
    This is a parameter to save selected categories to execute operations on them
    parametr is array,for example => [2,5,8,9]

## set new model for Comments  

must create new model and extend of `Laravelcity\Comments\Models\Comments` :

```
    use Laravelcity\Comments\Models\Comments;

    class CustomComment extends Comments
    {

        public function __construct(array $attributes = [])
        {
            parent::__construct($attributes);
        }

    }

```

and now use the following:

```
  public function __construct()
    {
        $this->comment=Comment::setCommentModel(CustomComment::class); //set custom model for comment facade
    }
```

Note that you can create multiple categories with different models