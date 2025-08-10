@include('header')

<div class="admin-content">
  <h2>MCP 메서드 목록</h2>
  
  @if(!empty($tools) || !empty($resources) || !empty($resourceTemplates) || !empty($prompts))
    
    @if(!empty($tools))
      <div class="method-section">
        <h3 class="section-title">도구 (Tools)</h3>
        <div class="method-list">
          @foreach($tools as $name => $info)
            <div class="method-item" onclick="toggleDetails('tool-{{ $loop->index }}')">
              <div class="method-header">
                <span class="method-name">{{ $name }}</span>
                <div>
                  <span class="method-type">Tool</span>
                  <span class="expand-icon">▼</span>
                </div>
              </div>
              @if(isset($info['tool']->description))
                <div class="method-description">{{ $info['tool']->description }}</div>
              @endif
              <div class="method-details">
                <span class="detail-item">핸들러: {{ is_string($info['handler']) ? $info['handler'] : (is_array($info['handler']) ? implode('::', $info['handler']) : 'Callable') }}</span>
                @if($info['isManual'])
                  <span class="detail-item manual">수동</span>
                @endif
              </div>
              <div class="method-details-extended" id="tool-{{ $loop->index }}" style="display: none;">
                <div class="detail-section">
                  <h4>상세 정보</h4>
                  <div class="detail-content">
                    <p><strong>이름:</strong> {{ $name }}</p>
                    @if(isset($info['tool']->description))
                      <p><strong>설명:</strong> {{ $info['tool']->description }}</p>
                    @endif
                    <p><strong>핸들러 타입:</strong> {{ is_string($info['handler']) ? '문자열' : (is_array($info['handler']) ? '배열' : '콜러블') }}</p>
                    <p><strong>수동 모드:</strong> {{ $info['isManual'] ? '예' : '아니오' }}</p>
                    @if(isset($info['tool']->inputSchema))
                      <p><strong>입력 스키마:</strong></p>
                      <pre class="json-display">{!! json_encode($info['tool']->inputSchema, JSON_PRETTY_PRINT) !!}</pre>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif

    @if(!empty($resources))
      <div class="method-section">
        <h3 class="section-title">리소스 (Resources)</h3>
        <div class="method-list">
          @foreach($resources as $name => $info)
            <div class="method-item" onclick="toggleDetails('resource-{{ $loop->index }}')">
              <div class="method-header">
                <span class="method-name">{{ $name }}</span>
                <div>
                  <span class="method-type">Resource</span>
                  <span class="expand-icon">▼</span>
                </div>
              </div>
              @if(isset($info['resource']->description))
                <div class="method-description">{{ $info['resource']->description }}</div>
              @endif
              <div class="method-details">
                <span class="detail-item">핸들러: {{ is_string($info['handler']) ? $info['handler'] : (is_array($info['handler']) ? implode('::', $info['handler']) : 'Callable') }}</span>
                @if($info['isManual'])
                  <span class="detail-item manual">수동</span>
                @endif
              </div>
              <div class="method-details-extended" id="resource-{{ $loop->index }}" style="display: none;">
                <div class="detail-section">
                  <h4>상세 정보</h4>
                  <div class="detail-content">
                    <p><strong>이름:</strong> {{ $name }}</p>
                    @if(isset($info['resource']->description))
                      <p><strong>설명:</strong> {{ $info['resource']->description }}</p>
                    @endif
                    @if(isset($info['resource']->uri))
                      <p><strong>URI:</strong> {{ $info['resource']->uri }}</p>
                    @endif
                    @if(isset($info['resource']->mimeType))
                      <p><strong>MIME 타입:</strong> {{ $info['resource']->mimeType }}</p>
                    @endif
                    <p><strong>핸들러 타입:</strong> {{ is_string($info['handler']) ? '문자열' : (is_array($info['handler']) ? '배열' : '콜러블') }}</p>
                    <p><strong>수동 모드:</strong> {{ $info['isManual'] ? '예' : '아니오' }}</p>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif

    @if(!empty($resourceTemplates))
      <div class="method-section">
        <h3 class="section-title">리소스 템플릿 (Resource Templates)</h3>
        <div class="method-list">
          @foreach($resourceTemplates as $name => $info)
            <div class="method-item" onclick="toggleDetails('template-{{ $loop->index }}')">
              <div class="method-header">
                <span class="method-name">{{ $name }}</span>
                <div>
                  <span class="method-type">Template</span>
                  <span class="expand-icon">▼</span>
                </div>
              </div>
              @if(isset($info['template']->description))
                <div class="method-description">{{ $info['template']->description }}</div>
              @endif
              <div class="method-details">
                <span class="detail-item">핸들러: {{ is_string($info['handler']) ? $info['handler'] : (is_array($info['handler']) ? implode('::', $info['handler']) : 'Callable') }}</span>
                @if(!empty($info['completionProviders']))
                  <span class="detail-item">완성 제공자: {{ count($info['completionProviders']) }}개</span>
                @endif
                @if($info['isManual'])
                  <span class="detail-item manual">수동</span>
                @endif
              </div>
              <div class="method-details-extended" id="template-{{ $loop->index }}" style="display: none;">
                <div class="detail-section">
                  <h4>상세 정보</h4>
                  <div class="detail-content">
                    <p><strong>이름:</strong> {{ $name }}</p>
                    @if(isset($info['template']->description))
                      <p><strong>설명:</strong> {{ $info['template']->description }}</p>
                    @endif
                    @if(isset($info['template']->uriTemplate))
                      <p><strong>URI 템플릿:</strong> {{ $info['template']->uriTemplate }}</p>
                    @endif
                    @if(isset($info['template']->mimeType))
                      <p><strong>MIME 타입:</strong> {{ $info['template']->mimeType }}</p>
                    @endif
                    <p><strong>핸들러 타입:</strong> {{ is_string($info['handler']) ? '문자열' : (is_array($info['handler']) ? '배열' : '콜러블') }}</p>
                    <p><strong>완성 제공자:</strong> {{ count($info['completionProviders']) }}개</p>
                    <p><strong>수동 모드:</strong> {{ $info['isManual'] ? '예' : '아니오' }}</p>
                    @if(!empty($info['completionProviders']))
                      <p><strong>완성 제공자 목록:</strong></p>
                      <ul class="completion-providers">
                        @foreach($info['completionProviders'] as $provider)
                          <li>{{ is_string($provider) ? $provider : (is_array($provider) ? implode('::', $provider) : 'Callable') }}</li>
                        @endforeach
                      </ul>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif

    @if(!empty($prompts))
      <div class="method-section">
        <h3 class="section-title">프롬프트 (Prompts)</h3>
        <div class="method-list">
          @foreach($prompts as $name => $info)
            <div class="method-item" onclick="toggleDetails('prompt-{{ $loop->index }}')">
              <div class="method-header">
                <span class="method-name">{{ $name }}</span>
                <div>
                  <span class="method-type">Prompt</span>
                  <span class="expand-icon">▼</span>
                </div>
              </div>
              @if(isset($info['prompt']->description))
                <div class="method-description">{{ $info['prompt']->description }}</div>
              @endif
              <div class="method-details">
                <span class="detail-item">핸들러: {{ is_string($info['handler']) ? $info['handler'] : (is_array($info['handler']) ? implode('::', $info['handler']) : 'Callable') }}</span>
                @if(!empty($info['completionProviders']))
                  <span class="detail-item">완성 제공자: {{ count($info['completionProviders']) }}개</span>
                @endif
                @if($info['isManual'])
                  <span class="detail-item manual">수동</span>
                @endif
              </div>
              <div class="method-details-extended" id="prompt-{{ $loop->index }}" style="display: none;">
                <div class="detail-section">
                  <h4>상세 정보</h4>
                  <div class="detail-content">
                    <p><strong>이름:</strong> {{ $name }}</p>
                    @if(isset($info['prompt']->description))
                      <p><strong>설명:</strong> {{ $info['prompt']->description }}</p>
                    @endif
                    @if(isset($info['prompt']->arguments))
                      <p><strong>인수:</strong></p>
                      <pre class="json-display">{!! json_encode($info['prompt']->arguments, JSON_PRETTY_PRINT) !!}</pre>
                    @endif
                    <p><strong>핸들러 타입:</strong> {{ is_string($info['handler']) ? '문자열' : (is_array($info['handler']) ? '배열' : '콜러블') }}</p>
                    <p><strong>완성 제공자:</strong> {{ count($info['completionProviders']) }}개</p>
                    <p><strong>수동 모드:</strong> {{ $info['isManual'] ? '예' : '아니오' }}</p>
                    @if(!empty($info['completionProviders']))
                      <p><strong>완성 제공자 목록:</strong></p>
                      <ul class="completion-providers">
                        @foreach($info['completionProviders'] as $provider)
                          <li>{{ is_string($provider) ? $provider : (is_array($provider) ? implode('::', $provider) : 'Callable') }}</li>
                        @endforeach
                      </ul>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif

  @else
    <div class="no-methods">
      <p>등록된 MCP 메서드가 없습니다.</p>
    </div>
  @endif
