window.setTimeout(function() {
  App.$('.app-modulesbar').append(App.$('<li><cp-quickactions /></li>').addClass('quickactions'));
  riot.mount('cp-quickactions', { actions: [
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
  ] });
}, 500);
