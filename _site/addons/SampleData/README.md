# cockpit-sample-data

Sample data installer addon for [Cockpit CMS](http://getcockpit.com/)

## Features

- Automatically import sample data on Cockpit CMS install

## Installation

### Manual

Download [latest release](https://github.com/Raruto/cockpit-sample-data) and extract to `COCKPIT_PATH/addons/SampleData` directory

### Git

```sh
git clone https://github.com/Raruto/cockpit-sample-data.git ./addons/SampleData
```

### Cockpit CLI

```sh
php ./cp install/addon --name SampleData --url https://github.com/Raruto/cockpit-sample-data.git
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
   composer require raruto/cockpit-sample-data
   ```

---

**Related projects:** [cockpit-blog](https://github.com/raruto/cockpit-blog)

**Compatibile with:** [![Cockpit CMS](https://img.shields.io/badge/cockpit-0.11.2-1EB300.svg?style=flat)](https://github.com/agentejo/cockpit)
