--TEST--
Validate the happy path by checking the deprecations in the source path.
--FILE--
<?php

declare(strict_types=1);

(static fn () => require __DIR__ . '/../../vendor/autoload.php')();

system('php bin/depreday src');

--EXPECTF--
)  (  )  (
  (^)(^)(^)(^)
  _i__i__i__i_
 (____________)          Depreday
 |####|>o<|###|      Let's Party on!
 (____________)


Finding deprecations in the directory: %s


Console/App.php:1
%s

done.
