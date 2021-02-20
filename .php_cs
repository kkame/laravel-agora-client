<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in('src')
    ->in('tests');

$config = Config::create()
    // use symfony level and extra fixers:
    ->setRules(array(
        '@PSR12' => true,
        'array_syntax' => array('syntax' => 'short'),
    ))
    ->setFinder($finder);

return $config;