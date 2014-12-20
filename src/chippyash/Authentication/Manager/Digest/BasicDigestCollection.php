<?php
/**
 * Chippyash Digest Authentication Manager
 * 
 * @copyright Ashley Kitson, UK, 2014
 * @license GPL 3.0+
 */
namespace chippyash\Authentication\Manager\Digest;

use chippyash\Authentication\Manager\Digest\AbstractDigestCollection;
use chippyash\Authentication\Manager\Encoder\DigestEncoderInterface;
use chippyash\Authentication\Manager\Traits\RealmHandler;
use chippyash\Authentication\Manager\Exceptions\AuthManagerException;
use chippyash\Type\String\StringType;
use chippyash\Type\Number\IntType;
use chippyash\Type\BoolType;

/**
 * A collection of Basic Digests
 */
class BasicDigestCollection extends AbstractDigestCollection
{
    use RealmHandler;
    
    const SEP_DIGEST = ':';
    const ERR_NO_DIGEST_TPL = 'Digest entry (%d) does not exist';
    
    /**
     * Digest encoder
     * @var DigestEncoderInterface
     */
    protected $encoder;
    
    /**
     * Constructor
     * 
     * @param DigestEncoderInterface $encoder
     * @param StringType $fileName
     * @param array $digests Digests to add to collection
     */
    public function __construct(DigestEncoderInterface $encoder, StringType $fileName, array $digests = [])
    {
        $this->setEncoder($encoder);
        parent::__construct($fileName, $digests);
    }
    
    /**
     * Return index into collection for a digest given its uid
     * Side effect: will rewind collection to start
     * 
     * @param StringType $uid user id
     * 
     * @return IntType|false
     */
    public function findByUid(StringType $uid)
    {
        $index = false;
        foreach($this->collection as $key => $digest) {
            if ($digest[0] == $uid() && $digest[1] == $this->realm()) {
                $index = $key;
                break;
            }
        }
        
        if ($index === false) {
            return New BoolType(false);
        } else {
            return new IntType($index);
        }
    }
    
    /**
     * Read the digest into the collection from file
     * 
     * @return BoolType true on success else false
     */
    public function read()
    {
        try {
            $fh = fopen($this->fileName->get(), 'r');
            $ret = [];
            while (!feof($fh)) {
                $csv = fgetcsv($fh, 0, self::SEP_DIGEST);
                if ($csv !== false) {
                    $ret[] = $csv;
                }
            }
            fclose($fh);
            $this->collection = $ret;
            
            return new BoolType(true);
        } catch (\Exception $e) {
            return new BoolType(false);
        }
    }
    
    /**
     * Write the collection to file
     * 
     * @return BoolType true on success else false
     */
    public function write()
    {
        $output = '';
        foreach($this->collection as $digest) {
            $output .= $this->raw($digest) . PHP_EOL;
        }
        $ret = file_put_contents($this->fileName->get(), $output, $this->writeOptions);
        if ($ret === false) {
            return new BoolType(false);
        }
        
        return new BoolType(strlen($output) == $ret);
    }
    
    /**
     * Add a digest line to the collection
     * 
     * @param StringType $uid user id
     * @param StringType $pwd password
     * 
     * @return BoolType true on success else false
     */
    public function add(StringType $uid, StringType $pwd)
    {
        try {
            $digest = $this->encoder->encode($uid, $pwd);
            $this->collection[] = explode(self::SEP_DIGEST, $digest());
            
            return new BoolType(true);
            
        } catch (\Exception $e) {
            
            return new BoolType(false);
        }
    }
    
    /**
     * Return the collection item as a raw digest string
     * 
     * @param IntType $index Index into collection
     * 
     * @return StringType
     * 
     * @throws AuthManagerException
     */
    public function asString(IntType $index)
    {
        if (!isset($this->collection[$index()])) {
            throw new AuthManagerException(sprintf(self::ERR_NO_DIGEST_TPL, $index()));
        }
        return new StringType($this->raw($this->collection[$index()]));
    }
    
    /**
     * Convert internal representation to external representation
     * @param array $digest
     * @return string
     */
    protected function raw(array $digest)
    {
        return implode(self::SEP_DIGEST, $digest);
    }
}
