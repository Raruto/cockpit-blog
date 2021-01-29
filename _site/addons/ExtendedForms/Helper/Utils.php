<?php

namespace ExtendedForms\Helper;

class Utils extends \Lime\Helper {

    /**
     * Check and retrieve forms uploaded files
     *
     * @return array $data
     */
    public function get_uploaded_files() {
        $files  = $this->app->param('files', [], $_FILES);
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
    public function get_forms_uploads_folder() {
        $name   = 'forms_uploads';
        $parent = '';
        $folder = $this->app->storage->findOne('cockpit/assets_folders', ['name'=>$name, '_p'=>$parent]);

        if (empty($folder)) {
            $user   = $this->app->storage->findOne('cockpit/accounts', ['group'=>'admin'], ['_id' => 1]);
            $meta   = [
                'name' => $name,
                '_p'   => $parent,
                '_by'  => $user['_id'] ?? '',
            ];
            $folder = $this->app->storage->save('cockpit/assets_folders', $meta);
        }

        return $folder;
    }

}
