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

        $filesToMove = array_merge(glob($downloadPath.'/config/*'), glob($downloadPath.'/hooks/*'));

        foreach ($filesToMove as $file) {
            $target = str_replace('/packages/', '/app/', $file);
            if (file_exists($target)) {
                continue;
            } else {
                copy($file, $target);
            }
        }

        $appPath = str_replace('/packages/', '/app/', $downloadPath);
        $filesToCheck = array_merge(glob($appPath.'/config/*'), glob($appPath.'/hooks/*'));
        
        foreach ($filesToMove as $file) {
            $package = str_replace('/app/', '/packages/', $file);
            if (file_exists($package)) {
                continue;
            } else {
                rename($file, $file.'.bk');
            }
        }
        
        return parent::cleanup($type, $package, $prevPackage);

    }

}
