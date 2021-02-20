# cockpit-extended-forms

Extended forms addon for [Cockpit CMS](http://getcockpit.com/)

## Features

- Automatically check and retrieve forms uploaded [$_FILES](https://github.com/agentejo/cockpit/pull/1411).
- Improved [Forms::open](https://github.com/agentejo/cockpit/pull/1400) and [Forms::close](https://github.com/agentejo/cockpit/pull/1400) api
- Improved [Forms::submit](https://github.com/agentejo/cockpit/pull/1399) logic
- Fix [Forms::submit](https://github.com/agentejo/cockpit/pull/1411) api

## Installation

### Manual

Download [latest release](https://github.com/Raruto/cockpit-extended-forms) and extract to `COCKPIT_PATH/addons/ExtendedForms` directory

### Git

```sh
git clone https://github.com/Raruto/cockpit-extended-forms.git ./addons/ExtendedForms
```

### Cockpit CLI

```sh
php ./cp install/addon --name ExtendedForms --url https://github.com/Raruto/cockpit-extended-forms.git
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
   composer require raruto/cockpit-extended-forms
   ```

---

**Related projects:** [AdvancedForms](https://github.com/uktcmtt/cockpit-module-advancedforms), [FormValidation](https://github.com/raffaelj/cockpit_FormValidation)

**Compatibile with:** [![Cockpit CMS](https://img.shields.io/badge/cockpit-0.11.2-1EB300.svg?style=flat)](https://github.com/agentejo/cockpit)
