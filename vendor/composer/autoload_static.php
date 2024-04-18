<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf024e2684105cc6c574fcf160c05bf5c
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\CloudStorage\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\CloudStorage\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf024e2684105cc6c574fcf160c05bf5c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf024e2684105cc6c574fcf160c05bf5c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf024e2684105cc6c574fcf160c05bf5c::$classMap;

        }, null, ClassLoader::class);
    }
}
