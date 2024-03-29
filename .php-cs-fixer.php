<?php

$rules = [
    '@PSR2' => true,
    'array_syntax' => ['syntax' => 'short'],
    'object_operator_without_whitespace' => true,
    'no_whitespace_in_blank_line' => true,
    'standardize_not_equals' => true,
    'no_extra_blank_lines' => ['tokens' => ['extra']],
];

$finder = \Symfony\Component\Finder\Finder::create()
    ->files()
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
    ->in(__DIR__)
    ->exclude('vendor')
    ->notPath('autoload_classmap.php');

return (new PhpCsFixer\Config())
    ->setRules($rules)
    ->setFinder($finder);