@extend('layouts:base.php')

@if(!empty($post['image']))
<img loading="eager" src="@base('#uploads:'. $post['image']['path'])" alt="{{{ !empty($post['image']['description']) ? $post['image']['description'] : $post['image']['title'] }}}" width="{{ $post['image']['width'] }}" height="{{ $post['image']['height'] }}" />
@endif
<h1>{{ $post['title'] }}</h1>
<hr>
<span class="tags">
  @if(!empty($post['tags']))
    @foreach($post['tags'] as $tag)
      <a href="@base( ($tag['parent'] ?? '/tag/') . urlencode($tag))" rel="tag" class="tag {{{ str_replace(".", "", $tag) }}}">{{ $tag }}</a>
    @endforeach
  @endif
</span>
<time class="time" datetime="{{{ date('Y-m-d H:i', $post['_created']) }}}">
  <small>{{ date($app('i18n')->get('@dateformat_long', 'Y-m-d H:i'), $post['_created']) }}</small>
</time>
<br>
<article>{{ $post['content'] }}</article>
