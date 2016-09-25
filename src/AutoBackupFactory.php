<?php namespace barisbora\AutoBackup;


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

    public function start ()
    {
        echo 'aaa';

        return $this;
    }

}
