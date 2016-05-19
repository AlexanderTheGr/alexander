<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

use AppBundle\Entity\Entity;
/**
 * User
 *
 * @ORM\Table(name="user", indexes={@ORM\Index(name="user_id", columns={"actioneer"})})
 * @ORM\Entity
 */
class User extends Entity implements UserInterface, \Serializable {

    private $repository = 'AppBundle:User';

    
    
    private $types = array();
    var $repositories = array();

    public function __construct() {
        $this->repositories['softoneStore'] = 'SoftoneBundle:Store';
        $this->types['softoneStore'] = 'object';
        $this->softoneStore = new \SoftoneBundle\Entity\Store;
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getField($field) {
        return $this->$field;
    }

    public function setField($field, $val) {
        $this->$field = $val;
        return $val;
    }

    public function getRepository() {
        return $this->repository;
    }
    public function getRepositories($repo) {
        $this->repositories['softoneStore'] = 'SoftoneBundle:Store';
        return  $this->repositories[$repo];
    }
    public function gettype($field) {
        $this->types['softoneStore'] = 'object';
        if (@$this->types[$field] != '') {
            return @$this->types[$field];
        }
        if (gettype($field) != NULL) {
            return gettype($this->$field);
        }
        return 'string';
    }    


    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=45, nullable=true)
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=45, nullable=true)
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=80, nullable=true)
     */
    protected $password;

    /**
     * @var integer
     *
     * @ORM\Column(name="store", type="integer", nullable=false)
     */
    protected $store;

    /**
     * @var string
     *
     * @ORM\Column(name="key", type="string", length=50, nullable=true)
     */
    protected $key;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=255, nullable=true)
     */
    protected $role;

    /**
     * @var string
     *
     * @ORM\Column(name="appkey", type="string", length=255, nullable=false)
     */
    protected $appkey;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ts", type="datetime", nullable=false)
     */
    protected $ts = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=false)
     */
    protected $status = 'active';

    /**
     * @var integer
     *
     * @ORM\Column(name="actioneer", type="integer", nullable=true)
     */
    protected $actioneer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    protected $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetime", nullable=false)
     */
    protected $modified;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    var $id;

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username) {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set store
     *
     * @param integer $store
     *
     * @return User
     */
    public function setStore($store) {
        $this->store = $store;

        return $this;
    }

    /**
     * Get store
     *
     * @return integer
     */
    public function getStore() {
        return $this->store;
    }

    /**
     * Set key
     *
     * @param string $key
     *
     * @return User
     */
    public function setKey($key) {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getKey() {
        return $this->key;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return User
     */
    public function setRole($role) {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole() {
        return $this->role;
    }

    /**
     * Set appkey
     *
     * @param string $appkey
     *
     * @return User
     */
    public function setAppkey($appkey) {
        $this->appkey = $appkey;

        return $this;
    }

    /**
     * Get appkey
     *
     * @return string
     */
    public function getAppkey() {
        return $this->appkey;
    }

    /**
     * Set ts
     *
     * @param \DateTime $ts
     *
     * @return User
     */
    public function setTs($ts) {
        $this->ts = $ts;

        return $this;
    }

    /**
     * Get ts
     *
     * @return \DateTime
     */
    public function getTs() {
        return $this->ts;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return User
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set actioneer
     *
     * @param integer $actioneer
     *
     * @return User
     */
    public function setActioneer($actioneer) {
        $this->actioneer = $actioneer;

        return $this;
    }

    /**
     * Get actioneer
     *
     * @return integer
     */
    public function getActioneer() {
        return $this->actioneer;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return User
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     *
     * @return User
     */
    public function setModified($modified) {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified() {
        return $this->modified;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    public function getSalt() {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getRoles() {
        return array('ROLE_USER');
    }

    public function eraseCredentials() {
        
    }

    /** @see \Serializable::serialize() */
    public function serialize() {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
                // see section on salt below
                // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized) {
        list (
                $this->id,
                $this->username,
                $this->password,
                // see section on salt below
                // $this->salt
                ) = unserialize($serialized);
    }

    /**
     * @var \SoftoneBundle\Entity\Store
     */
    protected $softoneStore;


    /**
     * Set softoneStore
     *
     * @param \SoftoneBundle\Entity\Store $softoneStore
     *
     * @return User
     */
    public function setSoftoneStore(\SoftoneBundle\Entity\Store $softoneStore = null)
    {
        $this->softoneStore = $softoneStore;

        return $this;
    }

    /**
     * Get softoneStore
     *
     * @return \SoftoneBundle\Entity\Store
     */
    public function getSoftoneStore()
    {
        return $this->softoneStore;
    }
}
