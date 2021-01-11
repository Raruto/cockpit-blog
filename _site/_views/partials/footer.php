<footer>
  <nav class="text-center">
    <ul>
      <li><a href="@base('/')">@lang('Blog')</a></li>
      <li><a href="@base('/privacy-policy/')">@lang('Privacy')</a></li>
      <li><a href="@base('/cookie-policy/')">@lang('Cookie')</a></li>
      <li><a href="@base('/sitemap.xml')">@lang('Sitemap')</a></li>
      <li><a href="@base('/manifest.json')">@lang('Manifest')</a></li>
      <li><a href="@base('/feed/feed.xml')">@lang('RSS Feed')</a></li>
      <li><a href="@base('/feed/feed.json')">@lang('JSON')</a></li>
      <li><a href="@base('/login/')">@lang('Login')</a></li>
    </ul>
  </nav>
  <div class="text-center">
    <p><sub>@lang('Made with') <a href="https://getcockpit.com/" target="_blank">cockpit</a></sub></p>
    <img class="d-block m-auto" src="@url('assets:app/media/logo-plain.svg')" alt="logo" width="35" />
  </div>
</footer>

<script src="@base('site:js/app.js')"></script>
