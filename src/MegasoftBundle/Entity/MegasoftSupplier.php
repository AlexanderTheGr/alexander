<?php

namespace MegasoftBundle\Entity;

/**
 * MegasoftSupplier
 */
class MegasoftSupplier {

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $title;

    /**
     * @var integer
     */
    private $id;

    /**
     * Set code
     *
     * @param string $code
     *
     * @return MegasoftSupplier
     */
    public function setCode($code) {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return MegasoftSupplier
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

}
