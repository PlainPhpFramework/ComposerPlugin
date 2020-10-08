<?php

namespace PlainPhp\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Plugin\PluginEvents;
use Composer\Plugin\PostFileDownloadEvent;

class PackageInstaller implements PluginInterface
{
	public function activate(Composer $composer, IOInterface $io)
	{
		$this->io = $io;
		$this->composer = $composer;
	}

	public static function getSubscribedEvents()
	{
		return array(
			PluginEvents::POST_FILE_DOWNLOAD => ['onPostFileDownload'],
		);
	}

	public function onPostFileDownload(PostFileDownloadEvent $event) {

		$config = $this->composer->getConfig();
		var_dump($config['type']);

		file_put_contents(__dir__.'/test.txt', 'test');

		if ($config['type'] === 'plainphp-package') {
	
			$documentRoot = \realpath($this->composer->getConfig()->get('vendor-dir').'/../');
			$source = $event->getFileName();
			$sourceDirectory = $evemt->getPackage()->getTargetDir();

			$dest = $documentRoot . '/packages/' . str_replace($sourceDirectory, '', $source);

			pathinfo($dest);

			if (!file_exists($path['dirname'])) {
				mkdir($path['dirname'], 0644, true);
			}
			copy($source, $dest);

		}

	}


}
