<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit765e5e9c279d5c7232027ce0c2911604
{
    public static $classMap = array (
        'PAnD' => __DIR__ . '/..' . '/collizo4sky/persist-admin-notices-dismissal/persist-admin-notices-dismissal.php',
        'WPDI_Plugin_Installer_Skin' => __DIR__ . '/..' . '/afragen/wp-dependency-installer/wp-dependency-installer.php',
        'WP_Dependency_Installer' => __DIR__ . '/..' . '/afragen/wp-dependency-installer/wp-dependency-installer.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit765e5e9c279d5c7232027ce0c2911604::$classMap;

        }, null, ClassLoader::class);
    }
}
