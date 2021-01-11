<?php
/**
 * Cockpit autosave editor addon
 *
 * @author     Paulo Gomes (2019), Raruto (2021)
 * @package    cockpit-blog
 * @subpackage CockpitCMS-Autosave
 * @license    MIT
 *
 * @source https://github.com/pauloamgomes/CockpitCMS-Autosave
 * @see { README.md } for usage info.
 *
 * CHANGES (01/21):
 * - code comments
 */

if (COCKPIT_ADMIN && !COCKPIT_API_REQUEST) {
  $this->module('autosave')->extend([
    'get' => function($id) {
      $data = $this->app->storage->findOne('cockpit/autosave', ['_oid' => $id]);
      $type = $data['_type'] ?? NULL;
      $resource = NULL;
      if (!$data || !$data['_oid']) {
        return;
      }

      if ($type === 'collection') {
        $resource = $this->app->storage->findOne("collections/{$data['_name']}", ['_id' => $data['_oid']]);
        if (!$resource || $resource['_modified'] === $data['data']['_modified']) {
          $this->app->storage->remove('cockpit/autosave', ['_oid' => $id]);
          return;
        }
      }

      $user = ['name' => 'N/A', 'email' => 'N/A', 'group' => 'N/A'];
      if ($data['_creator'] && $account = $this->app->storage->findOne('cockpit/accounts', ['_id' => $data['_creator']])) {
        $user['name'] = $account['name'] ?? $account['user'];
        $user['email'] = $account['email'];
        $user['group'] = $account['group'];
      }

      return [
        'id' => $data['_id'],
        'date' => date('M d, Y H:i:s', $data['_modified']),
        'data' => $data['data'],
        'user' => $user,
      ];
    },

    'save' => function($autosaved) {
      $id = $autosaved['id'];
      $data = $autosaved['data'];
      $type = $autosaved['type'];
      $name = $autosaved['name'];

      $user = $this->app->module('cockpit')->getUser();

      $existing = $this->app->storage->findOne('cockpit/autosave', ['_oid' => $id]);

      if ($type === 'collection') {
        $data['_modified'] = time();
      }

      $entry = [
        '_oid' => $id,
        'data' => $data,
        '_type' => $type,
        '_name' => $name,
        '_creator' => $user['_id'] ?? NULL,
        '_modified' => time()
      ];

      $this->app->trigger('cockpit.autosave.save', [&$data, $existing !== NULL]);

      if ($existing) {
        $entry['_id'] = $existing['_id'];
        $this->app->storage->save('cockpit/autosave', $entry);
      }
      else {
        $this->app->storage->insert('cockpit/autosave', $entry);
      }

      return ['updated' => date('M d, Y H:i:s', $entry["_modified"])];
    },

    'remove' => function($id) {
      return $this->app->storage->remove('cockpit/autosave', ['_id' => $id]);
    },

    'removeEntry' => function($id) {
      return $this->app->storage->remove('cockpit/autosave', ['_oid' => $id]);
    },
  ]);
}

if (COCKPIT_ADMIN && !COCKPIT_API_REQUEST) {
  include_once __DIR__ . '/admin.php';
  include_once __DIR__ . '/actions.php';
}

if (COCKPIT_API_REQUEST) {
  include_once __DIR__ . '/actions.php';
}
