<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sys
 *
 * @ORM\Table(name="sys")
 * @ORM\Entity
 */
class Entity {

    private $types = array();
    private $repositories = array();

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

    public function gettype($field) {
        if (@$this->types[$field] != '') {
            return @$this->types[$field];
        }
        if (gettype($field) != NULL) {
            return gettype($this->$field);
        }
        return 'string';
    }

    function getSetting($path) {
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }       
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $repository = $em->getRepository('AppBundle:Setting');
        $setting = $repository->findOneBy(
                array('path' => $path)
        );
        return $setting->getValue();
    }

}
