<?php
namespace Senkyou\Mvc;

class Model extends \Phalcon\Mvc\Model
{
    protected static $_prefix = false;

    final public function getSource()
    {
        if (self::$_prefix === false) {
            $dbConfig = $this->getDI()->getShared('config')->get('database');
            self::$_prefix = $dbConfig->connections[$dbConfig->default]->prefix;
        }

        return self::$_prefix . $this->_modelsManager->getModelSource($this);
    }
}