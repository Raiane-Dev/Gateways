<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2712a0f887fbed1a4cf5e8b49aa8c25d
{
    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'MP' => __DIR__ . '/..' . '/mercadopago/sdk/lib/mercadopago.php',
        'MPRestClient' => __DIR__ . '/..' . '/mercadopago/sdk/lib/mercadopago.php',
        'MercadoPagoException' => __DIR__ . '/..' . '/mercadopago/sdk/lib/mercadopago.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit2712a0f887fbed1a4cf5e8b49aa8c25d::$classMap;

        }, null, ClassLoader::class);
    }
}
