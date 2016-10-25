<?php
/**
 * 获取指定目录下的所有目录的命名空间数组
 *
 * @param string $rootNamespace 根目录下的命名空间
 * @param string $rootPath 根目录
 * @return mixed 返回根目录下所有目录的命名空间数组
 */
function getRegisterDir(string $rootNamespace, string $rootPath): array
{
    $namespaces[$rootNamespace] = $rootPath;

    registerDirectory($rootNamespace, $rootPath, $namespaces);

    return $namespaces;
}

/**
 * 遍历目录，并将目录转化为命名空间形式的关联数组。通过$namespaces参数返回(不含根目录)
 *
 * @param string $rootNamespace 当前目录的命名空间
 * @param string $rootPath 需要遍历的目录的真实路径
 * @param array $namespaces
 */
function registerDirectory(string $rootNamespace, string $rootPath, array& $namespaces = [])
{
    $directory = dir($rootPath);

    while ($fileName = $directory->read()) {
        if ($fileName !== '.' && $fileName !== '..' && is_dir($path = $directory->path . '/' . $fileName)) {
            $namespace = $rootNamespace . '\\' . ucfirst($fileName);
            $namespaces[$namespace] = $path;
            registerDirectory($namespace, $path, $namespaces);
        }
    }
}

/**
 * 获取.env文件下的变量值
 * @param string $key
 * @param null $default
 * @return null|string
 */
function env(string $key, $default = null)
{
    static $properties = null;
    $key = strtoupper($key);

    if (!$properties) {
        $properties = new Phalcon\Config\Adapter\Ini(APP_PATH . '/.env');
    }

    if (isset($properties[$key]) && $properties[$key]) {
        return $properties[$key];
    } else {
        return $default;
    }
}