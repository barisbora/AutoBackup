<?php namespace barisbora\AutoBackup\Facades;

use Illuminate\Support\Facades\Facade;

class AutoBackup extends Facade
{

    protected static function getFacadeAccessor ()
    {
        return 'AutoBackup';
    }

}
