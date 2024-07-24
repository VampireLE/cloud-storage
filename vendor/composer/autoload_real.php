<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitf024e2684105cc6c574fcf160c05bf5c
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitf024e2684105cc6c574fcf160c05bf5c', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitf024e2684105cc6c574fcf160c05bf5c', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitf024e2684105cc6c574fcf160c05bf5c::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
