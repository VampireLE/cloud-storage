<?php

namespace App\src\Core;

class Setting
{

    private $configFile;
    public function __construct()
    {
        $this->configFile = require __DIR__ . '/../../config/config.php';
    }

    public function get(string $key)
    {
        $keys = explode('.', $key);
        foreach ($keys as $k) {
            if (isset($this->configFile[$k])) {
                $this->configFile = $this->configFile[$k];
            }
            
        }
        return $this->configFile;
    }
}
