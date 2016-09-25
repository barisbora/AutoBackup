<?php namespace barisbora\autobackup;


class AutoBackupFactory
{

    protected $config;

    /**
     * @param $config
     */
    public function __construct ( $config )
    {

        $this->config = $config;

    }

    public function baslat ()
    {
        echo 'aaa';

    }

}
