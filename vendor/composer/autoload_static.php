<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit117aa16ba76deedac6048189ab315c05
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'LINE\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'LINE\\' => 
        array (
            0 => __DIR__ . '/..' . '/linecorp/line-bot-sdk/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit117aa16ba76deedac6048189ab315c05::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit117aa16ba76deedac6048189ab315c05::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
