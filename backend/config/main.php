<?php

//use \yii\web\Request;
//$baseUrl = str_replace('/backend/web', '/admin', (new Request)->getBaseUrl());
//var_dump($baseUrl); die();

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'language' => 'es',
    'name' => 'Aparcabarajas',    
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module',
        ],
    ],
    'components' => [
        'request' => [
            //'baseUrl' => $baseUrl,
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
           'identityCookie' => [
        'name' => '_identity-backend',
        'httpOnly' => true,
        'domain' => '.aparcabarajas.es', // Permite compartir cookies en subdominios
    ],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
'cookieParams' => [
        'domain' => '.aparcabarajas.es', // Permite que la sesión funcione en el subdominio
        'httponly' => true,
        'secure' => true, // Si usas HTTPS
    ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',                
            ],
        ],
        */
        
    ],
    'params' => $params,
];
