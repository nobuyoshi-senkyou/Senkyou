<?php
namespace Senkyou\Di;

use Phalcon\Config;
use Phalcon\Debug;
use Phalcon\Di\FactoryDefault;

class Service extends FactoryDefault
{
    public function __construct(string $configDir)
    {
        parent::__construct();

        $this->setConfig($configDir);
        $this->bindServices();
    }

    protected function bindServices()
    {
        $reflection = new \ReflectionObject($this);
        $methods = $reflection->getMethods();

        foreach ($methods as $method) {
            if ((strlen($method->name) > 10) && (strpos($method->name, 'initShared') === 0)) {
                $this->setShared(lcfirst(substr($method->name, 10)), $method->getClosure($this));
            } elseif ((strlen($method->name) > 4) && (strpos($method->name, 'init') === 0)) {
                $this->set(lcfirst(substr($method->name, 4)), $method->getClosure($this));
            }
        }
    }

    /**
     * 将配置目录内的所有文件加载到服务中
     * @param string $configDir
     */
    protected function setConfig(string $configDir)
    {
        $dir = dir($configDir);
        $config = new Config();
        while ($fileName = $dir->read()) {
            $pathName = $dir->path . '/' . $fileName;
            if (!is_dir($pathName)) {
                $config->merge(new Config([pathinfo($fileName, PATHINFO_FILENAME) => include $pathName]));
            }
        }

        if ($config->get('app')->debug === true) {
            $debug = new Debug();
            $debug->listen();
        }

        $this->setShared('config', $config);

    }
}