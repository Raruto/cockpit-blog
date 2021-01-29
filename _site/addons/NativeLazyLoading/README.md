# cockpit-native-lazy-loading

Native lazy loading addon for [Cockpit CMS](http://getcockpit.com/)

## Features

Automatically add [`img[loading="lazy"]`](https://web.dev/browser-level-image-lazy-loading/) attribute to content images (tinymce and html-editor).

Natively supported by the most popular browsers (Chrome, Edge, Opera and Firefox) without the need to use a separate JavaScript library. [Browsers](https://caniuse.com/#feat=loading-lazy-attr) that do not support the loading attribute simply ignore it without side-effects.

## Installation

### Manual

Download [latest release](https://github.com/Raruto/cockpit-native-lazy-loading/releases/latest) and extract to `COCKPIT_PATH/addons/NativeLazyLoading` directory

### Git

```sh
git clone https://github.com/Raruto/cockpit-native-lazy-loading.git ./addons/NativeLazyLoading
```

### Cockpit CLI

```sh
php ./cp install/addon --name NativeLazyLoading --url https://github.com/Raruto/cockpit-native-lazy-loading.git
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
   composer require raruto/cockpit-native-lazy-loading
   ```

---

**Compatibile with:** [![Cockpit CMS](https://img.shields.io/badge/cockpit-0.11.2-1EB300.svg?style=flat)](https://github.com/agentejo/cockpit)
