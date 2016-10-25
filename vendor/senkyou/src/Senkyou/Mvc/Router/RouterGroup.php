<?php
namespace Senkyou\Mvc\Router;

use Phalcon\Mvc\Router\Group;
use Phalcon\Mvc\Router\Route;

class RouterGroup extends Group
{
    public function get(string $pattern, $path = null): Route
    {
        return $this->_addRoute($pattern, $path, 'GET');
    }

    public function post(string $pattern, $path = null): Route
    {
        return $this->_addRoute($pattern, $path, 'POST');
    }

    public function put(string $pattern, $path = null): Route
    {
        return $this->_addRoute($pattern, $path, 'PUT');
    }

    public function patch(string $pattern, $path = null): Route
    {
        return $this->_addRoute($pattern, $path, 'PATCH');
    }

    public function delete(string $pattern, $path = null): Route
    {
        return $this->_addRoute($pattern, $path, 'DELETE');
    }

    public function options(string $pattern, $path = null): Route
    {
        return $this->_addRoute($pattern, $path, 'OPTIONS');
    }

    public function any(string $pattern, $path = null): Route
    {
        return $this->_addRoute($pattern, $path);
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

        return $this->_addRoute($pattern, $path, $methods);
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
}