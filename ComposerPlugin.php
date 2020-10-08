<?php

namespace PlainPhp\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Plugin\PluginEvents;
use Composer\Plugin\PostFileDownloadEvent;

class PackageInstallerPlugin implements PluginInterface
{
	public function activate(Composer $composer, IOInterface $io)
	{
		$this->io = $io
		$this->composer = $composer;
	}

	public function installPackage(PostFileDownloadEvent $event) {
		$documentRoot = \realpath($this->composer->getConfig()->get('vendor-dir').'/../');
		$source = $event->getFileName();
		$sourceDirectory = $evemt->getPackage()->getTargetDir();

		$dest = $documentRoot . str_replace($sourceDirectory, '', $source);

		pathinfo($dest);

		if (!file_exists($path['dirname'])) {
			mkdir($path['dirname'], 0644, true);
		}
		copy($source, $dest);
	}

	public static function getSubscribedEvents()
	{
		return array(
			PluginEvents::POST_FILE_DOWNLOAD => 'installPackage',
		);
	}

}
