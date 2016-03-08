<?php

namespace AdminBundle\Entity;

/**
 * Account
 */
class Account
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var integer
     */
    private $store;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $dbname;

    /**
     * @var string
     */
    private $dbuser;

    /**
     * @var string
     */
    private $dbpass;

    /**
     * @var string
     */
    private $appkey;

    /**
     * @var \DateTime
     */
    private $ts;

    /**
     * @var string
     */
    private $status = 'active';

    /**
     * @var integer
     */
    private $actioneer;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $modified;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Account
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Account
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Account
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Account
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set store
     *
     * @param integer $store
     *
     * @return Account
     */
    public function setStore($store)
    {
        $this->store = $store;

        return $this;
    }

    /**
     * Get store
     *
     * @return integer
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Account
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set dbname
     *
     * @param string $dbname
     *
     * @return Account
     */
    public function setDbname($dbname)
    {
        $this->dbname = $dbname;

        return $this;
    }

    /**
     * Get dbname
     *
     * @return string
     */
    public function getDbname()
    {
        return $this->dbname;
    }

    /**
     * Set dbuser
     *
     * @param string $dbuser
     *
     * @return Account
     */
    public function setDbuser($dbuser)
    {
        $this->dbuser = $dbuser;

        return $this;
    }

    /**
     * Get dbuser
     *
     * @return string
     */
    public function getDbuser()
    {
        return $this->dbuser;
    }

    /**
     * Set dbpass
     *
     * @param string $dbpass
     *
     * @return Account
     */
    public function setDbpass($dbpass)
    {
        $this->dbpass = $dbpass;

        return $this;
    }

    /**
     * Get dbpass
     *
     * @return string
     */
    public function getDbpass()
    {
        return $this->dbpass;
    }

    /**
     * Set appkey
     *
     * @param string $appkey
     *
     * @return Account
     */
    public function setAppkey($appkey)
    {
        $this->appkey = $appkey;

        return $this;
    }

    /**
     * Get appkey
     *
     * @return string
     */
    public function getAppkey()
    {
        return $this->appkey;
    }

    /**
     * Set ts
     *
     * @param \DateTime $ts
     *
     * @return Account
     */
    public function setTs($ts)
    {
        $this->ts = $ts;

        return $this;
    }

    /**
     * Get ts
     *
     * @return \DateTime
     */
    public function getTs()
    {
        return $this->ts;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Account
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set actioneer
     *
     * @param integer $actioneer
     *
     * @return Account
     */
    public function setActioneer($actioneer)
    {
        $this->actioneer = $actioneer;

        return $this;
    }

    /**
     * Get actioneer
     *
     * @return integer
     */
    public function getActioneer()
    {
        return $this->actioneer;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Account
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     *
     * @return Account
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}

