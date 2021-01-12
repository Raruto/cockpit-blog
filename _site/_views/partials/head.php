{{-- Required Meta tags --}}
<meta charset="{{{ $app['charset'] }}}">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

{{-- Primary Meta tags --}}
<title>{{ (!empty( $page['title'] ) ? $page['title'] . ' | ' : '') . $app['app.name'] }}</title>
<meta name="title" content="{{{ (!empty( $page['title'] ) ? $page['title'] . ' | ' : '') . $app['app.name'] }}}">
<meta name="description" content="{{{ strip_tags( !empty($page['excerpt']) ? $page['excerpt'] : $app['app.description'] ) }}}">
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

{{-- Feed RSS / JSON --}}
<link rel="alternate" type="application/rss+xml" title="{{{ $app['app.name'] }}} &raquo; RSS Feed" href="@base('/feed/feed.xml')" />
<link rel="alternate" type="application/feed+json" title="{{{ $app['app.name'] }}} &raquo; JSON Feed" href="@base('/feed/feed.json')" />

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

{{-- Open Graph --}}
<meta property="og:locale" content="{{{ $app->helper('i18n')->locale }}}">
<meta property="og:type" content="website">
<meta property="og:title" content="{{{ (!empty( $page['title'] ) ? $page['title'] . ' | ' : '') . $app['app.name'] }}}">
<meta property="og:description" content="{{{ strip_tags( !empty($page['excerpt']) ? $page['excerpt'] : $app['app.description'] ) }}}">
<meta property="og:url" content="{{{ $app['site_url'] . $app['base_route'] . $app['route'] }}}">
<meta property="og:site_name" content="{{{ $app['app.name'] }}}">
@if(!empty($page['image']) || !empty($post['image']))
<meta property="og:image" content="@base('#uploads:'. ($page['image'] ?? $post['image'])['path'])">
<meta property="og:image:secure_url" content="@base('#uploads:'. ($page['image'] ?? $post['image'])['path'])">
@endif

{{-- Twitter Cards --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{{ (!empty( $page['title'] ) ? $page['title'] . ' | ' : '') . $app['app.name'] }}}">
<meta name="twitter:description" content="{{{ strip_tags( !empty($page['excerpt']) ? $page['excerpt'] : $app['app.description'] ) }}}">
@if( !empty( $app['author']['name'] ) )
<meta name="twitter:site" content="{{{ $app['author']['name'] }}}">
<meta name="twitter:creator" content="{{{ $app['author']['name'] }}}">
@endif
<meta name="twitter:url" content="{{{ $app['site_url'] . $app['base_route'] . $app['route'] }}}">
@if(!empty($page['image']) || !empty($post['image']))
<meta name="twitter:image:src" content="@base('#uploads:'. ($page['image'] ?? $post['image'])['path'])">
@endif

{{-- Schema.org --}}
{% $schema = [
  "@context"    => "https://schema.org",
  "@type"       => "WebSite",
  "@id"         => $app['site_url'] . $app['base_route'] . "#website",
  "url"         => $app['site_url'] . $app['base_route'],
  "name"        => $app['app.name'],
  "description" => $app['app.description']
]; %}
<script type="application/ld+json">@json($schema, JSON_UNESCAPED_SLASHES)</script>
