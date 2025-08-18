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
		<p>{!! $lang->mcpserver_config_description !!}</p>
		<p>{{ $lang->mcpserver_config_restart_notice }}</p>
	</div>

	<section class="section">
		<h1>{{ $lang->mcpserver_section_server_basic }}</h1>
		
		<div class="x_control-group">
			<label class="x_control-label" for="serverName">{{ $lang->mcpserver_server_name }}</label>
			<div class="x_controls">
				<input type="text" name="serverName" id="serverName" value="{{ $config->serverName ?? 'MCP Server' }}" class="x_form-control" />
				<p class="x_help-block">{{ $lang->mcpserver_server_name_help }}</p>
			</div>
		</div>

		<div class="x_control-group">
			<label class="x_control-label" for="serverVersion">{{ $lang->mcpserver_server_version }}</label>
			<div class="x_controls">
				<input type="text" name="serverVersion" id="serverVersion" value="{{ $config->serverVersion ?? '1.0.0' }}" class="x_form-control" />
				<p class="x_help-block">{{ $lang->mcpserver_server_version_help }}</p>
			</div>
		</div>
	</section>

	<section class="section">
		<h1>{{ $lang->mcpserver_section_server_connection }}</h1>

		<div class="x_alert x_alert-warning">
			<p>{{ $lang->mcpserver_connection_warning }}</p>
		</div>
		
		<div class="x_control-group">
			<label class="x_control-label" for="serverHost">{{ $lang->mcpserver_server_host }}</label>
			<div class="x_controls">
				<input type="text" name="serverHost" id="serverHost" value="{{ $config->serverHost ?? '127.0.0.1' }}" class="x_form-control" />
				<p class="x_help-block">{{ $lang->mcpserver_server_host_help }}</p>
			</div>
		</div>

		<div class="x_control-group">
			<label class="x_control-label" for="serverPort">{{ $lang->mcpserver_server_port }}</label>
			<div class="x_controls">
				<input type="number" name="serverPort" id="serverPort" value="{{ $config->serverPort ?? 8080 }}" class="x_form-control" min="1" max="65535" />
				<p class="x_help-block">{{ $lang->mcpserver_server_port_help }}</p>
			</div>
		</div>

		<div class="x_control-group">
			<label class="x_control-label" for="mcpPath">{{ $lang->mcpserver_mcp_path }}</label>
			<div class="x_controls">
				<input type="text" name="mcpPath" id="mcpPath" value="{{ $config->mcpPath ?? '/mcp' }}" class="x_form-control" />
				<p class="x_help-block">{{ $lang->mcpserver_mcp_path_help }}</p>
			</div>
		</div>
	</section>

	<section class="section">
		<h1>{{ $lang->mcpserver_section_mcp_options }}</h1>
		
		<div class="x_control-group">
			<label class="x_control-label" for="mcpSSEEnable">{{ $lang->mcpserver_sse_enable }}</label>
			<div class="x_controls">
				<select name="mcpSSEEnable" id="mcpSSEEnable">
					<option value="Y" @selected($config->mcpSSEEnable ?? false)>{{ $lang->mcpserver_enable }}</option>
					<option value="N" @selected(!($config->mcpSSEEnable ?? false))>{{ $lang->mcpserver_disable }}</option>
				</select>
				<p class="x_help-block">{{ $lang->mcpserver_sse_help }}</p>
			</div>
		</div>

		<div class="x_control-group">
			<label class="x_control-label" for="mcpStateless">{{ $lang->mcpserver_stateless_mode }}</label>
			<div class="x_controls">
				<select name="mcpStateless" id="mcpStateless">
					<option value="Y" @selected($config->mcpStateless ?? false)>{{ $lang->cmd_yes }}</option>
					<option value="N" @selected(!($config->mcpStateless ?? false))>{{ $lang->cmd_no }}</option>
				</select>
				<p class="x_help-block">{{ $lang->mcpserver_stateless_help }}</p>
				@if (\Rhymix\Framework\Config::get('cache.type') === 'dummy' && !$config->mcpStateless)
				<div class="message error">
					<p>{!! $lang->mcpserver_cache_warning !!}</p>
				</div>
				@endif
			</div>
		</div>

		<div class="x_control-group">
			<label class="x_control-label" for="disableExampleMethods">{{ $lang->mcpserver_disable_example_methods }}</label>
			<div class="x_controls">
				<select name="disableExampleMethods" id="disableExampleMethods">
					<option value="Y" @selected($config->disableExampleMethods ?? false)>{{ $lang->cmd_yes }}</option>
					<option value="N" @selected(!($config->disableExampleMethods ?? false))>{{ $lang->cmd_no }}</option>
				</select>
				<p class="x_help-block">{{ $lang->mcpserver_disable_example_methods_help }}</p>
			</div>
		</div>
	</section>

	<section class="section">
		<h1>{{ $lang->mcpserver_section_log }}</h1>
		
		<div class="x_control-group">
			<label class="x_control-label" for="printLog">{{ $lang->mcpserver_log_output }}</label>
			<div class="x_controls">
				<select name="printLog" id="printLog">
					<option value="Y" @selected($config->printLog ?? true)>{{ $lang->cmd_yes }}</option>
					<option value="N" @selected(!($config->printLog ?? true))>{{ $lang->cmd_no }}</option>
				</select>
				<p class="x_help-block">{{ $lang->mcpserver_log_help }}</p>
			</div>
		</div>

		<div class="x_control-group">
			<label class="x_control-label">{{ $lang->mcpserver_log_level }}</label>
			<div class="x_controls">
				<div class="x_form-check-list">
					<label class="x_form-check">
						<input type="checkbox" name="logLevel_emergency" value="Y" @checked($config->printLogLevels['emergency'] ?? true) />
						{{ $lang->mcpserver_log_emergency }}
					</label>
					<label class="x_form-check">
						<input type="checkbox" name="logLevel_alert" value="Y" @checked($config->printLogLevels['alert'] ?? true) />
						{{ $lang->mcpserver_log_alert }}
					</label>
					<label class="x_form-check">
						<input type="checkbox" name="logLevel_critical" value="Y" @checked($config->printLogLevels['critical'] ?? true) />
						{{ $lang->mcpserver_log_critical }}
					</label>
					<label class="x_form-check">
						<input type="checkbox" name="logLevel_error" value="Y" @checked($config->printLogLevels['error'] ?? true) />
						{{ $lang->mcpserver_log_error }}
					</label>
					<label class="x_form-check">
						<input type="checkbox" name="logLevel_warning" value="Y" @checked($config->printLogLevels['warning'] ?? true) />
						{{ $lang->mcpserver_log_warning }}
					</label>
					<label class="x_form-check">
						<input type="checkbox" name="logLevel_notice" value="Y" @checked($config->printLogLevels['notice'] ?? true) />
						{{ $lang->mcpserver_log_notice }}
					</label>
					<label class="x_form-check">
						<input type="checkbox" name="logLevel_info" value="Y" @checked($config->printLogLevels['info'] ?? true) />
						{{ $lang->mcpserver_log_info }}
					</label>
					<label class="x_form-check">
						<input type="checkbox" name="logLevel_debug" value="Y" @checked($config->printLogLevels['debug'] ?? true) />
						{{ $lang->mcpserver_log_debug }}
					</label>
				</div>
				<p class="x_help-block">{{ $lang->mcpserver_log_level_help }}</p>
			</div>
		</div>
	</section>

	<div class="btnArea x_clearfix">
		<button type="submit" class="x_btn x_btn-primary x_pull-right" style="margin-right: 10px;">{{ $lang->cmd_registration }}</button>
	</div>

</form>
