<?php
namespace Senkyou\Di;

use Phalcon\Mvc\Dispatcher;
use Senkyou\Mvc\Router;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;

class ServiceDefault extends Service
{
    protected function initSharedDb()
    {
        $config = $this->get('config')->get('database')->toArray();
        $dbClass = 'Phalcon\Db\Adapter\Pdo\\' . $config['default'];

        unset($config['connections'][$config['default']]['prefix']);
        return new $dbClass($config['connections'][$config['default']]);
    }

    protected function initSharedSession()
    {
        $config = $this->get('config')->get('session');

        $sessionClass = 'Phalcon\Session\Adapter\\' . $config->driver;
        $session = new $sessionClass();
        $session->start();

        return $session;
    }

    protected function initSharedDispatcher()
    {
        $dispatcher = new Dispatcher();
        $dispatcher->setDefaultNamespace($this->get('config')->get('app')->namespace);
        $dispatcher->setActionSuffix('');

        return $dispatcher;
    }

    protected function initSharedView()
    {
        $config = $this->get('config')->get('view');
        $view = new View();
        $view->setViewsDir($config->path);

        $view->registerEngines([
            '.volt' => function ($view, $di) use ($config) {
                $volt = new Volt($view, $di);

                $volt->setOptions([
                    'compiledPath' => $config->compiled,
                    'compiledSeparator' => '_'
                ]);

                return $volt;
            },
            '.phtml' => 'Phalcon\Mvc\View\Engine\Php',
        ]);

        return $view;
    }

    protected function initSharedRouter()
    {
        $routerConfig = $this->get('config')->get('app')->router;

        if ($routerConfig->default) {
            $router = new \Phalcon\Mvc\Router();
            $router->add('/');
        } else {
            $router = new Router(false);

            foreach ($routerConfig->customer->paths as $path) {
                include_once $path;
            }
        }

        $router->removeExtraSlashes(true);

        return $router;
    }


}