<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Log\Log;
use Psy\Shell as PsyShell;

class ConsoleCommand extends Command {
  public function execute(Arguments $args, ConsoleIo $io) {
    if (!class_exists('Psy\Shell')) {
      $io->err('<error>Unable to load Psy\Shell.</error>');
      $io->err('');
      $io->err('Make sure you have installed psysh as a dependency,');
      $io->err('and that Psy\Shell is registered in your autoloader.');
      $io->err('');
      $io->err('If you are using composer run');
      $io->err('');
      $io->err('<info>$ php composer.phar require --dev psy/psysh</info>');
      $io->err('');

      return static::CODE_ERROR;
    }

    $io->out('You can exit with <info>`CTRL-C`</info> or <info>`exit`</info>');
    $io->out('');

    Log::drop('debug');
    Log::drop('error');

    $io->setLoggers(false);

    restore_error_handler();

    restore_exception_handler();

    $psy = new PsyShell();
    $psy->run();
  }

  public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser {
    $parser->setDescription(
      'This shell provides a REPL that you can use to interact with ' .
      'your application in a command line designed to run PHP code. ' .
      'You can use it to run adhoc queries with your models, or ' .
      'explore the features of CakePHP and your application.' .
      "\n\n" .
      'You will need to have psysh installed for this Shell to work.'
    );

    return $parser;
  }
}

