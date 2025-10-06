<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

return (new Config())
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
    ->setFinder(Finder::create()->in([
        './src',
        './tests',
    ]))
    ->setRules([
        '@PSR12' => true,
        '@PHP8x2Migration:risky' => true,
        'php_unit_attributes' => true,
        'no_empty_phpdoc' => true,
    ])
    ->setRiskyAllowed(true)
    ->setUsingCache(true);
