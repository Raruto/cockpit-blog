# cockpit-honeypot
Honeypot addon for [Cockpit CMS](http://getcockpit.com/)

## Features

- Add "honeypot" switch to Forms settings
- Automatically append "honeypot" field to cockpit `Forms::open` api
- Automatically validate "honeypot" submitted field to cockpit `Forms::submit`
- Automatically exclude invalid submissions from saved entries

## Installation

### Manual

Download [latest release](https://github.com/Raruto/cockpit-honeypot) and extract to `COCKPIT_PATH/addons/Honeypot` directory

### Git

```sh
git clone https://github.com/Raruto/cockpit-honeypot.git ./addons/Honeypot
```

### Cockpit CLI

```sh
php ./cp install/addon --name Honeypot --url https://github.com/Raruto/cockpit-honeypot.git
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
  composer require raruto/cockpit-honeypot
  ```

---

**Related projects:** [ExtendedForms](https://github.com/Raruto/cockpit-extended-forms), [FormValidation](https://github.com/raffaelj/cockpit_FormValidation)

**Compatibile with:** [![Cockpit CMS](https://img.shields.io/badge/cockpit-0.11.2-1EB300.svg?style=flat)](https://github.com/agentejo/cockpit)
