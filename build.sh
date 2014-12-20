#!/bin/bash
cd ~/Projects/Type
vendor/bin/phpunit -c test/phpunit.xml --testdox-html contract.html test/
tdconv -t "Chippyash Authentication Manager" contract.html docs/Test-Contract.md
rm contract.html

