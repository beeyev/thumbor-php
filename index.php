<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

$thumor = new \Beeyev\Thumbor\Thumbor();
$thumor->securityKey('31337');
var_dump($thumor->get('wallhaven-we628p.jpg'));




