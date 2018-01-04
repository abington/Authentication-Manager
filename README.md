# chippyash/authentication-manager

## Quality Assurance

![PHP 5.5](https://img.shields.io/badge/PHP-5.5-blue.svg)
![PHP 5.6](https://img.shields.io/badge/PHP-5.6-blue.svg)
![PHP 7](https://img.shields.io/badge/PHP-7-blue.svg)
[![Build Status](https://travis-ci.org/chippyash/Authentication-Manager.svg?branch=master)](https://travis-ci.org/chippyash/Authentication-Manager)
[![Test Coverage](https://codeclimate.com/github/chippyash/Authentication-Manager/badges/coverage.svg)](https://codeclimate.com/github/chippyash/Authentication-Manager/coverage)
[![Code Climate](https://codeclimate.com/github/chippyash/Authentication-Manager/badges/gpa.svg)](https://codeclimate.com/github/chippyash/Authentication-Manager)

## What?

Provides base for creating managers that manage identity entries in some back
end authentication system.

The single one provided at present is an HTTP Basic Digest Manager.

The library is released under the [GNU GPL V3 or later license](http://www.gnu.org/copyleft/gpl.html)

## When?

If you want more, either suggest it, or better still, fork it and provide a pull request.

## How?

You can find the [API documentation here](http://chippyash.github.io/Authentication-Manager)

You will find the Test Contract in the docs directory alongside an example
Symfony DI container definition.

### Coding Basics

#### Construction

<pre>
    use Chippyash\Authentication\Manager\DigestManager;
    use Chippyash\Authentication\Manager\Encoder\BasicEncoder;
    use Chippyash\Authentication\Manager\Digest\BasicDigestCollection;
    use Chippyash\Type\String\StringType;

    $realm = new StringType('realm');
    $digestFileName = new StringType('/path/to/my/file');

    $encoder = new BasicEncoder();
    $encoder->setRealm($realm);

    $collection = new BasicDigestCollection($encoder, $digestFileName);
    $collection->setRealm($realm);

    $this->authManager = new DigestManager($collection);
</pre>

#### Adding new manager types

Implement the Chippyash\Authentication\Manager\ManagerInterface to create new types of Authentication Managers.

### Changing the library

1.  fork it
2.  write the test
3.  amend it
4.  do a pull request

Found a bug you can't figure out?

1.  fork it
2.  write the test
3.  do a pull request

NB. Make sure you rebase to HEAD before your pull request

## Where?

The library is hosted at [Github](https://github.com/chippyash/Authentication-Manager). It is
available at [Packagist.org](https://packagist.org/packages/chippyash/authentication-manager)

### Installation

Install [Composer](https://getcomposer.org/)

#### For production

<pre>
    "chippyash/authentication-manager": "~2.0"
</pre>

to your composer.json "requires" section

#### For development

Clone this repo, and then run Composer in local repo root to pull in dependencies

<pre>
    git clone git@github.com:chippyash/Authentication-Manager.git AuthMan
    cd AuthMan
    composer install
</pre>

To run the tests:

<pre>
    cd AuthMan
    vendor/bin/phpunit -c test/phpunit.xml test/
</pre>

If you have [Testdox Converter](https://packagist.org/packages/chippyash/testdox-converter)
installed you can rebuild the Test Contract by running build.sh on \*nix systems.
 

## Other stuff

Check out [ZF4 Packages](http://zf4.biz/packages?utm_source=github&utm_medium=web&utm_campaign=blinks&utm_content=slimdicexample) for more packages

## License

This software library is released under the [GNU GPL V3 or later license](http://www.gnu.org/copyleft/gpl.html)

This software library is Copyright (c) 2014-2016, Ashley Kitson, UK

A commercial license is available for this software library, please contact the author. 
It is normally free to deserving causes, but gets you around the limitation of the GPL
license, which does not allow unrestricted inclusion of this code in commercial works.

## History

V0...  pre releases

V1.0.0 Initial version tagged

V1.0.1 Amends for CI

V1.0.2 Typos in dic example

V1.0.3 Self initialise the manager

V2.0.0 BC Break: change namespace from chippyash\Authentication to Chippyash\Authentication

V2.0.1 Add link to packages

V2.0.2 Verify PHP7 compatibility

V2.0.3 Move coverage to codeclimate

V2.0.4 Update travis build script