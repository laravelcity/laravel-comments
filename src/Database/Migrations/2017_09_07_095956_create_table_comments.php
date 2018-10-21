<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up ()
    {
        // comments table
        Schema::create(config('comments.comments_table_name') , function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->integer('user_id');
            $table->string('content' , 1000);
            $table->integer('parent')->default(0);
            $table->enum('status' , [\Laravelcity\Comments\Lib\CommentStatus::pending , \Laravelcity\Comments\Lib\CommentStatus::rejected , \Laravelcity\Comments\Lib\CommentStatus::accepted]);
            $table->boolean('read_at')->default(0);
            $table->integer('commentable_id');
            $table->string('commentable_type');
            $table->timestamps();
            $table->softDeletes();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down ()
    {
        Schema::dropIfExists(config('comments.comments_table_name'));
    }

}
