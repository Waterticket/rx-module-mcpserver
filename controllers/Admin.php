<?php

namespace Rhymix\Modules\Mcpserver\Controllers;

use Rhymix\Framework\Cache;
use Rhymix\Framework\DB;
use Rhymix\Framework\Exception;
use Rhymix\Framework\Storage;
use Rhymix\Framework\Request;
use Rhymix\Modules\Mcpserver\Models\Config as ConfigModel;
use BaseObject;
use Context;
use Psr\Log\LogLevel;

/**
 * MCP Server
 *
 * Copyright (c) Waterticket
 *
 * Generated with https://www.poesis.dev/tools/rxmodulegen
 */
class Admin extends Base
{
	/**
	 * 초기화
	 */
	public function init()
	{
		// 관리자 화면 템플릿 경로 지정
		$this->setTemplatePath($this->module_path . 'views/admin/');
	}

	/**
	 * 관리자 설정 화면 예제
	 */
	public function dispMcpserverAdminConfig()
	{
		// 현재 설정 상태 불러오기
		$config = ConfigModel::getConfig();

		// Context에 세팅
		Context::set('config', $config);

		// 스킨 파일 지정
		$this->setTemplateFile('config');
	}

	public function dispMcpserverAdminConfigManual()
	{
		$config = ConfigModel::getConfig();
		Context::set('config', $config);

		Context::set('run_script_path', __DIR__ . '/Run.php');
		// 관리자 설정 매뉴얼 화면
		$this->setTemplateFile('config_manual');
	}

	/**
	 * 관리자 설정 저장 액션
	 */
	public function procMcpserverAdminInsertConfig()
	{
		// 현재 설정 상태 불러오기
		$config = ConfigModel::getConfig();

		// 제출받은 데이터 불러오기
		$vars = Context::getRequestVars();

		// 서버 기본 설정
		if (isset($vars->serverName) && trim($vars->serverName))
		{
			$config->serverName = trim($vars->serverName);
		}
		if (isset($vars->serverVersion) && trim($vars->serverVersion))
		{
			$config->serverVersion = trim($vars->serverVersion);
		}

		// 서버 연결 설정
		if (isset($vars->serverHost) && trim($vars->serverHost))
		{
			$config->serverHost = trim($vars->serverHost);
		}
		if (isset($vars->serverPort) && is_numeric($vars->serverPort))
		{
			$config->serverPort = (int)$vars->serverPort;
		}
		if (isset($vars->mcpPath) && trim($vars->mcpPath))
		{
			$config->mcpPath = '/' . ltrim($vars->mcpPath, '/');
		}

		// MCP 옵션 설정
		$config->mcpSSEEnable = ($vars->mcpSSEEnable === 'Y');
		$config->mcpStateless = ($vars->mcpStateless === 'Y');

		// 로그 설정
		$config->printLog = ($vars->printLog === 'Y');
		
		// 로그 레벨 설정
		$config->printLogLevels = [
			LogLevel::EMERGENCY => ($vars->logLevel_emergency === 'Y'),
			LogLevel::ALERT => ($vars->logLevel_alert === 'Y'),
			LogLevel::CRITICAL => ($vars->logLevel_critical === 'Y'),
			LogLevel::ERROR => ($vars->logLevel_error === 'Y'),
			LogLevel::WARNING => ($vars->logLevel_warning === 'Y'),
			LogLevel::NOTICE => ($vars->logLevel_notice === 'Y'),
			LogLevel::INFO => ($vars->logLevel_info === 'Y'),
			LogLevel::DEBUG => ($vars->logLevel_debug === 'Y'),
		];

		// 변경된 설정을 저장
		$output = ConfigModel::setConfig($config);
		if (!$output->toBool())
		{
			return $output;
		}

		// 설정 화면으로 리다이렉트
		$this->setMessage('success_registed');
		$this->setRedirectUrl(Context::get('success_return_url'));
	}

	public function procMcpserverAdminTestLocalConnection()
	{
		$config = ConfigModel::getConfig();

		$host = $config->serverHost;
		$port = $config->serverPort;
		$mcpPath = $config->mcpPath;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://$host:$port$mcpPath");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Accept: application/json',
			'Content-Type: application/json',
		]);

		curl_exec($ch);

		// if timeout or connection error
		if (curl_errno($ch)) {
			$error = curl_error($ch);
			curl_close($ch);
			return new BaseObject(-1, 'connection_failed');
		}

		curl_close($ch);
		return new BaseObject();
	}
}
