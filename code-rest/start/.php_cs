<?php

$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__.'/src', __DIR__.'/app']);

return PhpCsFixer\Config::create()
    ->setRules(
        [
            '@Symfony' => true,
            '@Symfony:risky' => true,
            '@DoctrineAnnotation' => true,
            'array_syntax' => ['syntax' => 'short'],
            'combine_consecutive_unsets' => true,
            'general_phpdoc_annotation_remove' => true,
            'linebreak_after_opening_tag' => true,
            'modernize_types_casting' => true,
            'native_function_invocation' => true,
            'no_extra_consecutive_blank_lines' => [
                'break',
                'continue',
                'extra',
                'return',
                'throw',
                'use',
                'parenthesis_brace_block',
                'square_brace_block',
                'curly_brace_block',
            ],
            'no_useless_else' => true,
            'no_useless_return' => true,
            'ordered_imports' => true,
            'phpdoc_order' => true,
            'protected_to_private' => true,
            'psr4' => true,
            'strict_comparison' => false,
            'strict_param' => false,
            'is_null' => false,
        ]
    )
    ->setCacheFile(__DIR__.'/.php_cs.cache')
    ->setUsingCache(true)
    ->setFinder($finder);
