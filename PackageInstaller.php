<?php

namespace PlainPhp\Composer;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

class TemplateInstaller extends LibraryInstaller
{
    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package)
    {
        return 'packages';
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return 'plainphp-package' === $packageType;
    }
}
