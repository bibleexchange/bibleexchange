<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Laravel CORS
     |--------------------------------------------------------------------------
     |

     | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
     | to accept any value.
     |
     */
    'supportsCredentials' => true,
    'allowedOrigins' => ['http://localhost:3000','http://127.0.0.1:3000'],
    'allowedHeaders' => ['Access-Control-Allow-Origin','Origin','Content-Type','Authorization'],
    'allowedMethods' => ['GET', 'POST', 'PUT',  'DELETE'],
    'exposedHeaders' => ['Access-Control-Allow-Origin: *'],
    'maxAge' => 0,
    'hosts' => [],
];
