{{-- Required Meta tags --}}
<meta charset="{{{ $app['charset'] }}}">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

{{-- Primary Meta tags --}}
<title>{{ (!empty( $page['title'] ) ? $page['title'] . ' | ' : '') . $app['app.name'] }}</title>
<meta name="title" content="{{{ (!empty( $page['title'] ) ? $page['title'] . ' | ' : '') . $app['app.name'] }}}">
<meta name="description" content="{{{ !empty($page['excerpt']) ? $page['excerpt'] : $app['app.description'] }}}">
<meta name="robots" content="{{{ !empty($page['meta.robots']) ? $page['meta.robots'] : $app['meta.robots'] }}}">
@if($app['debug'])
<meta name="generator" content="{{{ $app['meta.generator'] }}}">
@endif

{{-- Optional SEO tags --}}
@if(!empty($page['keyword']))
<meta name="keywords" content="{{{ $page['keyword'] }}}">
@endif
@if(!empty($page['author']))
<meta name="author" content="{{{ $page['author'] }}}">
@endif

{{-- DNS Prefetch --}}
<link rel="preconnect" href="@base('/')" crossorigin>

{{-- Canonical URL --}}
<link rel="canonical" href="{{{ $app['site_url'] . $app['base_route'] . $app['route'] }}}">

{{-- CSS Styles --}}
<link rel="stylesheet" href="@base('site:css/app.css')">
<!--[if IE]><script src="https://cdn.polyfill.io/v2/polyfill.js"></script><![endif]-->
<noscript><link rel="stylesheet" href="@base('site:css/noscript.css')"></noscript>

{{-- Favicon --}}
<meta name="theme-color" content="#ffffff">
<link rel="icon" href="@base('/favicon.svg')">
<link rel="mask-icon" href="@base('/media/app/mask-icon.svg')" color="#ffffff">
<link rel="apple-touch-icon" href="@base('/media/app/apple-touch-icon.png')">
<link rel="manifest" href="@base('/manifest.json')">
