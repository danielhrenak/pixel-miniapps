# PHP upgrade options

Preferred: install PHP >= 8.2

- macOS (Homebrew):
  - brew update
  - brew install php@8.2
  - follow any caveats to link php or update PATH

- Ubuntu (example):
  - add-apt-repository ppa:ondrej/php
  - apt update
  - apt install php8.2 php8.2-cli php8.2-fpm php8.2-mbstring php8.2-xml

- Windows: use the official PHP 8.2 build or WSL with the Linux instructions.

Alternative: use Docker (isolated, recommended for quick tests)
- docker run --rm -it -v "$PWD":/app -w /app php:8.2-cli bash
- inside container: composer install

Quick workaround (composer only)
- Add the `"config": { "platform": { "php": "8.2.0" } }` entry in composer.json (project root).
- Run `composer update --lock` then `composer install`.

Warning: the composer platform override only affects dependency resolution. If runtime PHP < 8.2, some packages may use features that will break at runtime. Prefer upgrading the PHP runtime.
