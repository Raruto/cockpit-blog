<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
  <strong>{{ cockpit()->helper('i18n')->get('Request details:'); }}</strong>
  <dl>
    @foreach($data as $key => $value)
      <dt>{{{ $key }}}:</dt>
      <dd>
        @if(is_string($value))
          {{{ $value }}}
        @else
          @json($value)
        @endif
      </dd>
    @endforeach
  </dl>
</body>
</html>
