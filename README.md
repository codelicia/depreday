🎂 Depreday
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
depreday [<dir> [<extension> [<exclude>]]]
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
