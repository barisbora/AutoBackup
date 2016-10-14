<?php namespace barisbora\autobackup\Accessory;


class Authorize
{

    private $apiURL;
    private $authorizationToken;
    private $downloadUrl;
    private $minimumPartSize;
    private $uploadURL;

    public static function create ()
    {
        return new static();
    }

    /**
     * @return string
     */
    public function getApiURL ()
    {
        return $this->apiURL;
    }

    /**
     * @param string $apiURL
     *
     * @return $this
     */
    public function setApiURL ( $apiURL )
    {
        $this->apiURL = $apiURL;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthorizationToken ()
    {
        return $this->authorizationToken;
    }

    /**
     * @param string $authorizationToken
     *
     * @return $this
     */
    public function setAuthorizationToken ( $authorizationToken )
    {
        $this->authorizationToken = $authorizationToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getMinimumPartSize ()
    {
        return $this->minimumPartSize;
    }

    /**
     * @param string $minimumPartSize
     *
     * @return $this
     */
    public function setMinimumPartSize ( $minimumPartSize )
    {
        $this->minimumPartSize = $minimumPartSize;

        return $this;
    }

    /**
     * @return string
     */
    public function getDownloadUrl ()
    {
        return $this->downloadUrl;
    }

    /**
     * @param string $downloadUrl
     *
     * @return $this
     */
    public function setDownloadUrl ( $downloadUrl )
    {
        $this->downloadUrl = $downloadUrl;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUploadURL ()
    {
        return $this->uploadURL;
    }

    /**
     * @param string $uploadURL
     *
     * @return $this
     */
    public function setUploadURL ( $uploadURL )
    {
        $this->uploadURL = $uploadURL;

        return $this;
    }


}