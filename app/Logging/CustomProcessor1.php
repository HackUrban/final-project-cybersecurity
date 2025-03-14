<?php

namespace App\Logging;

use Monolog\Processor\ProcessorInterface;
use Illuminate\Support\Facades\Auth;

class CustomProcessor1 implements ProcessorInterface
{
    public function __invoke(array $record)
    {
        $record['extra']['ip'] = request()->ip();
        $record['extra']['url'] = request()->fullUrl();
        $record['extra']['email'] = Auth::check() ? Auth::user()->email : 'guest';
        $record['extra']['timestamp'] = now()->toDateTimeString();

        return $record; 
    } 
} 