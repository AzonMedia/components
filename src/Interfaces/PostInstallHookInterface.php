<?php
declare(strict_types=1);

namespace Azonmedia\Components\Interfaces;

use Composer\Installer\PackageEvent;

interface PostInstallHookInterface
{
    /**
     * This method will be executed after the package is installed with composer.
     * @param PackageEvent $PackageEvent
     * @return bool
     */
    public static function post_installation_hook(PackageEvent $PackageEvent) : bool ;
}