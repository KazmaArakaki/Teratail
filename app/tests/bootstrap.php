<?php
declare(strict_types=1);

use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/config/bootstrap.php';

$_SERVER['PHP_SELF'] = '/';

Configure::write('App.fullBaseUrl', 'http://localhost');

ConnectionManager::setConfig('test_debug_kit', [
  'className' => 'Cake\Database\Connection',
  'driver' => 'Cake\Database\Driver\Sqlite',
  'database' => TMP . 'debug_kit.sqlite',
  'encoding' => 'utf8',
  'cacheMetadata' => true,
  'quoteIdentifiers' => false,
]);

ConnectionManager::alias('test_debug_kit', 'debug_kit');

session_id('cli');

