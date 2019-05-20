<?php

namespace WPGMZA;

if(!defined('WPGMZA_DIR_PATH'))
	return;

require_once(WPGMZA_DIR_PATH . 'includes/class.plugin.php');

class ProPlugin extends Plugin
{
	private $cachedProVersion;
	
	public function __construct()
	{
		Plugin::__construct();
	}
	
	public function getLocalizedData()
	{
		$data = Plugin::getLocalizedData();
		
		return array_merge($data, array(
			'pro_version' => $this->getProVersion()
		));
	}
	
	public function isProVersion()
	{
		return true;
	}
	
	public function getProVersion()
	{
		if($this->cachedProVersion != null)
			return $this->cachedProVersion;
		
		$subject = file_get_contents(plugin_dir_path(__DIR__) . 'wp-google-maps-pro.php');
		if(preg_match('/Version:\s*(.+)/', $subject, $m))
			$this->cachedProVersion = $m[1];
		
		return $this->cachedProVersion;
	}
}
