# MCP Server for Rhymix

## 개요

**MCP Server**는 라이믹스(Rhymix) CMS에 적용할 수 있는 Model Context Protocol (MCP) 서버 모듈입니다. 이 모듈을 통해 AI 클라이언트가 라이믹스의 데이터와 기능에 접근할 수 있는 표준화된 인터페이스를 제공합니다.  

이 모듈은 [php-mcp/server](https://github.com/php-mcp/server)를 라이믹스에서 사용할 수 있도록 포팅한 프로그램입니다.  
MCP 툴, 프롬프트, 플러그인 개발은 위 레포지토리를 참고하여 개발해야합니다.

> [!IMPORTANT]
> 본 모듈은 설치과정에서 서버 및 라이믹스에 대한 고도의 지식을 요구합니다.  
> 서버의 설정을 변경할 때는 반드시 자신이 무슨 작업을 하는지 인지하고 진행해야합니다.

## Model Context Protocol (MCP)란?

MCP는 AI 어시스턴트가 외부 도구와 데이터 소스에 안전하게 연결할 수 있도록 설계된 개방형 표준 프로토콜입니다. 이를 통해 AI 클라이언트는 다양한 애플리케이션과 서비스의 기능을 활용할 수 있습니다.

## 주요 기능

- ✨ **표준화된 MCP 프로토콜** 지원
- 🔧 **확장 가능한 툴 시스템** - 사용자가 직접 MCP 툴을 개발할 수 있음
- 🔍 **자동 디렉토리 스캔** - 별도의 모듈에서 MCP 플러그인을 사용할 수 있도록 자동 스캔

## 설치 요구사항

- PHP 8.1 이상
- Rhymix 2.1 이상
- Linux Shell 작업이 가능해야 함

## 설치 방법

1. 모듈을 라이믹스의 `modules/mcpserver` 디렉토리에 복사합니다.
2. **고급** > **설치된 모듈** > **MCP Server** 에서 설정을 구성합니다.

## 설정 옵션

### 서버 설정
- **서버 이름**: MCP 서버의 식별명
- **서버 버전**: 버전 정보
- **호스트**: 서버가 바인딩될 IP 주소 (기본: 127.0.0.1)
- **포트**: 서버가 사용할 포트 (기본: 8080)
- **MCP 경로**: MCP 엔드포인트 경로 (기본: /mcp)

### 통신 설정
- **SSE 활성화**: Server-Sent Events 사용 여부
- **Stateless 모드**: 무상태 모드 활성화 여부

### 로깅 설정
- **로그 출력**: 콘솔 로그 출력 활성화
- **로그 레벨**: 출력할 로그 레벨 선택 (DEBUG, INFO, WARNING, ERROR 등)

## MCP 서버 실행

본 모듈은 라이믹스와 별도로 서버를 실행해야합니다.  
**모듈 > 설정 매뉴얼**을 참고하여 스크립트를 실행하고, nginx와 같은 서버 프로그램의 리버스 프록시 설정 변경이 필요합니다.

## 사용자 정의 MCP 툴 개발

### 기본 구조

사용자 정의 MCP 툴은 `modules/(임의의 모듈)/mcp/` 디렉토리에 생성합니다. 모든 MCP 툴 클래스는 `\Rhymix\Modules\Mcpserver\Models\MCPServerInterface`를 상속받아야 합니다.

### 예제: 계산기 툴 (ExampleCalculatorElements.php)

```php
<?php

namespace Rhymix\Modules\Mcpserver\Mcp;

use Rhymix\Modules\Mcpserver\Models\MCPServerInterface;
use PhpMcp\Server\Attributes\McpTool;
use PhpMcp\Server\Attributes\Schema;

/**
 * 계산기 기능을 제공하는 MCP 툴 예제
 */
class ExampleCalculatorElements extends MCPServerInterface
{
    /**
     * 두 수를 더합니다.
     * 
     * @param int $a 첫 번째 숫자
     * @param int $b 두 번째 숫자  
     * @return int 두 숫자의 합
     */
    #[McpTool(name: 'add_numbers')]
    public function add(int $a, int $b): int
    {
        return $a + $b;
    }

    /**
     * 거듭제곱을 계산합니다 (유효성 검사 포함).
     */
    #[McpTool(name: 'calculate_power')]
    public function power(
        #[Schema(type: 'number', minimum: 0, maximum: 1000)]
        float $base,
        
        #[Schema(type: 'integer', minimum: 0, maximum: 10)]
        int $exponent
    ): float {
        return pow($base, $exponent);
    }
}
```

### 새로운 MCP 툴 클래스 생성하기

1. **파일 생성**: `modules/example/mcp/` 디렉토리에 새 PHP 파일(YourCustomTool.php)을 생성합니다.

2. **기본 클래스 구조**:
```php
<?php

namespace Rhymix\Modules\Example\Mcp;

use Rhymix\Modules\Mcpserver\Models\MCPServerInterface;
use PhpMcp\Server\Attributes\McpTool;
use PhpMcp\Server\Attributes\Schema;

/**
 * 사용자 정의 MCP 툴
 */
class YourCustomTool extends MCPServerInterface
{
    /**
     * 툴 메서드 예제
     */
    #[McpTool(name: 'your_tool_name')]
    public function yourMethod($param1, $param2)
    {
        // 여기에 비즈니스 로직 구현
        return "결과";
    }
}
```

### 라이믹스 데이터베이스 접근 예제

```php
<?php

namespace Rhymix\Modules\Example\Mcp;

use Rhymix\Modules\Mcpserver\Models\MCPServerInterface;
use PhpMcp\Server\Attributes\McpTool;

class RhymixDatabaseTool extends MCPServerInterface
{
    /**
     * 회원 정보를 조회합니다.
     */
    #[McpTool(name: 'get_member_info')]
    public function getMemberInfo(int $member_srl): array
    {
        // 라이믹스 데이터베이스 쿼리 실행
        $output = executeQuery('member.getMemberInfoByMemberSrl', ['member_srl' => $member_srl]);
        
        if (!$output->toBool()) {
            throw new \Exception('회원 정보를 가져올 수 없습니다: ' . $output->getMessage());
        }
        
        $member = $output->data;
        return [
            'member_srl' => $member->member_srl,
            'user_id' => $member->user_id,
            'nick_name' => $member->nick_name,
            'email_address' => $member->email_address
        ];
    }

    /**
     * 게시물 목록을 조회합니다.
     */
    #[McpTool(name: 'get_document_list')]
    public function getDocumentList(int $module_srl, int $page = 1): array
    {
        $args = new \stdClass();
        $args->module_srl = $module_srl;
        $args->page = $page;
        $args->list_count = 10;
        
        $output = executeQueryArray('document.getDocumentList', $args);
        
        if (!$output->toBool()) {
            throw new \Exception('게시물 목록을 가져올 수 없습니다: ' . $output->getMessage());
        }
        
        return [
            'total_count' => $output->total_count,
            'documents' => $output->data
        ];
    }
}
```

### 스키마 유효성 검사

MCP 툴에서는 `Schema` 어트리뷰트를 사용하여 입력 매개변수에 대한 유효성 검사를 설정할 수 있습니다:

```php
#[McpTool(name: 'validated_tool')]
public function validatedMethod(
    #[Schema(type: 'string', minLength: 1, maxLength: 100)]
    string $text,
    
    #[Schema(type: 'integer', minimum: 1, maximum: 999)]
    int $number,
    
    #[Schema(type: 'number', minimum: 0.0, maximum: 100.0)]
    float $percentage
): array {
    return [
        'text' => $text,
        'number' => $number,
        'percentage' => $percentage
    ];
}
```

이외의 더 많은 정보를 원한다면 [php-mcp/server](https://github.com/php-mcp/server)를 참고해주세요.

## 디버깅

### 로그 확인
MCP 서버는 설정에 따라 상세한 로그를 출력합니다. 로그를 통해 다음 정보를 확인할 수 있습니다:
- 클라이언트 연결/해제
- 툴 호출 및 응답
- 오류 및 예외 정보

### 연결 테스트
관리자 페이지에서 "로컬 연결 테스트" 기능을 사용하여 MCP 서버가 정상적으로 작동하는지 확인할 수 있습니다.

## 주의사항

- MCP 서버는 보안이 중요한 환경에서는 적절한 방화벽 설정과 함께 사용하세요.
- 프로덕션 환경에서는 DEBUG 로그 레벨을 비활성화하는 것을 권장합니다.
- 사용자 정의 툴에서 데이터베이스 작업 시 적절한 권한 검사를 수행하세요.

## 라이선스

이 모듈은 GPL v2 라이선스 하에 배포됩니다.

## 개발자

- **Waterticket** (waterticket@potatosoft.kr)
- 웹사이트: https://potatosoft.kr
- 모듈 생성기: https://www.poesis.dev/

## 기술 지원

문제가 발생하거나 도움이 필요한 경우:
1. [라이믹스 공식 커뮤니티](https://rhymix.org/qna)에서 질문
2. GitHub 이슈 등록 (해당하는 경우)