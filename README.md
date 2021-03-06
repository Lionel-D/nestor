# NESTOR

*Smart groceries shopping list manager*

[![Maintainability](https://api.codeclimate.com/v1/badges/8d5489efd66c4e0cc9ce/maintainability)](https://codeclimate.com/github/Lionel-D/nestor/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/8d5489efd66c4e0cc9ce/test_coverage)](https://codeclimate.com/github/Lionel-D/nestor/test_coverage)
[![Build Status](https://travis-ci.com/Lionel-D/nestor.svg?branch=develop)](https://travis-ci.com/Lionel-D/nestor)

---

### Requirements

- **[PHP](https://www.php.net/)** `7.4.15 or greater`
- **[MySQL](https://www.mysql.com/)** `8.0.19 or greater`
- **[Composer](https://getcomposer.org/)** `1.10.6 or greater`
- **[Yarn](https://yarnpkg.com)** `1.22.4 or greater`
- **[Symfony client](https://symfony.com/download)** `4.15.0 or greater`

---

### Installation

- create `.env.local` based on `.env` and set values for your local environment.
- `composer install` to get the framework dependencies.
- `yarn install` to get the assets dependencies.
- `php bin/console doctrine:database:create` to create database.
- `php bin/console doctrine:migrations:migrate` to setup database structure.
- `php bin/console doctrine:fixtures:load` to load data.

---

### Local environment

- `yarn encore dev --watch` to launch webpack.
- `symfony server:start` to launch local server.

---

### Tests

- create `phpunit.xml` based on `phpunit.xml.dist`
- add the following to your local `phpunit.xml` file, under `<php>` :
    - `<env name="BOOTSTRAP_LOCAL_TEST_ENV" value="test"/>` to force execution in test environment.
    - `<env name="DATABASE_URL" value="mysql://db_user:db_password@127.0.0.1:3306/nestor_test"/>` with the credentials for your local database
- `composer testsbaseline` to run the tests and generate a baseline file for deprecations notices.
- `composer tests` to run the tests.

---

### Refactoring

**WARNING:** phpunit must be executed at least once before using phpstan or rector in order for them to run correctly.
(because of phpunit-bridge, if that's not the case there's no autoload for phpunit classes)

- `composer rectordry` to dryrun rector.
- `composer rector` to run rector and apply changes.
- `composer phpstan` to run phpstan.
- `composer ecsdry` to dryrun easy coding standard.
- `composer ecs` to run easy coding standard and apply fixers.
