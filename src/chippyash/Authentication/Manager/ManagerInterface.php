<?php
/*
 * Authentication Manager
 * 
 * @copyright Ashley Kitson, UK, 2014
 * @license GPL 3.0+
 */
namespace chippyash\Authentication\Manager;

use chippyash\Type\String\StringType;

/**
 * Interface for an authentication manager
 * Basic CRUD functionality for managing authentication identities within
 * a target auth paradigm
 * 
 */
interface ManagerInterface {
    
    /**
     * Create a new identity in the target system
     * 
     * @param StringType $uid
     * @param StringType $pwd
     * 
     * @return boolean True if created else false
     */
    public function create(StringType $uid, StringType $pwd);

    /**
     * Return raw record from target system
     * 
     * @param StringType $uid
     * 
     * @return mixed Dependent on target system
     */
    public function read(StringType $uid);
    
    /**
     * Update the password for the identity given the uid
     * 
     * @param StringType $uid
     * @param StringType $pwd
     * 
     * @return boolean True if updated else false
     */
    public function update(StringType $uid, StringType $pwd);
    
    /**
     * Delete the identity given the uid
     * 
     * @param StringType $uid
     * 
     * @return boolean True if deleted else false
     */
    public function delete(StringType $uid);
    
    /**
     * Does digest have identity specified by uid
     * 
     * @param StringType $uid
     * 
     * @return boolean True if entry exists else false
     */
    public function has(StringType $uid);
}
