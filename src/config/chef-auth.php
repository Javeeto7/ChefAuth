<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Package Connection
    |--------------------------------------------------------------------------
    |
    | You can set a a different database connection for this package. It will set
    | new connection for models Ingredient and Category. When this option is null,
    | it will connect to the main database, which is set up in database.php
    |
    */

    'connection' => null,

    /*
    |--------------------------------------------------------------------------
    | Slug Separator
    |--------------------------------------------------------------------------
    |
    | You can change the slug separator. This is relevant in matter
    | of magic method __callChef() and also a SlugableTrait. The default value
    | is a dot.
    |
    */

    'separator' => '.',

    /*
    |--------------------------------------------------------------------------
    | Ingredients, Categories and Steamed "Cookable"
    |--------------------------------------------------------------------------
    |
    | You can cookable or simulate package behavior no matter what is in your
    | database. It is useful when you are in test phase.
    | Configure what methods cooks(), is() and steamed() will return.
    |
    */

    'cookable' => [

        'enabled' => false,

        'options' => [
            'cooks'       => true,
            'is'       => true,
            'steamed'   => true,
        ],

    ],

];
