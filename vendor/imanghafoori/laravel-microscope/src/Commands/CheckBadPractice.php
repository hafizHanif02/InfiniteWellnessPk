<?php

namespace Imanghafoori\LaravelMicroscope\Commands;

use Illuminate\Console\Command;
use Imanghafoori\LaravelMicroscope\Analyzers\ComposerJson;
use Imanghafoori\LaravelMicroscope\ErrorReporters\ErrorPrinter;
use Imanghafoori\LaravelMicroscope\ErrorTypes\EnvFound;
use Imanghafoori\LaravelMicroscope\FileReaders\FilePath;
use Imanghafoori\LaravelMicroscope\FileReaders\Paths;
use Imanghafoori\LaravelMicroscope\LaravelPaths\LaravelPaths;
use Imanghafoori\LaravelMicroscope\SpyClasses\RoutePaths;
use Imanghafoori\TokenAnalyzer\FunctionCall;
use Imanghafoori\TokenAnalyzer\TokenManager;

class CheckBadPractice extends Command
{
    protected $signature = 'check:bad_practices';

    protected $description = 'Checks for bad practices';

    public function handle()
    {
        event('microscope.start.command');
        $this->info('Checking bad practices...');

        $this->checkPaths(RoutePaths::get());
        $this->checkPaths(Paths::getAbsFilePaths(LaravelPaths::migrationDirs()));
        $this->checkPaths(Paths::getAbsFilePaths(LaravelPaths::factoryDirs()));
        $this->checkPaths(Paths::getAbsFilePaths(LaravelPaths::seedersDir()));
        $this->checkPsr4Classes();

        event('microscope.finished.checks', [$this]);
        $this->info('&It is recommended use env() calls, only and only in config files.');
        $this->info('Otherwise you can NOT cache your config files using "config:cache"');
        $this->info('https://laravel.com/docs/5.5/configuration#configuration-caching');

        return app(ErrorPrinter::class)->hasErrors() ? 1 : 0;
    }

    private function checkForEnv($absPath)
    {
        $tokens = token_get_all(file_get_contents($absPath));

        foreach ($tokens as $i => $token) {
            if ($index = FunctionCall::isGlobalCall('env', $tokens, $i)) {
                if (! $this->isLikelyConfigFile($absPath, $tokens)) {
                    EnvFound::warn($absPath, $tokens[$index][2], $tokens[$index][1]);
                }
            }
        }
    }

    private function checkPaths($paths)
    {
        foreach ($paths as $filePath) {
            $this->checkForEnv($filePath);
        }
    }

    private function checkPsr4Classes()
    {
        $configs = Paths::getAbsFilePaths(
            array_merge([config_path()],
                config('microscope.additional_config_paths', []))
        );

        foreach (ComposerJson::readAutoload() as $psr4) {
            foreach ($psr4 as $dirPath) {
                foreach (FilePath::getAllPhpFiles($dirPath) as $filePath) {
                    if (! in_array($path = $filePath->getRealPath(), $configs)) {
                        $this->checkForEnv($path);
                    }
                }
            }
        }
    }

    private function isLikelyConfigFile($absPath, $tokens)
    {
        [$token] = TokenManager::getNextToken($tokens, 0);

        if ($token[0] === T_NAMESPACE) {
            return false;
        }

        if ($token[0] === T_RETURN && strpos(strtolower($absPath), 'config')) {
            return true;
        }

        return basename($absPath) === 'config.php';
    }
}
