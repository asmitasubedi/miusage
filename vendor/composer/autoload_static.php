<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3ae37c1af267a10656af994ac8e420bc
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit3ae37c1af267a10656af994ac8e420bc::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3ae37c1af267a10656af994ac8e420bc::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
