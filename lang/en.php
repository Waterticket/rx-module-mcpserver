<?php

$lang->cmd_mcpserver = 'MCP Server';
$lang->cmd_mcpserver_general_config = 'General Configuration';
$lang->cmd_mcpserver_example_config = 'Example Configuration';

// MCP Method List page
$lang->mcpserver_method_list_title = 'MCP Method List';
$lang->mcpserver_restart_notice = 'Important Notice: After modifying methods, you must restart the server for the changes to take effect.';
$lang->mcpserver_section_tools = 'Tools';
$lang->mcpserver_section_resources = 'Resources';
$lang->mcpserver_section_resource_templates = 'Resource Templates';
$lang->mcpserver_section_prompts = 'Prompts';
$lang->mcpserver_handler = 'Handler';
$lang->mcpserver_manual = 'Manual';
$lang->mcpserver_completion_providers = 'Completion Providers';
$lang->mcpserver_detail_info = 'Detail Information';
$lang->mcpserver_name = 'Name';
$lang->mcpserver_description = 'Description';
$lang->mcpserver_uri = 'URI';
$lang->mcpserver_mime_type = 'MIME Type';
$lang->mcpserver_uri_template = 'URI Template';
$lang->mcpserver_handler_type = 'Handler Type';
$lang->mcpserver_handler_type_string = 'String';
$lang->mcpserver_handler_type_array = 'Array';
$lang->mcpserver_handler_type_callable = 'Callable';
$lang->mcpserver_manual_mode = 'Manual Mode';
$lang->mcpserver_input_schema = 'Input Schema';
$lang->mcpserver_arguments = 'Arguments';
$lang->mcpserver_completion_providers_list = 'Completion Provider List';
$lang->mcpserver_yes = 'Yes';
$lang->mcpserver_no = 'No';
$lang->mcpserver_no_methods = 'No MCP methods registered.';
$lang->mcpserver_method_changed_title = 'Methods have changed!';
$lang->mcpserver_method_changed_message = 'Methods have been modified after server restart, server restart is required.';

// Config page
$lang->mcpserver_config_description = 'This module is based on the <a href="https://github.com/php-mcp/server" target="_blank">PHP MCP Server</a> library and implements the Model Context Protocol (MCP).';
$lang->mcpserver_config_restart_notice = 'After configuration changes, you must restart the server for the changes to take effect.';
$lang->mcpserver_section_server_basic = 'Server Basic Configuration';
$lang->mcpserver_server_name = 'Server Name';
$lang->mcpserver_server_name_help = 'Identifier name for the MCP (Model Context Protocol) server. Used by clients to distinguish servers. (e.g., "My App Server", "Development Server")';
$lang->mcpserver_server_version = 'Server Version';
$lang->mcpserver_server_version_help = 'Server version information. Semantic Versioning format is recommended. (e.g., "2.1.0", "1.5.3-beta")';
$lang->mcpserver_section_server_connection = 'Server Connection Configuration';
$lang->mcpserver_connection_warning = 'After changing these settings, please ensure all parameters are properly configured according to the configuration manual.';
$lang->mcpserver_server_host = 'Server Host';
$lang->mcpserver_server_host_help = 'IP address that the MCP server will bind to. (Default: 127.0.0.1)';
$lang->mcpserver_server_port = 'Server Port';
$lang->mcpserver_server_port_help = 'Port number to use when running the MCP server with HTTP Transport. Please set to any available port to avoid conflicts.';
$lang->mcpserver_mcp_path = 'MCP Path';
$lang->mcpserver_mcp_path_help = 'MCP endpoint path for HTTP Transport. Specifies the URL path for clients to connect. (e.g., "/mcp", "/api/mcp")';
$lang->mcpserver_section_mcp_options = 'MCP Options';
$lang->mcpserver_sse_enable = 'Enable SSE';
$lang->mcpserver_enable = 'Enable';
$lang->mcpserver_disable = 'Disable';
$lang->mcpserver_sse_help = 'Enables SSE (Server-Sent Events) functionality. If you are only doing lightweight tasks and fast responses where asynchronous functionality is not needed, you can disable this. (Default: Enabled)';
$lang->mcpserver_stateless_mode = 'Stateless Mode';
$lang->mcpserver_stateless_help = 'Processes each request independently without session management. Enable when not using cache or memory-based sessions. (Performance improvement, memory saving)';
$lang->mcpserver_cache_warning = 'MCP session requires cache to be enabled. Currently, Rhymix cache is not configured. <a href="@url([\'module\'=>\'admin\',\'act\'=>\'dispAdminConfigAdvanced\'])" target="_blank">Enable cache</a> or activate Stateless mode.';
$lang->mcpserver_section_log = 'Log Configuration';
$lang->mcpserver_log_output = 'Log Output';
$lang->mcpserver_log_help = 'Enables log output through PSR-3 compatible logger. Useful for development and debugging, can be disabled in production for performance.';
$lang->mcpserver_log_level = 'Log Level';
$lang->mcpserver_log_level_help = 'PSR-3 log level output settings. Higher levels represent more critical logs.';
$lang->mcpserver_log_emergency = 'Emergency';
$lang->mcpserver_log_alert = 'Alert';
$lang->mcpserver_log_critical = 'Critical';
$lang->mcpserver_log_error = 'Error';
$lang->mcpserver_log_warning = 'Warning';
$lang->mcpserver_log_notice = 'Notice';
$lang->mcpserver_log_info = 'Info';
$lang->mcpserver_log_debug = 'Debug';

// Header navigation
$lang->mcpserver_nav_server_config = 'Server Configuration';
$lang->mcpserver_nav_config_manual = 'Configuration Manual';
$lang->mcpserver_nav_method_list = 'Method List';

// Config Manual page
$lang->mcpserver_script_setup_manual = 'Script Setup Manual';
$lang->mcpserver_systemd_file_instruction = 'file with the following content.';
$lang->mcpserver_systemd_run_instruction = 'Execute the following commands and monitor if they work properly.';
$lang->mcpserver_systemd_status_instruction = 'To check the service status, use the following command:';
$lang->mcpserver_systemd_log_instruction = 'To check logs, use the following command:';
$lang->mcpserver_test_server = 'Test Server Status';
$lang->mcpserver_test_confirm = 'Do you want to check if the server is running?';
$lang->mcpserver_testing = 'Testing...';
$lang->mcpserver_test_success = 'Local connection test completed successfully.';
$lang->mcpserver_test_failed = 'Local connection test failed: ';
$lang->mcpserver_server_setup_manual = 'Server Setup Manual';
$lang->mcpserver_nginx_instruction = 'To allow external access to the MCP server, add the following content to your <code>nginx</code> configuration file.';
$lang->mcpserver_nginx_reload_instruction = 'Execute the following command and monitor if it works properly.';
$lang->mcpserver_external_access_check = 'Check External Access Availability';