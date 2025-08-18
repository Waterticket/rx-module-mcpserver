<?php

namespace Rhymix\Modules\Mcpserver\Models;

require_once __DIR__ . '/../vendor/autoload.php';

use ModuleController;
use ModuleModel;
use Psr\Log\LogLevel;

/**
 * MCP Server
 * 
 * Copyright (c) Waterticket
 * 
 * Generated with https://www.poesis.dev/tools/rxmodulegen
 */
class Config
{
	/**
	 * 모듈 설정 캐시를 위한 변수.
	 */
	protected static $_cache = null;
	
	/**
	 * 모듈 설정을 가져오는 함수.
	 * 
	 * 캐시 처리되기 때문에 ModuleModel을 직접 호출하는 것보다 효율적이다.
	 * 모듈 내에서 설정을 불러올 때는 가급적 이 함수를 사용하도록 한다. 
	 * 
	 * @return object
	 */
	public static function getConfig()
	{
		if (self::$_cache === null)
		{
			self::$_cache = ModuleModel::getModuleConfig('mcpserver') ?: new \stdClass;

			if (!isset(self::$_cache->uniqueKey)) {
				self::$_cache->uniqueKey = \Rhymix\Framework\Security::getRandomUUID();
				self::setConfig(self::$_cache); // Save the unique key if it was not set
			}

			if (!isset(self::$_cache->serverName)) self::$_cache->serverName = 'Rhymix MCP Server';
			if (!isset(self::$_cache->serverVersion)) self::$_cache->serverVersion = '1.0.0';

			if (!isset(self::$_cache->serverHost)) self::$_cache->serverHost = '127.0.0.1';
			if (!isset(self::$_cache->serverPort)) self::$_cache->serverPort = 8080;
			if (!isset(self::$_cache->mcpPath)) self::$_cache->mcpPath = '/mcp';

			if (!isset(self::$_cache->mcpSSEEnable)) self::$_cache->mcpSSEEnable = true;
			if (!isset(self::$_cache->mcpStateless)) self::$_cache->mcpStateless = false;
			if (!isset(self::$_cache->disableExampleMethods)) self::$_cache->disableExampleMethods = false;

			if (!isset(self::$_cache->printLog)) self::$_cache->printLog = true;
			if (!isset(self::$_cache->printLogLevels)) {
				self::$_cache->printLogLevels = [
					LogLevel::EMERGENCY => true,
					LogLevel::ALERT => true,
					LogLevel::CRITICAL => true,
					LogLevel::ERROR => true,
					LogLevel::WARNING => true,
					LogLevel::NOTICE => true,
					LogLevel::INFO => true,
					LogLevel::DEBUG => true,
				];
			}
		}
		return self::$_cache;
	}
	
	/**
	 * 모듈 설정을 저장하는 함수.
	 * 
	 * 설정을 변경할 필요가 있을 때 ModuleController를 직접 호출하지 말고 이 함수를 사용한다.
	 * getConfig()으로 가져온 설정을 적절히 변경하여 setConfig()으로 다시 저장하는 것이 정석.
	 * 
	 * @param object $config
	 * @return object
	 */
	public static function setConfig($config)
	{
		$oModuleController = ModuleController::getInstance();
		$result = $oModuleController->insertModuleConfig('mcpserver', $config);
		if ($result->toBool())
		{
			self::$_cache = $config;
		}
		return $result;
	}
}
