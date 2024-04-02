<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Vanta\Integration\Rector\GitlabOutputFormatter;
use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\ChangesReporting\Contract\Output\OutputFormatterInterface;

$configSets = file_exists(__DIR__ . '/rector.rules.php') ? include __DIR__ . '/rector.rules.php' : [];

$rules = $configSets['rules'] ?? [];
$sets = $configSets['sets'] ?? [];
$excludes = $configSets['excludes'] ?? [];
$timeout = $configSets['timeout'] ?? 180;
$maxProcesses = $configSets['maxProcesses'] ?? 16;
$jobSize = $configSets['jobSize']  ?? 15;
$typeCoverageLevel = $configSets['typeCoverageLevel'] ?? 0;
$deadCodeLevel = $configSets['deadCodeLevel'] ?? 0;
$importsRules = $configSets['importsRules'] ?? false;

$paths = $configSets['paths'] ?? [
    __DIR__ . '/app',
    __DIR__ . '/bootstrap',
    __DIR__ . '/config',
    __DIR__ . '/database',
    __DIR__ . '/public',
    __DIR__ . '/resources',
    __DIR__ . '/routes',
    __DIR__ . '/tests',
];

$rectorConfig = RectorConfig::configure()
    ->withPaths($paths)
    ->withCache(
        cacheClass: FileCacheStorage::class,
        cacheDirectory: 'var'
    )
    ->withRules($rules)
    ->withSets($sets)
    ->withSkip($excludes)
    ->registerService(GitlabOutputFormatter::class, 'gitlab', OutputFormatterInterface::class);

    // ->withTypeCoverageLevel($typeCoverageLevel)
    // ->withDeadCodeLevel($deadCodeLevel);

if ($typeCoverageLevel >= 0) {
    $rectorConfig->withTypeCoverageLevel($typeCoverageLevel);
}
if ($deadCodeLevel >= 0) {
    $rectorConfig->withDeadCodeLevel($deadCodeLevel);
}
if ($importsRules) {
    $rectorConfig->withImportNames(
        importNames         :  true,
        importDocBlockNames :  true,
        importShortClasses  : true,
        removeUnusedImports :  true
    );
}

if ($maxProcesses === 1) {
    $rectorConfig->withoutParallel();
} else {
    $rectorConfig->withParallel($timeout, $maxProcesses, $jobSize);
}

return $rectorConfig;
