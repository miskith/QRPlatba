<?php

$finder = Symfony\Component\Finder\Finder::create()
	->notPath('bin')
	->notPath('vendor')
	->in(__DIR__)
	->name('*.php');

return (new PhpCsFixer\Config)
	->setRules([
		'@PSR12' => true,
		'@PHP81Migration' => true,
		'array_syntax' => ['syntax' => 'short'],
		'no_unused_imports' => true,
		'trim_array_spaces' => true,
		'single_quote' => true,
		'array_indentation' => true,
		'no_extra_blank_lines' => true,
		'ordered_imports' => [
			'sort_algorithm' => 'none',
		],
	])
	->setIndent("\t")
	->setLineEnding("\n")
	->setFinder($finder);