</div>

<style>
.admin-content {
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.admin-content h2 {
  color: #333;
  border-bottom: 2px solid #007cba;
  padding-bottom: 10px;
  margin-bottom: 10px;
}

.method-section {
  margin-bottom: 40px;
}

.section-title {
  color: #555;
  font-size: 1.3em;
  margin-bottom: 15px;
  padding: 10px 0;
  border-bottom: 1px solid #ddd;
}

.method-list {
  display: grid;
  gap: 15px;
}

.method-item {
  background: #f9f9f9;
  border: 1px solid #e1e1e1;
  border-radius: 8px;
  padding: 15px;
  transition: all 0.2s ease;
  cursor: pointer;
}

.method-item:hover {
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  transform: translateY(-1px);
}

.method-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 8px;
}

.expand-icon {
  margin-left: 8px;
  transition: transform 0.2s ease;
  font-size: 0.8em;
}

.method-item.expanded .expand-icon {
  transform: rotate(180deg);
}

.method-name {
  font-weight: 600;
  font-size: 1.1em;
  color: #333;
}

.method-type {
  background: #007cba;
  color: white;
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 0.8em;
  font-weight: 500;
}

.method-description {
  color: #666;
  margin-bottom: 10px;
  font-style: italic;
}

.method-details {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  margin-top: 10px;
}

