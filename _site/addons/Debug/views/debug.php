@if($app['debug.info'])
  <hr>
  <h5>DEBUG INFO:</h5>
  {{-- App --}}
  @if($app['debug'])
    <details>
      <summary>App</summary>
      <pre>
        <code>@dump($app)</code>
      </pre>
    </details>
  @endif
  {{-- Cockpit --}}
  @if(cockpit()['debug'])
    <details>
      <summary>Cockpit</summary>
      <pre>
        <code>@dump(cockpit())</code>
      </pre>
    </details>
  @endif
  {{-- Page --}}
  @if(!empty($app->viewvars['page']) && $app['debug'])
    <details>
      <summary>Page</summary>
      <pre>
        <code>@dump($app->viewvars['page'])</code>
      </pre>
    </details>
  @endif
  {{-- Collection --}}
  @if(!empty($app->viewvars['collection']) && $app['debug'])
    <details>
      <summary>Collection</summary>
      <pre>
        <code>@dump($app->viewvars['collection'])</code>
      </pre>
    </details>
  @endif
  {{-- Query --}}
  @if(!empty($app->viewvars['query']) && $app['debug'])
    <details>
      <summary>Query</summary>
      <pre>
        <code>@dump($app->viewvars['query'])</code>
      </pre>
    </details>
  @endif
@endif
