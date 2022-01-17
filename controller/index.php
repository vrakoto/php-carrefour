<?php
switch ($role) {
   case 'CLIENT':
      require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'roles' . DIRECTORY_SEPARATOR . 'client' . DIRECTORY_SEPARATOR . 'Client.php';
      $client = new Client($sid);
      require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'roles' . DIRECTORY_SEPARATOR . 'client' . DIRECTORY_SEPARATOR . 'index.php';
   break;

   case 'ADMIN':
      require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'roles' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'Admin.php';
      $client = new Admin($sid);
      require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'roles' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'index.php';
   break;
}