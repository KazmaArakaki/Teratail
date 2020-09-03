<?php
declare(strict_types=1);

namespace App\Test\TestCase;

use App\Application;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\TestSuite\IntegrationTestCase;
use InvalidArgumentException;

class ApplicationTest extends IntegrationTestCase {
  public function testBootstrap() {
    $app = new Application(dirname(dirname(__DIR__)) . '/config');

    $app->bootstrap();

    $plugins = $app->getPlugins();

    $this->assertCount(3, $plugins);
    $this->assertSame('Bake', $plugins->get('Bake')->getName());
    $this->assertSame('DebugKit', $plugins->get('DebugKit')->getName());
    $this->assertSame('Migrations', $plugins->get('Migrations')->getName());
  }

  public function testBootstrapPluginWithoutHalt() {
    $this->expectException(InvalidArgumentException::class);

    $app = $this->getMockBuilder(Application::class)
      ->setConstructorArgs([dirname(dirname(__DIR__)) . '/config'])
      ->onlyMethods(['addPlugin'])
      ->getMock();

    $app->method('addPlugin')
      ->will($this->throwException(new InvalidArgumentException('test exception.')));

    $app->bootstrap();
  }

  public function testMiddleware() {
    $app = new Application(dirname(dirname(__DIR__)) . '/config');

    $middleware = new MiddlewareQueue();
    $middleware = $app->middleware($middleware);

    $this->assertInstanceOf(ErrorHandlerMiddleware::class, $middleware->current());
    $middleware->seek(1);
    $this->assertInstanceOf(AssetMiddleware::class, $middleware->current());
    $middleware->seek(2);
    $this->assertInstanceOf(RoutingMiddleware::class, $middleware->current());
  }
}

