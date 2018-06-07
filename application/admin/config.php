<?php
//配置文件
return [
    'view_replace_str'       => [
        //'__PUBLIC__' => dirname($_SERVER['SCRIPT_NAME']),
        '__STATIC__' => dirname($_SERVER['SCRIPT_NAME']) . '/public/static/plugins/layui',
        //'__CSS__'    => dirname($_SERVER['SCRIPT_NAME']) . '/public/static/css',
        //'__JS__'     => dirname($_SERVER['SCRIPT_NAME']) . '/public/static/js',
        //'__IMG__'    => dirname($_SERVER['SCRIPT_NAME']) . '/public/static/img',
    ],
];