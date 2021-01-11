<!DOCTYPE html>
<html lang="{{ $app('i18n')->locale }}" class="no-js">
  <head>
    @trigger('site.meta')
    @render('partials:head.php')
  </head>
  <body>
    @trigger('site.header.scripts')

    @trigger('site.header')
    @render('partials:header.php')

    @trigger('site.contentbefore')
    {{ $content_for_layout }}
    @trigger('site.contentafter')

    @trigger('site.aside')
    @render('partials:aside.php')

    @trigger('site.footer')
    @render('partials:footer.php')

    @trigger('site.footer.scripts')
  </body>
</html>
