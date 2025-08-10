<?php

$lang->cmd_mcpserver = 'MCP Server';
$lang->cmd_mcpserver_general_config = '기본 설정';
$lang->cmd_mcpserver_example_config = '예제 설정';

// MCP Method List page
$lang->mcpserver_method_list_title = 'MCP 메서드 목록';
$lang->mcpserver_restart_notice = '중요 안내: 메서드를 수정한 후에는 서버를 재시작해야 변경사항이 반영됩니다.';
$lang->mcpserver_section_tools = '도구 (Tools)';
$lang->mcpserver_section_resources = '리소스 (Resources)';
$lang->mcpserver_section_resource_templates = '리소스 템플릿 (Resource Templates)';
$lang->mcpserver_section_prompts = '프롬프트 (Prompts)';
$lang->mcpserver_handler = '핸들러';
$lang->mcpserver_manual = '수동';
$lang->mcpserver_completion_providers = '완성 제공자';
$lang->mcpserver_detail_info = '상세 정보';
$lang->mcpserver_name = '이름';
$lang->mcpserver_description = '설명';
$lang->mcpserver_uri = 'URI';
$lang->mcpserver_mime_type = 'MIME 타입';
$lang->mcpserver_uri_template = 'URI 템플릿';
$lang->mcpserver_handler_type = '핸들러 타입';
$lang->mcpserver_handler_type_string = '문자열';
$lang->mcpserver_handler_type_array = '배열';
$lang->mcpserver_handler_type_callable = '콜러블';
$lang->mcpserver_manual_mode = '수동 모드';
$lang->mcpserver_input_schema = '입력 스키마';
$lang->mcpserver_arguments = '인수';
$lang->mcpserver_completion_providers_list = '완성 제공자 목록';
$lang->mcpserver_yes = '예';
$lang->mcpserver_no = '아니오';
$lang->mcpserver_no_methods = '등록된 MCP 메서드가 없습니다.';
$lang->mcpserver_method_changed_title = '메서드가 변경되었습니다!';
$lang->mcpserver_method_changed_message = '서버 재시작 후 메서드가 변경되어 서버 재시작이 필요합니다.';

