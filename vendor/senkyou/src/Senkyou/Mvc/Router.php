<?php
namespace Senkyou\Mvc;

use Phalcon\Mvc\Router as RouterBase;
use Phalcon\Mvc\Router\Route;
use Senkyou\Mvc\Router\RouterGroup;

class Router extends RouterBase
{
    public function get(string $pattern, $path = null): Route
    {
        return $this->add($pattern, $path, 'GET');
    }

    public function post(string $pattern, $path = null): Route
    {
        return $this->add($pattern, $path, 'POST');
    }

    public function put(string $pattern, $path = null): Route
    {
        return $this->add($pattern, $path, 'PUT');
    }

    public function patch(string $pattern, $path = null): Route
    {
        return $this->add($pattern, $path, 'PATCH');
    }

    public function delete(string $pattern, $path = null): Route
    {
        return $this->add($pattern, $path, 'DELETE');
    }

    public function options(string $pattern, $path = null): Route
    {
        return $this->add($pattern, $path, 'OPTIONS');
    }

    public function any(string $pattern, $path = null): Route
    {
        return $this->add($pattern, $path);
    }

    public function match($methods, string $pattern, $path = null): Route
    {
        if (is_array($methods)) {
            foreach ($methods as &$method) {
                $method = strtoupper($method);
            }
            unset($method);
        } else {
            $methods = strtoupper($methods);
        }

        return $this->add($pattern, $path, $methods);
    }

    public function rest(string $pattern, string $controller)
    {
        $this->get($pattern, $controller);
        $this->get($pattern . '/create', $controller . '::create');
        $this->post($pattern, $controller . '::store');
        $this->get($pattern . '/{id}', $controller . '::show');
        $this->get($pattern . '/{id}/edit', $controller . '::edit');
        $this->match(['put', 'patch'], $pattern . '/{id}', $controller . '::update');
        $this->delete($pattern . '/{id}', $controller . '::delete');
    }

    public function group(array $options, \Closure $group)
    {
        $routerGroup = new RouterGroup([
            'namespace' => $options['namespace'] ?? '',
            'controller' => $options['controller'] ?? '',
        ]);

        if (isset($options['hostname']) && $options['hostname']) {
            $routerGroup->setHostname($options['hostname']);
        }

        if (isset($options['prefix']) && $options['prefix']) {
            $routerGroup->setPrefix($options['prefix']);
        }

        if (isset($options['callable']) && is_callable($options['callable'])) {
            $routerGroup->beforeMatch($options['callable']);
        }

        $group = $group->bindTo($routerGroup);
        $group();

        if ($routerGroup->getRoutes()) {
            $this->mount($routerGroup);
        }
    }

    public function isNotFound(): bool
    {
        return !!$this->_notFoundPaths;
    }
}