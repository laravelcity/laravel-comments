<?php

return [

    // set categories table name
    'comments_table_name' => 'comments' ,

    // set relation category table name
    'relation_table_name' => 'categorieables' ,

    // set user model and primary key
    'user' => [
        'class' => \App\User::class ,
        'primary_key' => 'id'
    ] ,

    'depth' => 3 ,

];