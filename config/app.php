<?php
return [
    /**
     * Default Namespace
     */
    'namespace' => 'App\Controller',

    /**
     * Enabled or Disabled Debug
     */
    'debug' => env('APP_DEBUG', false),

    'router' => [
        /**
         * 默认情况下不开启自定义路由功能。如果需要开启自定义
         * 路由功能只需将值改为false即可
         */
        'default' => true,

        //仅当开启自定义路由时生效
        'customer' => [
            /**
             * 值为包含路由文件的数组。默认情况下将
             * app目录下的routers.php作为路由文件
             */
            'paths' => [
                APP_PATH . '/app/routes.php',
            ],
        ],
    ],
];