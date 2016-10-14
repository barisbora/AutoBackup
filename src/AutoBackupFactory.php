<?php namespace barisbora\autobackup;


class AutoBackupFactory
{

    protected $config;

    protected $token;
    protected $apiUrl;
    protected $downloadUrl;

    /**
     * @param $config
     */
    public function __construct ( $config )
    {

        $this->config = $config;

    }

    public function baslat ()
    {

        $backBlaze = BackBlaze::connect( $this->config[ 'account_id' ], $this->config[ 'application_key' ], $this->config[ 'bucket_id' ] )
            ->authorize()
            ->upload( public_path('aa.rtf'), public_path('robots.txt') );

        dd($backBlaze);

    }

}
