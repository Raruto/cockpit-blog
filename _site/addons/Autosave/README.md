# Autosave add-on for Cockpit CMS

This add-on enhances Cockpit CMS by providing the ability to persist automatically changes on collection entries or singletons form data.
That means if the user closes by mistake the browser (by mistake or by a system failure) the changes will not be lost and when someone tries to edit the same resource, the system will ask if he wants to continue from a previous saved version.

## Installation

Download and unpack add-on to `<cockpit-folder>/addons/Autosave` folder.

## Configuration

In order to use the addon, it's required to specifiy in the Cockpit config the collections and/or singletons we want to autosave, e.g.:

```yaml
autosave:
  collections: *
  singletons:
    - settings
    - seo
```

In the above example we are saying to apply Autosave to all collections (use of *) and to specifically the singletons with name "settings" and "seo".

For non admin users its required to provide a permission ("access"), e.g.:

```yaml
groups:
  editor:
    autosave:
      access: true
```

## Usage

When enabled, the addon will provide a small sidebar block that will display status of autosaves user did:

![Autosave Screencast](https://monosnap.com/image/NCGobMrsLJnIJqV6aoGdjIPZwYXAf3)

When using Autosave, only a version is stored in the database containing the latest changes user did in the resource.
When user saves the resource, the autosave entry is automatically removed.


## Copyright and license

Copyright 2019 pauloamgomes under the MIT license.
