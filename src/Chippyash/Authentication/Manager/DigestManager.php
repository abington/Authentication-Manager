<?php
/**
 * Chippyash Digest Authentication Manager
 * 
 * @copyright Ashley Kitson, UK, 2014
 * @license GPL 3.0+
 */
namespace Chippyash\Authentication\Manager;

use Chippyash\Authentication\Manager\Exceptions\AuthManagerException;
use Chippyash\Authentication\Manager\Digest\DigestCollectionInterface;
use Chippyash\Type\String\StringType;

/**
 * Manage a Digest file
 * 
 * @link http://framework.zend.com/manual/current/en/modules/zend.authentication.adapter.digest.html
 * @link http://en.wikipedia.org/wiki/Digest_access_authentication
 * @link http://httpd.apache.org/docs/2.2/programs/htdigest.html
 */
class DigestManager implements ManagerInterface
{
    const ERR_UID_EXISTS_TPL = 'Uid: %s already exists';
    const ERR_UID_NOTEXISTS_TPL = 'Uid: %s does not exist';
    const ERR_CANNOT_DEL_DIGEST_TPL = 'Cannot delete digest identified by: %s';

    /**
     * Digest collection
     * @var DigestCollectionInterface
     */
    protected $collection;

    /**
     * Shall we write file after a delete?
     * Set to false on an update()
     * @var boolean
     */
    protected $doDeleteWrite = true;
    
    /**
     * Constructor
     * 
     * @param DigestCollectionInterface $collection
     */
    public function __construct(DigestCollectionInterface $collection)
    {
        $this->collection = $collection;
        $this->init();
    }
    
    /**
     * Add new entry to digest
     * 
     * @param StringType $uid
     * @param StringType $pwd
     * @return Bool True on success else false
     * @throws AuthManagerException
     */
    public function create(StringType $uid, StringType $pwd)
    {
        if ($this->collection->findByUid($uid)->get() !== false) {
            throw new AuthManagerException(sprintf(self::ERR_UID_EXISTS_TPL, $uid));
        }

        return ($this->collection->add($uid, $pwd)->get() && $this->collection->write()->get());
    }

    /**
     * Return raw record from target system
     * 
     * @param StringType $uid
     * 
     * @return String Digest line
     * 
     * @throws AuthManagerException
     */
    public function read(StringType $uid)
    {
        $index = $this->collection->findByUid($uid);
        if ($index() === false) {
            throw new AuthManagerException(sprintf(self::ERR_UID_NOTEXISTS_TPL, $uid));
        }
        
        return $this->collection->asString($index)->get();
    }
    
    /**
     * Change password for user in digest
     * 
     * @param StringType $uid
     * @param StringType $pwd
     * 
     * @return Bool
     * 
     * @throws AuthManagerException
     */
    public function update(StringType $uid, StringType $pwd)
    {
        $this->doDeleteWrite = false;
        if (!$this->delete($uid)) {
            throw new AuthManagerException(sprintf(self::ERR_CANNOT_DEL_DIGEST_TPL, $uid));
        }
        
        return $this->create($uid, $pwd);
    }
    
    /**
     * Delete user from digest
     * 
     * @param StringType $uid
     * 
     * @return Bool true on success else false
     * 
     * @throws AuthManagerException
     */
    public function delete(StringType $uid)
    {
        $index = $this->collection->findByUid($uid);
        if ($index() === false) {
            throw new AuthManagerException(sprintf(self::ERR_UID_NOTEXISTS_TPL, $uid));
        }
        $this->collection->del($index);
                
        if ($this->doDeleteWrite) {
            $ret = $this->collection->write()->get();
        } else {
            $this->doDeleteWrite = true;
            $ret = true;
        }
        
        return $ret;
    }
    
    /**
     * Does digest have identity specified by uid
     * 
     * @param StringType $uid
     * 
     * @return Bool True if entry exists else false
     */
    public function has(StringType $uid)
    {
        $index = $this->collection->findByUid($uid);
        if ($index() === false) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Initialise the manager from source
     * @return $this
     */
    public function init()
    {
        $this->collection->read();
        return $this;
    }
}
