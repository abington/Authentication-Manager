<?php
/**
 * Chippyash Digest Authentication Manager
 * 
 * @copyright Ashley Kitson, UK, 2014
 * @license GPL 3.0+
 */
namespace Chippyash\Authentication\Manager\Digest;

use Chippyash\Authentication\Manager\Encoder\DigestEncoderInterface;
use Chippyash\Authentication\Manager\Exceptions\AuthManagerException;
use Chippyash\Type\String\StringType;
use Chippyash\Type\Number\IntType;
use Chippyash\Type\BoolType;

/**
 * A collection of Digests
 */
abstract class AbstractDigestCollection implements DigestCollectionInterface, \Countable
{
    const ERR_NO_DIGEST_TPL = 'No digest at index %d';
    
    /**
     * File write options
     * @see \file_put_contents
     * 
     * @var int
     */
    protected $writeOptions = LOCK_EX;
    
    /**
     * Name of file that digest collection is stored in
     * 
     * @var StringType
     */
    protected $fileName;
    
    /**
     * Digest encoder
     * @var DigestEncoderInterface
     */
    protected $encoder;
    
    /**
     * Collection of digest items
     * 
     * @var array
     */
    protected $collection = [];

    /**
     * Constructor.
     * 
     * @param StringType $fileName
     * @param array $digests
     */
    public function __construct(StringType $fileName, array $digests = [])
    {
        $this->collection = $digests;
        $this->fileName = $fileName;
    }
    
    /**
     * Set file writing options
     * @see \file_put_contents
     * 
     * @param IntType $options file_put_contents options
     * 
     * @return $this
     */
    public function setWriteOptions(IntType $options){
        $this->writeOptions = $options();
        return $this;        
    }   
    
    /**
     * Set the encoder
     * 
     * @param DigestEncoderInterface $encoder
     * @return $this
     */
    public function setEncoder(DigestEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        
        return $this;
    }
    
    /**
     * @interface \Countable
     * 
     * @return int
     */
    public function count()
    {
        return count($this->collection);
    }
    
    /**
     * Get digest item
     * 
     * @param IntType $index
     * 
     * @return array Digest item
     * 
     * @throws AuthManagerException
     */
    public function get(IntType $index)
    {
        if (!isset($this->collection[$index()])) {
            throw new AuthManagerException(sprintf(self::ERR_NO_DIGEST_TPL, $index()));
        }
        
        return $this->collection[$index()];
    }
    
    /**
     * Delete digest item
     * 
     * @param IntType $index
     * 
     * @return BoolType true on success else false
     */
    public function del(IntType $index)
    {
        if (!isset($this->collection[$index()])) {
            return new BoolType(false);
        }
        
        unset($this->collection[$index()]);
        $this->collection = array_values($this->collection);
        
        return new BoolType(true);
    }

    /**
     * Return index into collection for a digest given its uid
     * 
     * @param StringType $uid user id
     * 
     * @return IntType|false
     */
    abstract public function findByUid(StringType $uid);
    
    /**
     * Read the digest into the collection from file
     * 
     * @return BoolType true on success else false
     */
    abstract public function read();
    
    /**
     * Write the collection to file
     * 
     * @return BoolType true on success else false
     */
    abstract public function write();
    
    /**
     * Add a digest line to the collection
     * 
     * @param StringType $uid user id
     * @param StringType $pwd password
     * 
     * @return BoolType true on success else false
     */
    abstract public function add(StringType $uid, StringType $pwd);
    
    /**
     * Return the collection item as a raw digest string
     * 
     * @param IntType $index Index into collection
     * 
     * @return StringType
     */
    abstract public function asString(IntType $index);
}
