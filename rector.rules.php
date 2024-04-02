<?php

// see: https://getrector.com/documentation/rules-overview
// see: https://github.com/driftingly/rector-laravel/blob/main/docs/rector_rules_overview.md

return [
    'paths' => [
        __DIR__ . '/src'
    ],

    'sets'              => [
        RectorLaravel\Set\LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
        // Rector\Set\ValueObject\SetList::DEAD_CODE,
        // Rector\Set\ValueObject\SetList::CODE_QUALITY,
        // RectorLaravel\Set\LaravelSetList::LARAVEL_CODE_QUALITY,
        // Rector\PHPUnit\Set\PHPUnitSetList::PHPUNIT_100,
       // Rector\Set\ValueObject\LevelSetList::UP_TO_PHP_81,
       // Rector\Set\ValueObject\LevelSetList::UP_TO_PHP_82,
       // Rector\Set\ValueObject\LevelSetList::UP_TO_PHP_83,
       // Rector\Set\ValueObject\SetList::TYPE_DECLARATION,
       // Rector\Set\ValueObject\SetList::EARLY_RETURN,
    ],
    'rules'             => [
        Rector\Php82\Rector\Param\AddSensitiveParameterAttributeRector::class,
        RectorLaravel\Rector\FuncCall\RemoveDumpDataDeadCodeRector::class,
        Rector\Php82\Rector\FuncCall\Utf8DecodeEncodeToMbConvertEncodingRector::class,
        RectorLaravel\Rector\PropertyFetch\OptionalToNullsafeOperatorRector::class,
        Rector\CodingStyle\Rector\FuncCall\ConsistentImplodeRector::class,
        // RectorLaravel\Rector\Class_\UnifyModelDatesWithCastsRector::class,
        // RectorLaravel\Rector\ClassMethod\AddGenericReturnTypeToRelationsRector::class,
        // RectorLaravel\Rector\MethodCall\EloquentWhereRelationTypeHintingParameterRector::class,
        Rector\CodingStyle\Rector\Use_\SeparateMultiUseImportsRector::class,
        RectorLaravel\Rector\Empty_\EmptyToBlankAndFilledFuncRector::class,
        RectorLaravel\Rector\FuncCall\NotFilledBlankFuncCallToBlankFilledFuncCallRector::class,
        // Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector::class,
        // Rector\CodeQuality\Rector\Catch_\ThrowWithPreviousExceptionRector::class,
        // Rector\CodingStyle\Rector\FuncCall\CountArrayToEmptyArrayComparisonRector::class,
        // Rector\CodingStyle\Rector\ClassMethod\MakeInheritedMethodVisibilitySameAsParentRector::class,
        // Rector\CodingStyle\Rector\ClassMethod\NewlineBeforeNewAssignSetRector::class,
        // Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector::class,
        // RectorLaravel\Rector\ClassMethod\MigrateToSimplifiedAttributeRector::class,
        // Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector::class,
        // RectorLaravel\Rector\Class_\AddExtendsAnnotationToModelFactoriesRector::class,
        // RectorLaravel\Rector\ClassMethod\AddParentBootToModelClassMethodRector::class,
        // RectorLaravel\Rector\ClassMethod\AddParentRegisterToEventServiceProviderRector::class,
        // RectorLaravel\Rector\MethodCall\FactoryApplyingStatesRector::class,
        // RectorLaravel\Rector\Class_\PropertyDeferToDeferrableProviderToRector::class,
        // RectorLaravel\Rector\Class_\AnonymousMigrationsRector::class,
        // RectorLaravel\Rector\MethodCall\EloquentOrderByToLatestOrOldestRector::class,
        // RectorLaravel\Rector\MethodCall\EloquentWhereTypeHintClosureParameterRector::class,
        // RectorLaravel\Rector\PropertyFetch\ReplaceFakerInstanceWithHelperRector::class,
        // RectorLaravel\Rector\FuncCall\SleepFuncToSleepStaticCallRector::class,
        // RectorLaravel\Rector\Expr\SubStrToStartsWithOrEndsWithStaticMethodCallRector\SubStrToStartsWithOrEndsWithStaticMethodCallRector::class,
        // RectorLaravel\Rector\MethodCall\AssertStatusToAssertMethodRector::class,
        // Rector\TypeDeclaration\Rector\ArrowFunction\AddArrowFunctionReturnTypeRector::class,
        // RectorLaravel\Rector\If_\ThrowIfRector::class,
        //     Rector\EarlyReturn\Rector\If_\ChangeNestedIfsToEarlyReturnRector::class,
        //     Rector\EarlyReturn\Rector\If_\RemoveAlwaysElseRector::class,
    ],
    'excludes'          => [

        //\Rector\CodeQuality\Rector\Array_\CallableThisArrayToAnonymousFunctionRector::class,
        // \Rector\DeadCode\Rector\PropertyProperty\RemoveNullPropertyInitializationRector::class,
        //\RectorLaravel\Rector\ClassMethod\AddGenericReturnTypeToRelationsRector::class,
            // __DIR__ . '/src/WholeDirectory',

            // // or use fnmatch
            // __DIR__ . '/src/*/Tests/*',

            //or a specific test
            // \Rector\CodeQuality\Rector\If_\SimplifyIfReturnBoolRector::class,

            // Do you want to skip specific rule only in a specific file?
            // \Rector\CodeQuality\Rector\If_\SimplifyIfReturnBoolRector::class => [
            //     __DIR__ . '/src/ComplicatedFile.php',
            // ],
    ],
    //see https://getrector.com/documentation/troubleshooting-parallel
    'timeout'           => 180, //max seconds the job should run for
    'maxProcesses'      => 16,
    'jobSize'           => 15,
    'typeCoverageLevel' => -1,
    'deadCodeLevel'     => -1,
    'importsRules'      => true,

];
