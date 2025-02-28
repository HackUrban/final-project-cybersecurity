<?php

namespace App\Logging;

use Monolog\Processor\ProcessorInterface;

class CustomProcessor1 implements ProcessorInterface
{
    public function __invoke(array $record)
    {
        $record['extra']['ip'] = request()->ip();
        $record['extra']['url'] = request()->fullUrl();
        $record['extra']['user_agent'] = request()->header('User-Agent');
        $record['extra']['user'] = auth()->user();
        $record['extra']['timestamp'] = date('Y-m-d H:i:s');
        $record['extra']['log_level'] = $record['level_name'];



        return $record;
    }
}