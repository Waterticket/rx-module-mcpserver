@load('config.scss')
@load('config.js')

{{-- 템플릿 v2 문법은 https://rhymix.org/manual/theme/template_v2 참고하세요 --}}

<div class="x_page-header">
	<h1>{{ $lang->cmd_mcpserver }}</h1>
</div>

<ul class="x_nav x_nav-tabs">
	<li @class(['x_active' => $act === 'dispMcpserverAdminConfig'])>
		<a href="@url(['module' => 'admin', 'act' => 'dispMcpserverAdminConfig'])">{{ $lang->mcpserver_nav_server_config }}</a>
	</li>
    <li @class(['x_active' => $act === 'dispMcpserverAdminConfigManual'])>
		<a href="@url(['module' => 'admin', 'act' => 'dispMcpserverAdminConfigManual'])">{{ $lang->mcpserver_nav_config_manual }}</a>
    </li>
	<li @class(['x_active' => $act === 'dispMcpserverAdminMethodList'])>
		<a href="@url(['module' => 'admin', 'act' => 'dispMcpserverAdminMethodList'])">{{ $lang->mcpserver_nav_method_list }}</a>
	</li>
</ul>
