<?php

namespace App;

use App\src\Core\Setting;

require_once __DIR__ . '/vendor/autoload.php';

$container = require_once __DIR__ . '/config/App.php';

require_once __DIR__ . '/src/Core/web.php';

$setting = new Setting();