// Config page
$lang->mcpserver_config_description = '본 모듈은 <a href="https://github.com/php-mcp/server" target="_blank">PHP MCP Server</a> 라이브러리를 기반으로 하며, Model Context Protocol(MCP)을 구현합니다.';
$lang->mcpserver_config_restart_notice = '설정 변경 후에는 반드시 서버를 재시작해야 적용됩니다.';
$lang->mcpserver_section_server_basic = '서버 기본 설정';
$lang->mcpserver_server_name = '서버명';
$lang->mcpserver_server_name_help = 'MCP(Model Context Protocol) 서버의 식별명입니다. 클라이언트에서 서버를 구분할 때 사용됩니다. (예: "My App Server", "Development Server")';
$lang->mcpserver_server_version = '서버 버전';
$lang->mcpserver_server_version_help = '서버 버전 정보입니다. Semantic Versioning 형식을 권장합니다. (예: "2.1.0", "1.5.3-beta")';
$lang->mcpserver_section_server_connection = '서버 연결 설정';
$lang->mcpserver_connection_warning = '본 설정 변경 후에는 설정 매뉴얼에 따라 모든 파라메터가 정상 세팅되어있는지 반드시 확인해주세요.';
$lang->mcpserver_server_host = '서버 호스트';
$lang->mcpserver_server_host_help = 'MCP 서버가 바인딩될 IP 주소입니다. (기본값: 127.0.0.1)';
$lang->mcpserver_server_port = '서버 포트';
$lang->mcpserver_server_port_help = 'HTTP Transport로 MCP 서버를 실행할 때 사용할 포트 번호입니다. 충돌하지 않는 임의의 포트로 설정해주세요.';
$lang->mcpserver_mcp_path = 'MCP 경로';
$lang->mcpserver_mcp_path_help = 'HTTP Transport에서 MCP 엔드포인트 경로입니다. 클라이언트가 접속할 URL 경로를 지정합니다. (예: "/mcp", "/api/mcp")';
$lang->mcpserver_section_mcp_options = 'MCP 옵션';
$lang->mcpserver_sse_enable = 'SSE 활성화';
$lang->mcpserver_enable = '활성화';
$lang->mcpserver_disable = '비활성화';
$lang->mcpserver_sse_help = 'SSE(Server-Sent Events) 기능을 활성화합니다. 만일 가벼운 작업만 진행하며, 응답이 빨라 비동기 기능이 필요없는 경우 비활성화할 수 있습니다. (기본값: 활성화)';
$lang->mcpserver_stateless_mode = 'Stateless 모드';
$lang->mcpserver_stateless_help = '세션 관리 없이 각 요청을 독립적으로 처리합니다. 캐시나 메모리 기반 세션을 사용하지 않을 때 활성화하세요. (성능 향상, 메모리 절약)';
$lang->mcpserver_cache_warning = 'MCP session은 캐시가 활성화되어있어야 작동합니다. 현재 라이믹스 캐시가 설정되어있지 않습니다. <a href="@url([\'module\'=>\'admin\',\'act\'=>\'dispAdminConfigAdvanced\'])" target="_blank">캐시를 활성화하거나</a> Stateless 모드를 활성화하세요.';
$lang->mcpserver_section_log = '로그 설정';
$lang->mcpserver_log_output = '로그 출력';
$lang->mcpserver_log_help = 'PSR-3 호환 로거를 통한 로그 출력을 활성화합니다. 개발 및 디버깅 시 유용하며, 프로덕션에서는 성능을 위해 비활성화할 수 있습니다.';
$lang->mcpserver_log_level = '로그 레벨';
$lang->mcpserver_log_level_help = 'PSR-3 로그 레벨별 출력 설정입니다. 상위 레벨일수록 중요한 로그입니다.';
$lang->mcpserver_log_emergency = 'Emergency (긴급)';
$lang->mcpserver_log_alert = 'Alert (경고)';
$lang->mcpserver_log_critical = 'Critical (심각)';
$lang->mcpserver_log_error = 'Error (오류)';
$lang->mcpserver_log_warning = 'Warning (경고)';
$lang->mcpserver_log_notice = 'Notice (알림)';
$lang->mcpserver_log_info = 'Info (정보)';
$lang->mcpserver_log_debug = 'Debug (디버그)';

// Header navigation
$lang->mcpserver_nav_server_config = '서버 설정';
$lang->mcpserver_nav_config_manual = '설정 매뉴얼';
$lang->mcpserver_nav_method_list = '메서드 목록';

// Config Manual page
$lang->mcpserver_script_setup_manual = '스크립트 설정 매뉴얼';
$lang->mcpserver_systemd_file_instruction = '파일에 아래와 같은 내용을 넣습니다.';
$lang->mcpserver_systemd_run_instruction = '아래의 명령을 실행하고, 정상 작동하는지 모니터링하십시오.';
$lang->mcpserver_systemd_status_instruction = '서비스 상태를 확인하려면 다음 명령을 사용하세요:';
$lang->mcpserver_systemd_log_instruction = '로그를 확인하려면 다음 명령을 사용하세요:';
$lang->mcpserver_test_server = '서버 실행여부 테스트';
$lang->mcpserver_test_confirm = '서버가 실행중인지 확인하시겠습니까?';
$lang->mcpserver_testing = '테스트 중...';
$lang->mcpserver_test_success = '로컬 연결 테스트가 성공적으로 완료되었습니다.';
$lang->mcpserver_test_failed = '로컬 연결 테스트에 실패했습니다: ';
$lang->mcpserver_server_setup_manual = '서버 설정 매뉴얼';
$lang->mcpserver_nginx_instruction = '서버 외부에서 MCP 서버에 접속할 수 있도록 하기 위해, <code>nginx</code> 설정 파일에 아래와 같은 내용을 추가합니다.';
$lang->mcpserver_nginx_reload_instruction = '아래의 명령을 실행하고, 정상 작동하는지 모니터링하십시오.';
$lang->mcpserver_external_access_check = '외부접속 가능여부 확인';
