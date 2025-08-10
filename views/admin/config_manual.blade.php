@include('header')

@php
    if (function_exists('posix_getpwuid') && function_exists('posix_getuid')):
        $user_info = posix_getpwuid(posix_getuid());
        if (!empty($user_info['dir'])):
            $user_info['dir'] .= DIRECTORY_SEPARATOR;
        endif;
    else:
        $user_info = [];
        $user_info['name'] = $lang->msg_queue_instructions['same_as_php'];
    endif;
@endphp

<form action="./" method="post" class="x_form-horizontal">
	<input type="hidden" name="module" value="admin" />
	<input type="hidden" name="act" value="procMcpserverAdminInsertConfigManual" />

	<section>
		<h2>{{ $lang->mcpserver_script_setup_manual }}</h2>

		<div class="mcpserver-script-setup">
			<ul class="mcpserver-tabs x_nav x_nav-tabs">
				<li class="x_active"><a href="#" data-value="systemd">systemd</a></li>
			</ul>
			<div class="mss-content systemd active">
				<p class="mss-instruction">
					<code>/etc/systemd/system/rhymix-mcpserver.service</code> {{ $lang->mcpserver_systemd_file_instruction }} 
				</p>
				<pre><code>[Unit]
Description=Rhymix MCP Server Service

[Service]
ExecStart=/usr/bin/php {!! $run_script_path !!} 

User={$user_info['name']}


[Install]
WantedBy=multi-user.target</code></pre>
				<p class="mss-instruction">
					{{ $lang->mcpserver_systemd_run_instruction }} 
				</p>
				<pre><code>systemctl daemon-reload
systemctl start rhymix-mcpserver.service
systemctl enable rhymix-mcpserver.service</code></pre>

                <p class="mss-instruction">
                    {{ $lang->mcpserver_systemd_status_instruction }}
                </p>
                <pre><code>systemctl status rhymix-mcpserver.service</code></pre>

                <p class="mss-instruction">
                    {{ $lang->mcpserver_systemd_log_instruction }}
                </p>
                <pre><code>journalctl -u rhymix-mcpserver.service -f</code></pre>

                <p class="mss-instruction">
                    <a href="javascript:void(0);" class="x_btn x_btn-primary" id="testLocalConnection">{{ $lang->mcpserver_test_server }}</a>
                </p>
                <script>
                    $('#testLocalConnection').on('click', function() {
                        if (!confirm('{{ $lang->mcpserver_test_confirm }}')) {
                            return;
                        }

                        $(this).prop('disabled', true).text('{{ $lang->mcpserver_testing }}');

                        $.post('./', {
                            module: 'mcpserver',
                            act: 'procMcpserverAdminTestLocalConnection'
                        }, function(response) {
                            if (response.error === 0) {
                                alert('{{ $lang->mcpserver_test_success }}');
                            } else {
                                alert('{{ $lang->mcpserver_test_failed }}' + response.message);
                            }

                            $('#testLocalConnection').prop('disabled', false).text('{{ $lang->mcpserver_test_server }}');
                        }, 'json');
                    });
                </script>
			</div>
		</div>
	</section>

    <section>
		<h2>{{ $lang->mcpserver_server_setup_manual }}</h2>

		<div class="mcpserver-script-setup">
			<ul class="mcpserver-tabs x_nav x_nav-tabs">
				<li class="x_active"><a href="#" data-value="nginx">nginx</a></li>
			</ul>
			<div class="mss-content nginx active">
				<p class="mss-instruction">
                    {!! $lang->mcpserver_nginx_instruction !!}
				<pre><code>server {
    listen 443 ssl http2;
    server_name {!! parse_url(\Context::getRequestUri(), PHP_URL_HOST) !!};
    root {!! rtrim(\RX_BASEDIR, '/') !!};
    ...

    # MCP setting start
    location ~ ^/{{ ltrim($config->mcpPath, '/') }}(?:/|$) {
        proxy_http_version 1.1;
        proxy_set_header Host $http_host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "upgrade";
        @if ($config->mcpSSEEnable)

        # Important for SSE connections
        proxy_buffering off;
        proxy_cache off;
        @endif

        proxy_pass http://{{ $config->serverHost }}:{{ $config->serverPort }};
    }
    # MCP setting end

    ...
}</code></pre>
				<p class="mss-instruction">
					{{ $lang->mcpserver_systemd_run_instruction }} 
				</p>
				<pre><code>systemctl reload nginx</code></pre>

                <p class="mss-instruction">
                    <a href="{{ rtrim(\Context::getRequestUri(), '/') }}/{{ ltrim($config->mcpPath, '/') }}" target="_blank">{{ $lang->mcpserver_external_access_check }}</a>
                </p>
			</div>
		</div>
	</section>
</form>
