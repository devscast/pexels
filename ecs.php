<?php

declare(strict_types=1);

return static function (\Symplify\EasyCodingStandard\Config\ECSConfig $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Symplify\EasyCodingStandard\ValueObject\Option::PATHS, [
        __DIR__ . '/src',
    ]);

    $containerConfigurator->import(Symplify\EasyCodingStandard\ValueObject\Set\SetList::PSR_12);
    $containerConfigurator->import(Symplify\EasyCodingStandard\ValueObject\Set\SetList::COMMON);
    $containerConfigurator->import(Symplify\EasyCodingStandard\ValueObject\Set\SetList::CLEAN_CODE);

    $services = $containerConfigurator->services();
    $services->remove(PhpCsFixer\Fixer\Operator\ConcatSpaceFixer::class);
};
