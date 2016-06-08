<?php
/**
 * Chippyash Digest Authentication Manager
 * 
 * @copyright Ashley Kitson, UK, 2014
 * @license GPL 3.0+
 */
namespace Chippyash\Authentication\Manager\Digest;

use Chippyash\Type\String\StringType;
use Chippyash\Type\Number\IntType;
use Chippyash\Type\BoolType;
use Chippyash\Authentication\Manager\Exceptions\AuthManagerException;

/**
 * Interface for a Digest Collection
 */
interface DigestCollectionInterface
{
    /**
     * Return index into collection for a digest given its uid
     * 
     * @param StringType $uid user id
     * 
     * @return IntType|BoolType
     */
    public function findByUid(StringType $uid);
    
    /**
     * Read the digest into the collection from file
     * 
     * @return BoolType true on success else false
     */
    public function read();
    
    /**
     * Write the collection to file
     * 
     * @return BoolType true on success else false
     */
    public function write();
    
    /**
     * Add a digest line to the collection
     * 
     * @param StringType $uid user id
     * @param StringType $pwd password
     * 
     * @return BoolType true on success else false
     */
    public function add(StringType $uid, StringType $pwd);
    
    /**
     * Get digest item
     * 
     * @param IntType $index
     * 
     * @return array Digest item
     */
    public function get(IntType $index);
    
    /**
     * Delete digest item
     * 
     * @param IntType $index
     * 
     * @return BoolType true on success else false
     */
    public function del(IntType $index);
    
    /**
     * Return the collection item as a raw digest string
     * 
     * @param IntType $index Index into collection
     * 
     * @return StringType
     * 
     * @throws AuthManagerException
     */
    public function asString(IntType $index);
}
