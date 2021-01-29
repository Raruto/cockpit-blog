<fieldset class="d-none">
  <legend>@lang('Before you begin')</legend>
  <div>
    <label for="{{ $app->module('honeypot')->getHoneypotFieldName($name) }}">@lang('Please read this text carefully and avoid:')</label>
    <input name="form[{{ $app->module('honeypot')->getHoneypotFieldName($name) }}]" type="text" value="" tabindex="-1" autocomplete="nope" placeholder="@lang('filling in this field')">
  </div>
</fieldset>
