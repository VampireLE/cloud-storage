<?php

namespace App\public;

use App\src\Core\Setting;

require_once (__DIR__ . '/../vendor/autoload.php');

$container = require_once __DIR__ . '/../src/Core/ServiceRegistry.php';

require_once __DIR__ . '/../routes/web.php';

$setting = new Setting();