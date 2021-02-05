@extend('layouts:base.php')

@if(!empty($page['image']))
<img loading="eager" src="@base('#uploads:'. $page['image']['path'])" alt="{{{ !empty($page['image']['description']) ? $page['image']['description'] : $page['image']['title'] }}}" width="{{ $page['image']['width'] }}" height="{{ $page['image']['height'] }}" />
@endif
@if(!empty($page['show_title']))
<h1>{{ $page['title'] }}</h1>
@endif
<hr>
<span class="tags">
  @if(!empty($page['tags']))
    @foreach($page['tags'] as $tag)
      <a href="@base( ($tag['parent'] ?? '/tag/') . urlencode($tag))" rel="tag" class="tag {{{ str_replace(".", "", $tag) }}}">{{ $tag }}</a>
    @endforeach
  @endif
</span>
<time class="time" datetime="{{{ date('Y-m-d H:i', $page['_created']) }}}">
  <small>{{ date($app('i18n')->get('@dateformat_long', 'Y-m-d H:i'), $page['_created']) }}</small>
</time>
<br>
<article>{{ $page['content'] }}</article>
