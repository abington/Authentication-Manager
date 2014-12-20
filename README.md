# chippyash/authentication-manager

## Quality Assurance

[![Build Status](https://travis-ci.org/chippyash/Authentication-Manager.svg?branch=master)](https://travis-ci.org/chippyash/Authentication-Manager)
[![Coverage Status](https://img.shields.io/coveralls/chippyash/Authentication-Manager.svg)](https://coveralls.io/r/chippyash/Authentication-Manager)

Certified for PHP 5.5+

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
    use chippyash\Authentication\Manager\DigestManager;
    use chippyash\Authentication\Manager\Encoder\BasicEncoder;
    use chippyash\Authentication\Manager\Digest\BasicDigestCollection;
    use chippyash\Type\String\StringType;

    $realm = new StringType('realm');
    $digestFileName = new StringType('/path/to/my/file');

    $encoder = new BasicEncoder();
    $encoder->setRealm($realm);

    $collection = new BasicDigestCollection($encoder, $digestFileName);
    $collection->setRealm($realm);

    $this->authManager = new DigestManager($collection);
</pre>

#### Adding new manager types

Implement the chippyash\Authentication\Manager\ManagerInterface to create new types of Authentication Managers.

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
    "chippyash/authentication-manager": "~1.0"
</pre>

to your composer.json "requires" section

#### For development

Clone this repo, and then run Composer in local repo root to pull in dependencies

<pre>
    git clone git@github.com:chippyash/Authentication-Manager.git AuthMan
    cd AuthMan
    composer install --dev
</pre>

To run the tests:

<pre>
    cd AuthMan
    vendor/bin/phpunit -c test/phpunit.xml test/
</pre>

If you have [Testdox Converter](https://packagist.org/packages/chippyash/testdox-converter)
installed you can rebuild the Test Contract by running build.sh on \*nix systems.
 

## Other stuff

Check out the other packages at [my blog site](http://the-matrix.github.io/packages/) for more PHP stuff;

## History

V0...  pre releases

V1.0.0 Initial version tagged
