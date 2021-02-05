@extend('layouts:base.php')

{% $collection = $page['collection']; %}
{% $query      = $page['query']; %}

{% $items = cockpit('collections')->find($collection, $query); %}
{% $total = cockpit('collections')->count($collection, $query['filter']); %}

@foreach($items as $item)
<article>
  <h2><a href="@base( ($collection['base_route'] ?? '/article/') . $item['slug'] )">{{ $item['title'] }}</a></h2>
  <p class="excerpt">{{ $item['excerpt'] }}</p>
  <span class="tags">
    @if(!empty($item['tags']))
      @foreach($item['tags'] as $tag)
        <a href="@base( ($collection['tags_route'] ?? '/tag/') . urlencode($tag))" rel="tag" class="tag {{{ str_replace(".", "", $tag) }}}">{{ $tag }}</a>
      @endforeach
    @endif
  </span>
  <time class="time" datetime="{{{ date('Y-m-d H:i', $item['_created']) }}}">
    <small>{{ date($app('i18n')->get('@dateformat_long', 'Y-m-d H:i'), $item['_created']) }}</small>
  </time>
</article>
@endforeach

@render('partials:pagination.php', [ 'pagination' => [ 'page_num' => $query['skip'] + 1, 'num_rows' => $total, 'per_page' => $query['limit'], 'page_slug' => $page['base_route'] ] ])
