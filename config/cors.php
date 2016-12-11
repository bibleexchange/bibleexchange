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
    'allowedOrigins' => ['http://localhost:3000','http://127.0.0.1:3000','http://127.0.0.1','http://localhost','http://192.168.1.129','http://192.168.1.195','http://192.168.1.178','localhost'],
    'allowedHeaders' => ['Access-Control-Allow-Origin','Origin','Content-Type','Authorization','Cache-Control'],
    'allowedMethods' => ['GET', 'POST', 'PUT',  'DELETE'],
    'exposedHeaders' => ['Access-Control-Allow-Origin: *'],
    'maxAge' => 60800,
    'hosts' => ['localhost'],
];
