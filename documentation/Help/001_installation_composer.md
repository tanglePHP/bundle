![](.meta/Banner.png)

> #### Please be aware that this Examples are in an early development state and the API of the library as well as the "Stardust" protocol is subject to change, it is NOT ready to use in production.

<a href="https://discord.iota.org/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Discord-9cf.svg?style=social&logo=discord" alt="Discord"></a>
<a href="https://twitter.com/tanglePHP/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Twitter-@tanglePHP-9cf.svg?style=social&logo=twitter" alt="Twitter"></a> ‖
<a href="https://www.tanglephp.com/" style="text-decoration:none;"><img src="https://img.shields.io/badge/tanglePHP-grey?style=flat-square&logo=tanglePHP" alt="Shimmer"></a>
<a href="https://www.iota.org/" style="text-decoration:none;"><img src="https://img.shields.io/badge/IOTA-grey?style=flat-square&logo=iota" alt="IOTA"></a>
<a href="https://www.shimmer.network/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Shimmer-grey?style=flat-square&logo=shimmer" alt="Shimmer"></a> ‖
<a href="https://www.php.net/" style="text-decoration:none;"><img src="https://img.shields.io/badge/PHP->= 8.1.x-blue?style=flat-square&logo=php" alt=">PHP 8"></a>
<a href="https://github.com/iota-community/iota.php/LICENSE" style="text-decoration:none;"><img src="https://img.shields.io/badge/license-Apache--2.0-green?style=flat-square" alt="Apache-2.0 license"></a>

---

## Installation (composer)

1 .Install Composer In Your Project
> curl -sS https://getcomposer.org/installer | php

Or download composer.phar into your project root.

2 . create composer.json

```JSON 
{
  "require": {
    "php": ">=8.1.0",
    "ext-curl": "*",
    "ext-sodium": "*",
    "ext-mbstring": "*",
    "ext-bcmath": "*",
    "ext-ctype": "*",
    "ext-openssl": "*",
    "tanglephp/network": "*"
  }
}
```

Or download tanglephp/bundle.

3 . Execute this in your project root.

> php composer.phar install


4 . Autoload Dependencies

If your packages specify autoloading information, you can autoload all the dependencies by adding this to your code:

> require 'vendor/autoload.php';



---

<- Back to [Overview](000_index.md)