<?php 

namespace Root;

class Routes 
{

    CONST ROUTES = [
        
        '/api/upload' => [ 'ImageController@upload', 'POST' ],
        '/api/delete/product' => [ 'ImageController@deleteProduct', 'POST' ],

        '/api/pbl-career/upload' => [ 'PblCareerController@upload', 'POST' ],
    ];
}