#! /usr/bin/env php
<?php

/**
 * CLI command to run app commands.
 */

use function Bead\Helpers\Str\camelToKebab;
use function Bead\Helpers\Str\kebabToCamel;

require_once __DIR__ . "/../bootstrap.php";

const ExitOk = 0;
const ErrNoCommand = -1;
const ErrUnknownCommand = -2;

/** Show help on how to invoke this command. */
function showUsage(string $exe): void
{
    echo "Run a Bead App CLI command\n";
    echo "Usage: {$exe} <command> [<arg> ...]\n";
    echo "\n";
    echo "Commands:\n";
    listCommands();
}

/** Fetch a list of the available commands. */
function availableCommands(): array
{
    $commands = [];

    foreach (new FilesystemIterator(__DIR__ . "/../app/Commands") as $command) {
        if (!$command->isFile() || "php" !== $command->getExtension()) {
            continue;
        }

        $commands[] =  camelToKebab($command->getBasename(".php"));
    }

    return $commands;
}

/** Output a list of the available commands. */
function listCommands(): void
{
    foreach (availableCommands() as $command) {
        echo "   {$command}\n";
    }
}

$command = $argv[1] ?? null;

if (!isset($command)) {
    showUsage($argv[0]);
    return ErrNoCommand;
}

if ("--list" === $command) {
    listCommands();
    return ExitOk;
}

$className = ucfirst(kebabToCamel($command));
$commandClass = "\\App\\Commands\\{$className}";

if (!class_exists($commandClass)) {
    echo "The command {$command} [{$commandClass}] is not recognised.\nAvailable commands:\n";
    listCommands();
    return ErrUnknownCommand;
}

array_shift($argv);
exit ((new $commandClass($argv))->exec());