.detail-item {
  background: #e8f4f8;
  padding: 3px 8px;
  border-radius: 4px;
  font-size: 0.85em;
  color: #555;
}

.detail-item.manual {
  background: #fff3cd;
  color: #856404;
  font-weight: 500;
}

.no-methods {
  text-align: center;
  padding: 60px 20px;
  color: #666;
  background: #f5f5f5;
  border-radius: 8px;
}

.no-methods p {
  font-size: 1.1em;
  margin: 0;
}

.method-details-extended {
  margin-top: 15px;
  padding-top: 15px;
  border-top: 1px solid #ddd;
  animation: slideDown 0.3s ease;
}

.detail-section h4 {
  color: #555;
  margin-bottom: 10px;
  font-size: 1em;
}

.detail-content p {
  margin: 8px 0;
  color: #666;
}

.json-display {
  background: #f5f5f5;
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 10px;
  font-size: 0.85em;
  overflow-x: auto;
  color: #333;
  white-space: pre-wrap;
}

.completion-providers {
  margin: 8px 0 0 20px;
  color: #666;
}

.completion-providers li {
  margin: 4px 0;
  font-size: 0.9em;
}

@keyframes slideDown {
  from {
    opacity: 0;
    max-height: 0;
  }
  to {
    opacity: 1;
    max-height: 500px;
  }
}

@media (max-width: 768px) {
  .method-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 5px;
  }
  
  .method-details {
    flex-direction: column;
  }
  
  .detail-item {
    display: inline-block;
  }
}
</style>

<script>
function toggleDetails(elementId) {
  const element = document.getElementById(elementId);
  const methodItem = element.closest('.method-item');
  const expandIcon = methodItem.querySelector('.expand-icon');
  
  if (element.style.display === 'none' || element.style.display === '') {
    element.style.display = 'block';
    methodItem.classList.add('expanded');
  } else {
    element.style.display = 'none';
    methodItem.classList.remove('expanded');
  }
}
</script>