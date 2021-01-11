<cp-quickactions>
  <div data-uk-dropdown>
    <a class="uk-text-muted"><i class="uk-icon-ellipsis-h"></i></a>
    <div class="uk-dropdown">
      <ul class="uk-nav uk-nav-dropdown uk-dropdown-close" each="{group in actions}">
        <!-- <li class="uk-nav-header">{ group.group }</li> -->
        <li each="{ action in group.actions }">
          <a href="{ action.path }">{ action.label }</a>
        </li>
      </ul>
    </div>
  </div>

  <script>
    this.actions = [
      {
        "group": "",
        "actions": [
          {
            "path": App.route('/accounts'),
            "label": App.i18n.get('Users')
          },
          {
            "path": App.route('/settings'),
            "label": App.i18n.get('Settings')
          },
          {
            "path": App.route('/assetsmanager'),
            "label": App.i18n.get('Assets')
          }
        ]
      }
    ];

    this.on('mount', function(data) {
      this.actions = this.opts.actions || this.actions;
      this.update();
    });

  </script>

</cp-quickactions>
