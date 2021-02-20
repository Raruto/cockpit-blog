@extend('layouts:base.php')

@if(!empty($page['image']))
<img loading="eager" src="@base('#uploads:'. $page['image']['path'])" alt="{{{ !empty($page['image']['description']) ? $page['image']['description'] : $page['image']['title'] }}}" width="{{{ $page['image']['width'] }}}" height="{{{ $page['image']['height'] }}}" />
@endif
@if(!empty($page['show_title']))
<h1>{{ $page['title'] }}</h1>
@endif
<section>{{ $page['content'] }}</section>
