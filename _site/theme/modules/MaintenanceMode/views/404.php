@extend('layouts:base.php')

<h1>@lang('Not found')</h1>
<p>{{ $app("i18n")->getstr("The requested URL %s was not found on this server.", [ $app['base_route'] . $app['route'] ]) }}</p>
