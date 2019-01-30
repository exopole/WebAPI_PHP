<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit573bfcf9c9e4671057b7b55e3b7d292b
{
    public static $files = array (
        '253c157292f75eb38082b5acb06f3f01' => __DIR__ . '/..' . '/nikic/fast-route/src/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Slim\\' => 5,
        ),
        'R' => 
        array (
            'Routes\\' => 7,
        ),
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
            'Psr\\Container\\' => 14,
        ),
        'M' => 
        array (
            'Models\\' => 7,
            'Middleware\\' => 11,
        ),
        'K' => 
        array (
            'Kernel\\' => 7,
        ),
        'I' => 
        array (
            'Interop\\Container\\' => 18,
        ),
        'F' => 
        array (
            'FastRoute\\' => 10,
            'Faker\\' => 6,
        ),
        'E' => 
        array (
            'ErwanG\\' => 7,
        ),
        'C' => 
        array (
            'Controllers\\' => 12,
            'Config\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Slim\\' => 
        array (
            0 => __DIR__ . '/..' . '/slim/slim/Slim',
        ),
        'Routes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App/Routes',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App/Models',
        ),
        'Middleware\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App/Middleware',
        ),
        'Kernel\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App/Kernel',
        ),
        'Interop\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/container-interop/container-interop/src/Interop/Container',
        ),
        'FastRoute\\' => 
        array (
            0 => __DIR__ . '/..' . '/nikic/fast-route/src',
        ),
        'Faker\\' => 
        array (
            0 => __DIR__ . '/..' . '/fzaninotto/faker/src/Faker',
        ),
        'ErwanG\\' => 
        array (
            0 => __DIR__ . '/..' . '/erwang/dataobject/src',
        ),
        'Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App/Controllers',
        ),
        'Config\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Config',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'Pimple' => 
            array (
                0 => __DIR__ . '/..' . '/pimple/pimple/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit573bfcf9c9e4671057b7b55e3b7d292b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit573bfcf9c9e4671057b7b55e3b7d292b::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit573bfcf9c9e4671057b7b55e3b7d292b::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
