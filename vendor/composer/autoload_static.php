<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7c4a59b75476ae3882a479eccf7c4cf6
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Miusage\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Miusage\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7c4a59b75476ae3882a479eccf7c4cf6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7c4a59b75476ae3882a479eccf7c4cf6::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
