<?php namespace barisbora\autobackup\Accessory;


class File
{

    private $size;
    private $mime;
    private $SHA;
    private $target;
    private $fileId;

    public static function prepare ( $target )
    {
        return new static( $target );
    }

    private function __construct ( $target )
    {
        $this->target = $target;
        $this->SHA = sha1_file( $target );
        $this->mime = mime_content_type( $target );
        $this->size = filesize( $target );
    }

    public function getFile ()
    {

        return fread( fopen( $this->target, 'r' ), $this->getSize() );

    }

    /**
     * @return int
     */
    public function getSize ()
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getMime ()
    {
        return $this->mime;
    }

    /**
     * @return string
     */
    public function getSHA ()
    {
        return $this->SHA;
    }

    /**
     * @return string
     */
    public function getFileName ()
    {
        return basename( $this->target );

    }

    /**
     * @return string
     */
    public function getFileId ()
    {
        return $this->fileId;
    }

    /**
     * @param string $fileId
     *
     * @return $this
     */
    public function setFileId ( $fileId )
    {
        $this->fileId = $fileId;

        return $this;
    }


}