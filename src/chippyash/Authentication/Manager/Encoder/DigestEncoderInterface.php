<?php
/**
 * Chippyash Digest Authentication Manager
 * 
 * @copyright Ashley Kitson, UK, 2014
 * @license GPL 3.0+
 */
namespace chippyash\Authentication\Manager\Encoder;

use chippyash\Type\String\StringType;

/**
 * Interface for a Digest Encoder
 */
interface DigestEncoderInterface
{
    /**
     * Return encoded digest
     * 
     * @param StringType $uid
     * @param StringType $pwd
     * 
     * @return StringType
     */
    public function encode(StringType $uid, StringType $pwd);
}
