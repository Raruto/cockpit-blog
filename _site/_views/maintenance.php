<!DOCTYPE html>
<html lang="{{ $app('i18n')->locale }}" class="no-js">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>@lang('Maintenance')</title>
    <style>
      html {
        background: #f1f1f1;
      }
      body {
        background: #fff;
        color: #444;
        font-family: "Segoe UI", "Roboto", "Helvetica Neue", sans-serif;
        margin: 2em auto;
        padding: 1em 2em;
        max-width: 700px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.13);
      }
      div {
        margin-top: 50px;
        font-size: 14px;
        line-height: 1.5;
        margin: 25px 0 20px;
        font-weight: 400;
      }
    </style>
  </head>
  <body>
    <div>@lang('Briefly unavailable for scheduled maintenance. Check back in a minute.')</div>
    <script>
    (function maintenance_check(){
      var request = new XMLHttpRequest();
      request.open( 'HEAD', window.location, true );
      request.onload = function() {
        if (this.status >= 200 && this.status < 400) {
          window.location.reload();                 // Maintenance mode ended. Reload page.
        } else {
          var millis = this.getResponseHeader("Retry-After");
          millis = isNaN(millis) ? Date.parse(millis) : millis;
          millis = isNaN(millis) ? 3000 : millis
          setTimeout( maintenance_check, millis ); // Still in maintenance mode. Try again after time delay.
        }
      };
      request.onerror = function() {
        setTimeout( maintenance_check, 3000 );     // There was some connection error. Try again in 3 seconds.
      };
      request.send();
    })();
  </script>
  </body>
</html>
