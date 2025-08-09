@include('header')

<form class="x_form-horizontal" action="./" method="post" id="mcpserver">
	<input type="hidden" name="module" value="mcpserver" />
	<input type="hidden" name="act" value="procMcpserverAdminInsertConfig" />
	<input type="hidden" name="success_return_url" value="{{ getRequestUriByServerEnviroment() }}" />
	<input type="hidden" name="xe_validator_id" value="modules/mcpserver/views/admin/config/1" />

	@if (!empty($XE_VALIDATOR_MESSAGE) && $XE_VALIDATOR_ID == 'modules/mcpserver/views/admin/config/1')
		<div class="message {{ $XE_VALIDATOR_MESSAGE_TYPE }}">
			<p>{{ $XE_VALIDATOR_MESSAGE }}</p>
		</div>
	@endif

	<div class="x_alert x_alert-info">
		<p>본 모듈은 <a href="https://github.com/php-mcp/server" target="_blank">PHP MCP Server</a> 라이브러리를 기반으로 하며, Model Context Protocol(MCP)을 구현합니다.</p>
		<p>설정 변경 후에는 반드시 서버를 재시작해야 적용됩니다.</p>
	</div>

	<section class="section">
		<h1>서버 기본 설정</h1>
		
		<div class="x_control-group">
			<label class="x_control-label" for="serverName">서버명</label>
			<div class="x_controls">
				<input type="text" name="serverName" id="serverName" value="{{ $config->serverName ?? 'MCP Server' }}" class="x_form-control" />
				<p class="x_help-block">MCP(Model Context Protocol) 서버의 식별명입니다. 클라이언트에서 서버를 구분할 때 사용됩니다. (예: "My App Server", "Development Server")</p>
			</div>
		</div>

		<div class="x_control-group">
			<label class="x_control-label" for="serverVersion">서버 버전</label>
			<div class="x_controls">
				<input type="text" name="serverVersion" id="serverVersion" value="{{ $config->serverVersion ?? '1.0.0' }}" class="x_form-control" />
				<p class="x_help-block">서버 버전 정보입니다. Semantic Versioning 형식을 권장합니다. (예: "2.1.0", "1.5.3-beta")</p>
			</div>
		</div>
	</section>

	<section class="section">
		<h1>서버 연결 설정</h1>

		<div class="x_alert x_alert-warning">
			<p>본 설정 변경 후에는 설정 매뉴얼에 따라 모든 파라메터가 정상 세팅되어있는지 반드시 확인해주세요.</p>
		</div>
		
		<div class="x_control-group">
			<label class="x_control-label" for="serverHost">서버 호스트</label>
			<div class="x_controls">
				<input type="text" name="serverHost" id="serverHost" value="{{ $config->serverHost ?? '127.0.0.1' }}" class="x_form-control" />
				<p class="x_help-block">MCP 서버가 바인딩될 IP 주소입니다. (기본값: 127.0.0.1)</p>
			</div>
		</div>

		<div class="x_control-group">
			<label class="x_control-label" for="serverPort">서버 포트</label>
			<div class="x_controls">
				<input type="number" name="serverPort" id="serverPort" value="{{ $config->serverPort ?? 8080 }}" class="x_form-control" min="1" max="65535" />
				<p class="x_help-block">HTTP Transport로 MCP 서버를 실행할 때 사용할 포트 번호입니다. 충돌하지 않는 임의의 포트로 설정해주세요.</p>
			</div>
		</div>

		<div class="x_control-group">
			<label class="x_control-label" for="mcpPath">MCP 경로</label>
			<div class="x_controls">
				<input type="text" name="mcpPath" id="mcpPath" value="{{ $config->mcpPath ?? '/mcp' }}" class="x_form-control" />
				<p class="x_help-block">HTTP Transport에서 MCP 엔드포인트 경로입니다. 클라이언트가 접속할 URL 경로를 지정합니다. (예: "/mcp", "/api/mcp")</p>
			</div>
		</div>
	</section>

	<section class="section">
		<h1>MCP 옵션</h1>
		
		<div class="x_control-group">
			<label class="x_control-label" for="mcpSSEEnable">SSE 활성화</label>
			<div class="x_controls">
				<select name="mcpSSEEnable" id="mcpSSEEnable">
					<option value="Y" @selected($config->mcpSSEEnable ?? false)>활성화</option>
					<option value="N" @selected(!($config->mcpSSEEnable ?? false))>비활성화</option>
				</select>
				<p class="x_help-block">SSE(Server-Sent Events) 기능을 활성화합니다. 만일 가벼운 작업만 진행하며, 응답이 빨라 비동기 기능이 필요없는 경우 비활성화할 수 있습니다. (기본값: 활성화)</p>
			</div>
		</div>

		<div class="x_control-group">
			<label class="x_control-label" for="mcpStateless">Stateless 모드</label>
			<div class="x_controls">
				<select name="mcpStateless" id="mcpStateless">
					<option value="Y" @selected($config->mcpStateless ?? false)>{{ $lang->cmd_yes }}</option>
					<option value="N" @selected(!($config->mcpStateless ?? false))>{{ $lang->cmd_no }}</option>
				</select>
				<p class="x_help-block">세션 관리 없이 각 요청을 독립적으로 처리합니다. 캐시나 메모리 기반 세션을 사용하지 않을 때 활성화하세요. (성능 향상, 메모리 절약)</p>
				@if (\Rhymix\Framework\Config::get('cache.type') === 'dummy' && !$config->mcpStateless)
				<div class="message error">
					<p>MCP session은 캐시가 활성화되어있어야 작동합니다. 현재 라이믹스 캐시가 설정되어있지 않습니다. <a href="@url(['module'=>'admin','act'=>'dispAdminConfigAdvanced'])" target="_blank">캐시를 활성화하거나</a> Stateless 모드를 활성화하세요.</p>
				</div>
				@endif
			</div>
		</div>
	</section>

	<section class="section">
		<h1>로그 설정</h1>
		
		<div class="x_control-group">
			<label class="x_control-label" for="printLog">로그 출력</label>
			<div class="x_controls">
				<select name="printLog" id="printLog">
					<option value="Y" @selected($config->printLog ?? true)>{{ $lang->cmd_yes }}</option>
					<option value="N" @selected(!($config->printLog ?? true))>{{ $lang->cmd_no }}</option>
				</select>
				<p class="x_help-block">PSR-3 호환 로거를 통한 로그 출력을 활성화합니다. 개발 및 디버깅 시 유용하며, 프로덕션에서는 성능을 위해 비활성화할 수 있습니다.</p>
			</div>
		</div>

		<div class="x_control-group">
			<label class="x_control-label">로그 레벨</label>
			<div class="x_controls">
				<div class="x_form-check-list">
					<label class="x_form-check">
						<input type="checkbox" name="logLevel_emergency" value="Y" @checked($config->printLogLevels['emergency'] ?? true) />
						Emergency (긴급)
					</label>
					<label class="x_form-check">
						<input type="checkbox" name="logLevel_alert" value="Y" @checked($config->printLogLevels['alert'] ?? true) />
						Alert (경고)
					</label>
					<label class="x_form-check">
						<input type="checkbox" name="logLevel_critical" value="Y" @checked($config->printLogLevels['critical'] ?? true) />
						Critical (심각)
					</label>
					<label class="x_form-check">
						<input type="checkbox" name="logLevel_error" value="Y" @checked($config->printLogLevels['error'] ?? true) />
						Error (오류)
					</label>
					<label class="x_form-check">
						<input type="checkbox" name="logLevel_warning" value="Y" @checked($config->printLogLevels['warning'] ?? true) />
						Warning (경고)
					</label>
					<label class="x_form-check">
						<input type="checkbox" name="logLevel_notice" value="Y" @checked($config->printLogLevels['notice'] ?? true) />
						Notice (알림)
					</label>
					<label class="x_form-check">
						<input type="checkbox" name="logLevel_info" value="Y" @checked($config->printLogLevels['info'] ?? true) />
						Info (정보)
					</label>
					<label class="x_form-check">
						<input type="checkbox" name="logLevel_debug" value="Y" @checked($config->printLogLevels['debug'] ?? true) />
						Debug (디버그)
					</label>
				</div>
				<p class="x_help-block">PSR-3 로그 레벨별 출력 설정입니다. 상위 레벨일수록 중요한 로그입니다.</p>
			</div>
		</div>
	</section>

	<div class="btnArea x_clearfix">
		<button type="submit" class="x_btn x_btn-primary x_pull-right" style="margin-right: 10px;">{{ $lang->cmd_registration }}</button>
	</div>

</form>
