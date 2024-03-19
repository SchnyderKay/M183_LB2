<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit81be22b1aa7c4683e088a69db4b4f264
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'RobThree\\Auth\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'RobThree\\Auth\\' => 
        array (
            0 => __DIR__ . '/..' . '/robthree/twofactorauth/lib',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit81be22b1aa7c4683e088a69db4b4f264::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit81be22b1aa7c4683e088a69db4b4f264::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit81be22b1aa7c4683e088a69db4b4f264::$classMap;

        }, null, ClassLoader::class);
    }
}
