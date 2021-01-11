<div id="live-preview"></div>
<script>
  function livePreview(event) {
    // console.log(event.data.entry);
    App.request("{{$app['site_url'] . $app['base_route'] . '/getPreview' }}", event.data, 'html')
    .then(function(data) {
      document.getElementById('live-preview').innerHTML = data;
    });
  }
  /**
   * @see { cockpit/modules/Collections/assets/collection-entrypreview.tag }
   *
   * var data = {
   *     'event': 'cockpit:collections.preview',
   *     'collection': this.collection.name,
   *     'entry': this.entry,
   *     'lang': this.lang || 'default'
   * };
   *
   */
  window.addEventListener('message', function(event) {
    // set a timeout to prevent massive requests while typing
    setTimeout(function() {livePreview(event);}, 3000);
  }, false);
</script>
