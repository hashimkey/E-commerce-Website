<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdf73d50c396188cb1b79345372d8513a
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdf73d50c396188cb1b79345372d8513a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdf73d50c396188cb1b79345372d8513a::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}