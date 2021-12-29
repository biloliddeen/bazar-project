<?php

// use Yii;
use yii\i18n\PhpMessageSource;
use yii\i18n\MissingTranslationEvent;
use common\components\TranslationEventHandler;

return [
    // 'language' => \Yii::$app->session->get('lang'),
    // 'language' => 'de-DE',
    // 'language' => $_SESSION['lang'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'class' => \common\i18n\Formatter::class,
            'datetimeFormat' => 'dd-MM-yyyy H:i',
            'currencyCode' => '$'
        ],       
    ]
];


















 