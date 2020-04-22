🎂 Depreday
<!-- ALL-CONTRIBUTORS-BADGE:START - Do not remove or modify this section -->
[![All Contributors](https://img.shields.io/badge/all_contributors-1-orange.svg?style=flat-square)](#contributors-)
<!-- ALL-CONTRIBUTORS-BADGE:END -->
===========

Now you have the change to commemorate important deprecation day marks
with your colleagues at work. After all, we have to celebrate our 
achievements.

Installing
----------

Use composer to install, or copy paste every single file from the 
github ui to your disk.

```bash
$ composer require codelicia/depreday 
```

Usage
-----

```
depreday [-x|--extension [EXTENSION]] [-e|--exclude [EXCLUDE]] [--] [<dir>]
```

**default values**:

- `dir`: current working directory `$PWD`
- `extension`: `php`
- `exclude`: [`vendor`, `var`, `cache`, `node_modules`]

Limitations
-----------

1. It requires you to have the file commit in a git repository; 
2. `codelicia/depreday` uses `git-blame` to check for changes in the line
   that have the `deprecated` annotation. So it can be inaccurate as unrelated
   changes in the file may cause the line to miss-computed as "changed".

Contributors
------------

<!-- ALL-CONTRIBUTORS-BADGE:START -->
<!-- ALL-CONTRIBUTORS-BADGE:END -->

Author
------

- Jefersson Nathan ([@malukenho](http://github.com/malukenho))

## Contributors ✨

Thanks goes to these wonderful people ([emoji key](https://allcontributors.org/docs/en/emoji-key)):

<!-- ALL-CONTRIBUTORS-LIST:START - Do not remove or modify this section -->
<!-- prettier-ignore-start -->
<!-- markdownlint-disable -->
<table>
  <tr>
    <td align="center"><a href="https://twitter.com/malukenho"><img src="https://avatars2.githubusercontent.com/u/3275172?v=4" width="100px;" alt=""/><br /><sub><b>Jefersson Nathan</b></sub></a><br /><a href="#maintenance-malukenho" title="Maintenance">🚧</a> <a href="https://github.com/codelicia/depreday/commits?author=malukenho" title="Code">💻</a></td>
  </tr>
</table>

<!-- markdownlint-enable -->
<!-- prettier-ignore-end -->
<!-- ALL-CONTRIBUTORS-LIST:END -->

This project follows the [all-contributors](https://github.com/all-contributors/all-contributors) specification. Contributions of any kind welcome!