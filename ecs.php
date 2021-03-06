<?php

use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\CodingStandard\Fixer\Spacing\MethodChainingNewlineFixer;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    // Paths - alternative to CLI arguments, easier to maintain and extend
    $parameters->set(Option::PATHS, [
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    // Full sets
    $parameters->set(Option::SETS, [
        SetList::COMMON,
        SetList::CLEAN_CODE,
        SetList::PSR_12,
        SetList::SYMFONY,
        SetList::SYMPLIFY,
    ]);

    // Skip rules
    $parameters->set(Option::SKIP, [
        // skip paths
        __DIR__ . '/src/Kernel.php',
        __DIR__ . '/src/DataFixtures/*',

        // skip rule completely
        DeclareStrictTypesFixer::class,
        MethodChainingNewlineFixer::class,

        // ignore specific error message
        //'Cognitive complexity for method "addAction" is 13 but has to be less than or equal to 8.',
    ]);

    // Standalone rules
    $services = $containerConfigurator->services();
    $services->set(LineLengthFixer::class);
};
