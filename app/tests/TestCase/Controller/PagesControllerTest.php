<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class PagesControllerTest extends TestCase {
  use IntegrationTestTrait;

  public function testMultipleGet() {
    $this->get('/');

    $this->assertResponseOk();

    $this->get('/');

    $this->assertResponseOk();
  }

  public function testDisplay() {
    $this->get('/pages/home');

    $this->assertResponseOk();
    $this->assertResponseContains('CakePHP');
    $this->assertResponseContains('<html>');
  }

  public function testMissingTemplate() {
    Configure::write('debug', false);

    $this->get('/pages/not_existing');

    $this->assertResponseError();
    $this->assertResponseContains('Error');
  }

  public function testMissingTemplateInDebug() {
    Configure::write('debug', true);

    $this->get('/pages/not_existing');

    $this->assertResponseFailure();
    $this->assertResponseContains('Missing Template');
    $this->assertResponseContains('Stacktrace');
    $this->assertResponseContains('not_existing.php');
  }

  public function testDirectoryTraversalProtection() {
    $this->get('/pages/../Layout/ajax');

    $this->assertResponseCode(403);
    $this->assertResponseContains('Forbidden');
  }

  public function testCsrfAppliedError() {
    $this->post('/pages/home', ['hello' => 'world']);

    $this->assertResponseCode(403);
    $this->assertResponseContains('CSRF');
  }

  public function testCsrfAppliedOk() {
    $this->enableCsrfToken();

    $this->post('/pages/home', ['hello' => 'world']);

    $this->assertResponseCode(200);
    $this->assertResponseContains('CakePHP');
  }
}

