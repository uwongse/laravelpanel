<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'actor' => [
        'title' => 'Actors',

        'actions' => [
            'index' => 'Actors',
            'create' => 'New Actor',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'actor' => 'Actor',
            
        ],
    ],

    'cinema' => [
        'title' => 'Cinemas',

        'actions' => [
            'index' => 'Cinemas',
            'create' => 'New Cinema',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'cinema' => 'Cinema',
            
        ],
    ],

    'director' => [
        'title' => 'Directors',

        'actions' => [
            'index' => 'Directors',
            'create' => 'New Director',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'director' => 'Director',
            
        ],
    ],

    'movie' => [
        'title' => 'Movies',

        'actions' => [
            'index' => 'Movies',
            'create' => 'New Movie',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'title' => 'Title',
            'synopsis' => 'Synopsis',
            'duration' => 'Duration',
            'poster' => 'Poster',
            'background' => 'Background',
            'api_id' => 'Api',
            'trailer' => 'Trailer',
            'type' => 'Type',
            'premiere' => 'Premiere',
            'buy' => 'Buy',
            'active' => 'Active',
            'qualification_id' => 'Qualification',
            
        ],
    ],

    'projection' => [
        'title' => 'Projections',

        'actions' => [
            'index' => 'Projections',
            'create' => 'New Projection',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'hour' => 'Hour',
            'release_date' => 'Release date',
            'movie_id' => 'Movie',
            'room_id' => 'Room',
            'cinema_id' => 'Cinema',
            'syncronitation_id' => 'Syncronitation',
            
        ],
    ],

    'qualification' => [
        'title' => 'Qualifications',

        'actions' => [
            'index' => 'Qualifications',
            'create' => 'New Qualification',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'qualification' => 'Qualification',
            'abbreviation' => 'Abbreviation',
            'image' => 'Image',
            
        ],
    ],

    'room' => [
        'title' => 'Rooms',

        'actions' => [
            'index' => 'Rooms',
            'create' => 'New Room',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'room' => 'Room',
            
        ],
    ],

    'slide' => [
        'title' => 'Slides',

        'actions' => [
            'index' => 'Slides',
            'create' => 'New Slide',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'title' => 'Title',
            'image' => 'Image',
            'active' => 'Active',
            'updated' => 'Updated',
            
        ],
    ],

    'syncronitation' => [
        'title' => 'Syncronitations',

        'actions' => [
            'index' => 'Syncronitations',
            'create' => 'New Syncronitation',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'result' => 'Result',
            
        ],
    ],

    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];