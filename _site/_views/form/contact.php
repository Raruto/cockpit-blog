@extend('layouts:base.php')

@form( 'contact', [ 'id' => 'contact-form', 'class'=>'contact-form' ] )
  <fieldset>
    <legend>@lang('Contact us'):</legend>
    <div>
      <label for="name">
        @lang('Name') <span title="@lang('required')">*</span>
      </label>
      <input type="text" name="form[name]" id="name" placeholder="" onblur="this.value= this.value.toLowerCase().replace(/\b\w/g, function(l){ return l.toUpperCase() })" required>
    </div>
    <div>
      <label for="email">
        @lang('E-mail') <span title="@lang('required')">*</span>
      </label>
      <input type="email" name="form[email]" id="email" placeholder="" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$" onblur="this.value = this.value.toLowerCase()" required>
    </div>
    <div>
      <label for="phone">
        @lang('Phone')
      </label>
      <input type="tel" name="form[phone]" id="phone" placeholder="" pattern="[+]{0,1}[0-9]{9,}">
    </div>
    <div>
      <label for="message">
        @lang('Message') <span title="@lang('required')">*</span>
      </label>
      <textarea name="form[message]" id="message" placeholder="" rows="5" required></textarea>
    </div>
    <div>
      <label for="files">
        @lang('File')
      </label>
      <input type="hidden" name="MAX_FILE_SIZE" value="100000">
      <input name="files[]" type="file">
    </div>
    <p>
      <input type="checkbox" name="form[privacy]" id="privacy" required>
      <label for="privacy">
        {{ $app("i18n")->getstr('I accept the <a href="%s">privacy policy</a> and I give consent to processing of this data as established by the <a href="%s">GDPR</a>', [ $app['base_route'] . '/privacy-policy/', 'https://gdpr.eu/' ] ); }} <span title="required">*</span>
      </label>
    </p>
    <div>
      <input name="submit" type="submit" value="@lang('Submit')">
    </div>
    <p class="form-message-success" style="display: none;">
      @lang('Thank You! I\'ll get back to you real soon...')
    </p>
  </fieldset>
@endform
