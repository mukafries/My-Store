<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita5e0aac5643b72dd30244ec96f0c1e26
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'app\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita5e0aac5643b72dd30244ec96f0c1e26::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita5e0aac5643b72dd30244ec96f0c1e26::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita5e0aac5643b72dd30244ec96f0c1e26::$classMap;

        }, null, ClassLoader::class);
    }
}
