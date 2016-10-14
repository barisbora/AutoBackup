<?php namespace barisbora\autobackup;


use barisbora\autobackup\Accessory\Authorize;
use barisbora\autobackup\Accessory\File;
use Exception;

class BackBlaze
{

    private $applicationId;
    private $secretKey;
    private $bucketId;
    private $authorization;

    /**
     * @param string $applicationId
     * @param string $secretKey
     *
     * @param $bucketId
     *
     * @return BackBlaze
     */
    public static function connect ( $applicationId, $secretKey, $bucketId )
    {
        return new static( $applicationId, $secretKey, $bucketId );
    }


    private function __construct ( $applicationId, $secretKey, $bucketId )
    {
        $this->applicationId = $applicationId;
        $this->secretKey = $secretKey;
        $this->bucketId = $bucketId;
    }

    /**
     * @return Authorize
     */
    private function authorization ()
    {
        return $this->authorization;
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function authorize ()
    {

        $credentials = base64_encode( $this->applicationId . ":" . $this->secretKey );

        $url = "https://api.backblazeb2.com/b2api/v1/b2_authorize_account";

        $curl = curl_init( $url );

        curl_setopt( $curl, CURLOPT_HTTPHEADER, [
            "Accept: application/json",
            "Authorization: Basic " . $credentials,
        ] );


        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true ); // Receive server response

        $response = curl_exec( $curl );
        $getInfo = curl_getinfo( $curl );

        curl_close( $curl );

        $this->checkStatus( $getInfo, $response );

        $response = json_decode( $response );

        $this->authorization = Authorize::create()
            ->setApiURL( $response->apiUrl )
            ->setAuthorizationToken( $response->authorizationToken )
            ->setDownloadUrl( $response->downloadUrl )
            ->setMinimumPartSize( $response->minimumPartSize );

        return $this;

    }

    /**
     * @return $this
     * @throws Exception
     */
    protected function getUploadURL ()
    {

        $curl = curl_init( $this->authorization()->getApiURL() . "/b2api/v1/b2_get_upload_url" );
        curl_setopt( $curl, CURLOPT_POSTFIELDS, json_encode( [ 'bucketId' => $this->bucketId ] ) );
        curl_setopt( $curl, CURLOPT_HTTPHEADER, [
            "Authorization: " . $this->authorization()->getAuthorizationToken()
        ] );
        curl_setopt( $curl, CURLOPT_POST, true );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        $response = curl_exec( $curl );
        $getInfo = curl_getinfo( $curl );
        curl_close( $curl );

        $this->checkStatus( $getInfo, $response );

        $response = json_decode( $response );

        $this->authorization()->setAuthorizationToken( $response->authorizationToken );
        $this->authorization()->setUploadURL( $response->uploadUrl );

        return $this;

    }

    /**
     * @param array ...$files
     *
     * @return array
     * @throws Exception
     */
    public function upload ( ...$files )
    {


        if ( ! $this->authorization()->getUploadURL() ) $this->getUploadURL();

        $output = [ ];

        foreach ( $files as $file )
        {

            if ( ! file_exists( $file ) ) throw new Exception( 'Given file not found' );

            $file = File::prepare( $file );

            $curl = curl_init( $this->authorization()->getUploadURL() );
            curl_setopt( $curl, CURLOPT_POSTFIELDS, $file->getFile() );
            curl_setopt( $curl, CURLOPT_HTTPHEADER, [
                'Authorization: ' . $this->authorization()->getAuthorizationToken(),
                'X-Bz-File-Name: ' . $file->getFileName(),
                'Content-Type: ' . $file->getMime(),
                'X-Bz-Content-Sha1: ' . $file->getSHA(),
            ] );

            curl_setopt( $curl, CURLOPT_POST, true );
            curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
            $response = curl_exec( $curl );
            $getInfo = curl_getinfo( $curl );
            curl_close( $curl );

            $this->checkStatus( $getInfo, $response );

            $response = json_decode( $response );

            $file->setFileId( $response->fileId );

            $output[] = $response->fileName;

        }

        return $output;

    }

    /**
     * @param $getInfo
     * @param $response
     *
     * @throws Exception
     */
    private function checkStatus ( $getInfo, $response )
    {

        if ( $getInfo[ 'http_code' ] != 200 )
        {
            $getInfo = json_decode( $response );
            throw new Exception( $getInfo->code . ': ' . $getInfo->message, $getInfo->status );
        }
    }


}