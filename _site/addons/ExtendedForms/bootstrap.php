<?php
/**
 * Cockpit extended forms addon
 *
 * @author  Raruto
 * @package cockpit-blog
 * @license MIT
 *
 * REQUIRES:
 * - https://github.com/agentejo/cockpit/pull/1399
 * - https://github.com/agentejo/cockpit/pull/1400
 */

/**
 * Check and populate forms $data['files'] entry
 *
 * @return array $folder
 */
$app->on('forms.submit.before', function($form, &$data, $frm, &$options) use ($app) {

    $files = get_uploaded_files();

    if (!empty($files)) {

        $files = $app->module('cockpit')->uploadAssets('files', ['folder' => get_forms_uploads_folder()]);

        // save entries as filename
        $data['files'] = $files['uploaded'];

        // save entries as filepath
        // $data['files'] = [];
        // $ASSETS_URL    = rtrim($app->filestorage->getUrl('assets://'), '/');
        //
        // foreach($files['assets'] as $file) {
        //   $data['files'][] = $ASSETS_URL.$file['path'];
        // }

    }

});

/**
 * Check and retrieve forms uploaded files
 *
 * @return array $data
 */
function get_uploaded_files() {
    $app    = cockpit();

    $files  = $app->param('files', [], $_FILES);
    $data   = [];

    if (isset($files['name']) && is_array($files['name'])) {
      for ($i = 0; $i < count($files['name']); $i++) {
        if (is_uploaded_file($files['tmp_name'][$i]) && !$files['error'][$i]) {
            foreach($files as $k => $v) {
                $data['files'][$k]   = $data['files'][$k] ?? [];
                $data['files'][$k][] = $files[$k][$i];
            }
        }
      }
    }

    return $data;
}

/**
 * Check and retrieve forms upload folder
 *
 * @return array $folder
 */
function get_forms_uploads_folder() {
    $app    = cockpit();

    $name   = 'forms_uploads';
    $parent = '';
    $folder = $app->storage->findOne('cockpit/assets_folders', ['name'=>$name, '_p'=>$parent]);

    if (empty($folder)) {
      $user   = $app->storage->findOne('cockpit/accounts', ['group'=>'admin'], ['_id' => 1]);
      $meta   = [
          'name' => $name,
          '_p'   => $parent,
          '_by'  => $user['_id'] ?? '',
      ];
      $folder = $app->storage->save('cockpit/assets_folders', $meta);
    }

    return $folder;
}
