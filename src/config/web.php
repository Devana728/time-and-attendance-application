<?php

use app\api\Api;
use app\base\Alert;
use app\models\User;
use yii\caching\FileCache;
use yii\debug\Module;
use yii\i18n\PhpMessageSource;
use yii\log\FileTarget;
use yii\swiftmailer\Mailer;
use yii\web\JsonParser;

$params = require __DIR__ . '/params.php';

$config = [
    'id' => 'timeclock',
    'basePath' => dirname(__DIR__),
    'vendorPath' => dirname(__DIR__) . '/../vendor',
    'runtimePath' => dirname(__DIR__) . '/../runtime',
    'bootstrap' => ['log'],
    'timeZone' => 'UTC',
    'language' => 'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'api' => Api::class,
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'JIaOBg9h_jQT42KwuxzA3M4TxerBjzfx',
            'parsers' => [
                'application/json' => JsonParser::class,
            ],
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'cache' => [
            'class' => FileCache::class,
        ],
        'alert' => [
            'class' => Alert::class,
        ],
        'user' => [
            'identityClass' => User::class,
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => PhpMessageSource::class,
                    'basePath' => '@app/messages'
                ],
            ],
        ],
        'mailer' => [
            'class' => Mailer::class,
            'viewPath' => '@app/mail',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require 'db.php',
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require __DIR__ . '/rules.php',
        ],
        'formatter' => [
            'dateFormat' => 'dd.MM.yyyy',
            'datetimeFormat' => 'dd.MM.yyyy, HH:mm',
            'timeFormat' => 'HH:mm',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => Module::class,
    ];
}

return $config;
