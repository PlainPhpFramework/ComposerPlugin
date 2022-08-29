<?php

namespace PlainPhp\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Package\PackageInterface;


class PackageInstallerPlugin implements PluginInterface
{

    private $installer;

    public function activate(Composer $composer, IOInterface $io)
    {
        $this->installer = new PackageInstaller($io, $composer);
        $composer->getInstallationManager()->addInstaller($this->installer);
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
        $composer->getInstallationManager()->removeInstaller($this->installer);
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
    }

    public function cleanup($type, PackageInterface $package, PackageInterface $prevPackage = null)
    {

        $this->initializeVendorDir();
        $downloadPath = $this->getInstallPath($package);
        $packageName = $package->getPrettyName();

        // Move config files into the app directory
        $filesToMove = glob($downloadPath.'/'.$packageName.'/config/*');

        foreach ($filesToMove as $file) {
            $target = $downloadPath .'/../app/config/'.basename($file);
            if (file_exists($target)) {
                continue;
            } else {
                copy($file, $target);
            }
        }
        
    }

}
