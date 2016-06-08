<?php
/**
 * Chippyash Digest Authentication Manager
 * 
 * @copyright Ashley Kitson, UK, 2014
 * @license GPL 3.0+
 */
namespace Chippyash\Authentication\Manager\Traits;

use Chippyash\Authentication\Manager\Exceptions\AuthManagerException;
use Chippyash\Type\String\StringType;
use Chippyash\Authentication\Manager\Digest\BasicDigestCollection;

/**
 * Setter and Getter for a Realm
 */
trait RealmHandler
{
    /**
     * Digest Realm
     * @var StringType
     */
    protected $realm;
    
    /**
     * Set the digest realm
     * 
     * @param StringType $realm
     * 
     * @return BasicDigestCollection
     */
    public function setRealm(StringType $realm)
    {
        $this->realm = $realm;
        
        return $this;
    }
    
    /**
     * Return the digest realm
     * 
     * @return string
     * 
     * @throws AuthManagerException
     */
    protected function realm()
    {
        if (is_null($this->realm)) {
            throw new AuthManagerException('No Realm set');
        }
        
        return $this->realm->get();
    }
}
