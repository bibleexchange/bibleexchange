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
    'allowedOrigins' => ['http://localhost:3000','chrome-extension://fhbjgbiflinjbdggehcddcbncdddomop'],
    'allowedHeaders' => ['Access-Control-Allow-Origin','Origin'],
    'allowedMethods' => ['GET', 'POST', 'PUT',  'DELETE'],
    'exposedHeaders' => ['Access-Control-Allow-Origin: http://localhost:3000'],
    'maxAge' => 0,
    'hosts' => [],
];

