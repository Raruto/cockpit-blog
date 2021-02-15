# cockpit-sample-addon

Sample addon for [Cockpit CMS](http://getcockpit.com/)

## Features

- Add a sample `/api/test` Rest API endpoint

## Installation

### Manual

Download [latest release](https://github.com/Raruto/cockpit-sample-addon) and extract to `COCKPIT_PATH/addons/SampleAddon` directory

### Git

```sh
git clone https://github.com/Raruto/cockpit-sample-addon.git ./addons/SampleAddon
```

### Cockpit CLI

```sh
php ./cp install/addon --name SampleAddon --url https://github.com/Raruto/cockpit-sample-addon.git
```

### Composer

1. Make sure path to cockpit addons is defined in your projects' _composer.json_ file:

   ```json
   {
       "name": "MY_PROJECT",
       "extra": {
           "installer-paths": {
               "cockpit/addons/{$name}": ["type:cockpit-module"]
           }
       }
   }
   ```

2. In your project root run:

   ```sh
   composer require raruto/cockpit-sample-addon
   ```

---

**Related projects:** [cockpit-blog](https://github.com/raruto/cockpit-blog)

**Compatibile with:** [![Cockpit CMS](https://img.shields.io/badge/cockpit-0.11.2-1EB300.svg?style=flat)](https://github.com/agentejo/cockpit)
