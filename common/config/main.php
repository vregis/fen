<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
//        'cache' => [
//            'class' => 'yii\caching\MemCache',
//            'useMemcached' => true,
//            'keyPrefix' => 'lte_',
//            'servers' => [
//                [
//                    'host' => 'localhost',
//                    'port' => 11211,
//                    'weight' => 60,
//                ],
//            ],
//        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];