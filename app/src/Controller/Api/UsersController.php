<?php
declare(strict_types=1);

namespace App\Controller\Api;

use Cake\Log\Log;

class UsersController extends ApiController {
  public function create() {
    Log::debug(var_export([
      'request_data' => $this->request->getData(),
    ], true));

    $success = true;

    $this->set(compact([
      'success',
    ]));

    $this->set('_serialize', [
      'success',
    ]);
  }
}


