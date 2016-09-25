<?php namespace barisbora\autobackup\Facades;

use Illuminate\Support\Facades\Facade;

class AutoBackup extends Facade
{

    protected static function getFacadeAccessor ()
    {
        return 'AutoBackup';
    }

}
