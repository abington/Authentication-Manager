<?php
/**
 * Chippyash Digest Authentication Manager
 * 
 * @copyright Ashley Kitson, UK, 2014
 * @license GPL 3.0+
 */
namespace chippyash\Authentication\Manager\Encoder;

use chippyash\Authentication\Manager\Encoder\DigestEncoderInterface;
use chippyash\Authentication\Manager\Traits\RealmHandler;
use chippyash\Type\String\StringType;

/**
 * Encoding for Basic Digest
 */
class BasicEncoder implements DigestEncoderInterface
{
    use RealmHandler;

    /**
     * A digest format string uid:realm:md5(uid:realm:pwd)
     * @var string
     */
    protected $digestTemplate = '%s:%s:%s';
    
    /**
     * Return encoded digest
     * 
     * @param StringType $uid
     * @param StringType $pwd
     * 
     * @return StringType
     */
    public function encode(StringType $uid, StringType $pwd)
    {
        $encoded = md5(sprintf($this->digestTemplate, $uid, $this->realm(), $pwd));
        return new StringType(sprintf($this->digestTemplate, $uid, $this->realm(), $encoded));
    }
}
