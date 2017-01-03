<?php

namespace SoftoneBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main as Main;
use SoftoneBundle\Entity\Softone as Softone;
use SoftoneBundle\Entity\Product as Product;
use SoftoneBundle\Entity\Pcategory as Pcategory;
use SoftoneBundle\Entity\TecdocSupplier as TecdocSupplier;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class SoftoneController extends  Main {

    function retrieve($params=array()) {
        $object = $params["object"];
        $em = $this->getDoctrine()->getManager();
        $fields = $em->getClassMetadata($params["object"])->getFieldNames();
        //print_r($fields);
        
        $itemfield = array();
        $itemfield[] = "M." . $params["softone_table"];
        foreach ($fields as $field) {
            $ffield = " " . $field;
            if (strpos($ffield, $params["softone_object"]) == true) {
                $itemfield[] = "M." . strtoupper(str_replace($params["softone_object"], "", $field));
            }
        }
        foreach ($params["extra"] as $field => $extra) {
            //if (@$data[$extra] AND in_array($field, $fields)) {
            if ($field == $extra)
                $itemfield[] = "M." . strtoupper($field);
            else
                $itemfield[] = "M." . strtoupper($field) . " as $extra";
            //}
        }

        $selfields = implode(",", $itemfield);
        $params["fSQL"] = 'SELECT ' . $selfields . ' FROM ' . $params["softone_table"] . ' M ' . $params["filter"];
        //echo $params["fSQL"];
        //$params["fSQL"] = 'SELECT M.* FROM ' . $params["softone_table"] . ' M ' . $params["filter"];
        echo "<BR>";
        echo $params["fSQL"];
        echo "<BR>";
        //return;
        $softone = new Softone();
        $datas = $softone->createSql($params);
        //print_r($datas);
        //return;
        foreach ((array)$datas->data as $data) {
            $data = (array) $data;
            print_r($data);
            $entity = $this->getDoctrine()
                    ->getRepository($params["repository"])
                    ->findOneBy(array("reference" => (int) $data[$params["softone_table"]]));

            $dt = new \DateTime("now");
            if (@$entity->id == 0) {
                $entity = new $object();
                $entity->setTs($dt);
                $entity->setCreated($dt);
                $entity->setModified($dt);
            } else {
                $entity->setRepositories();                
            }
            continue;
            @print_r($entity->repositories);
            foreach ($params["relation"] as $field => $extra) {
                //echo $field." - ".@$data[$extra]."<BR>";
                if (@$data[$extra] AND in_array($field, $fields)) {
                    $entity->setField($field, @$data[$extra]);
                }
                //echo @$entity->repositories[$field];
                if (@$data[$extra] AND @$entity->repositories[$field]) {
                    $rel = $this->getDoctrine()->getRepository($entity->repositories[$field])->findOneById($data[$extra]);
                    $entity->setField($field, $rel);
                }                
            }

            $imporetedData = array();
            $entity->setReference($data[$params["softone_table"]]);
            $this->flushpersist($entity);
            $q = array();
            foreach ($data as $identifier => $val) {
                $imporetedData[strtolower($params["softone_object"] . "_" . $identifier)] = addslashes($val);
                $ad = strtolower($identifier);
                $baz = $params["softone_object"] . ucwords(str_replace("_", " ", $ad));
                if (in_array($baz, $fields)) {
                    $q[] = "`" . strtolower($params["softone_object"] . "_" . $identifier) . "` = '" . addslashes($val) . "'";
                    //$entity->setField($baz, $val);
                }
            }
            @$entity_id = (int) $entity->id;
            if (@$entity_id > 0) {
                $sql = "update " . strtolower($params["table"]) . " set " . implode(",", $q) . " where id = '" . $entity_id . "'";
                $em->getConnection()->exec($sql);
                foreach ($params["extrafunction"] as $field => $func) {
                    $entity->$func();
                }                
            }
            //if (@$i++ > 500)
            //    break;
        }
    }   

}
