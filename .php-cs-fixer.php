<?php

$finder = Symfony\Component\Finder\Finder::create()
	->notPath('bin')
	->notPath('vendor')
	->in(__DIR__)
	->name('*.php');

return (new PhpCsFixer\Config)
	->setRules([
		'@PSR12' => true,
		'array_syntax' => ['syntax' => 'short'],
		'ordered_imports' => ['sortAlgorithm' => 'alpha'],
		'no_unused_imports' => true,
		'trim_array_spaces' => true,
		'ordered_imports' => [
			'sort_algorithm' => 'none',
		],
	])
	->setIndent("\t")
	->setLineEnding("\n")
	->setFinder($finder);
