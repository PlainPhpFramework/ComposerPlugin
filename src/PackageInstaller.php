<?php
namespace PlainPhp\Composer;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

class PackageInstaller extends LibraryInstaller
{
    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package)
    {
        return 'packages/'.$package->getPrettyName();
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return 'plainphp-package' === $packageType;
    }
}
