<?php namespace barisbora\AutoBackup;

use Illuminate\Support\ServiceProvider;

class AutoBackupServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    public function boot ()
    {

        dd( 'a' );

        $this->publishes( [
            __DIR__ . '/config/backup.php' => config_path( 'backup.php' ),
        ] );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register ()
    {

        $this->app[ 'AutoBackup' ] = $this->app->share( function ( $app )
        {

            dd( 'b' );

            $config = config( 'backup' );

            if ( ! $config )
            {
                throw new \RunTimeException( 'AutoBackup configuration not found. Please run `php artisan vendor:publish`' );
            }

            return new AutoBackupFactory( $config );

        } );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides ()
    {
        return [ 'AutoBackup' ];
    }

}
