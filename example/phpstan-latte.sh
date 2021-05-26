#!/bin/bash

dir=$(cd `dirname $0` && pwd)

mkdir -p $dir/temp

php $dir/../bin/containerLatteDumper.php $dir/app/bootstrap.php $dir/app $dir/temp/phpstan-latte

$dir/../vendor/bin/phpstan analyze $dir/temp/phpstan-latte -c $dir/phpstan.latte.neon