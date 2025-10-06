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
    ])
    ->setRiskyAllowed(true)
    ->setUsingCache(true);
