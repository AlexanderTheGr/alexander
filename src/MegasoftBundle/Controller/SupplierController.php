<?php

namespace MegasoftBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use MegasoftBundle\Entity\Supplier as Supplier;
use AppBundle\Controller\Main as Main;

class SupplierController extends Main {

    var $repository = 'MegasoftBundle:Supplier';
    /**
     * @Route("/megasoft/supplier/supplier")
     */
    public function indexAction() {
        return $this->render('supplier/index.html.twig', array(
                    'pagename' => 'Προμηθευτές',
                    'url' => '/megasoft/supplier/getdatatable',
                    'view' => '/megasoft/supplier/view',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/megasoft/supplier/view/{id}")
     */
    public function viewAction($id) {
        $content = $this->gettabs($id);
        //$content = $this->content();
        return $this->render('MegasoftBundle:Supplier:view.html.twig', array(
                    'pagename' => 'Supplier',
                    'url' => '/megasoft/supplier/save',
                    'content'=>$content,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'tabs' => $this->gettabs($id),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/megasoft/supplier/save")
     */
    public function savection() {
        $this->save();
        $json = json_encode(array("ok"));
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/megasoft/supplier/gettab")
     */
    public function gettabs($id) {


        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);

        $fields["supplierCode"] = array("label" => "Code");
        $fields["supplierName"] = array("label" => "Name");

        $forms = $this->getFormLyFields($entity, $fields);

        $this->addTab(array("title" => "General", "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        $json = $this->tabs();
        return $json;
    }

    /**
     * @Route("/megasoft/supplier/getdatatable")
     */
    public function getdatatableAction(Request $request) {
        $this->repository = 'MegasoftBundle:Supplier';

        $this->addField(array("name" => "ID", "index" => 'id', "active" => "active"))
                ->addField(array("name" => "Code", "index" => 'supplierCode'))
                ->addField(array("name" => "Name", "index" => 'supplierName'));
        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }
    /**
     * @Route("/megasoft/supplier/retrieve")
     */    
    function retrieveSupplier() {
        $this->getMegasoft();
        return new Response(
                json_encode(array()), 200, array('Content-Type' => 'application/json')
        );        
    }
    
    public function getMegasoft() {
        //return;
        $login = "W600-K78438624F8";
        $login = $this->getSetting("MegasoftBundle:Webservice:Login");
        $em = $this->getDoctrine()->getManager();
        //http://wsprisma.megasoft.gr/mgsft_ws.asmx
        $soap = new \SoapClient("http://wsprisma.megasoft.gr/mgsft_ws.asmx?WSDL", array('cache_wsdl' => WSDL_CACHE_NONE));
        
        /*
          $ns = 'http://schemas.xmlsoap.org/soap/envelope/';
          $headerbody = array('Login' => "alexander", 'Date' => "2016-10-10");
          $header = new SOAPHeader($ns,"AuthHeader",$headerbody);
          $soap->__setSoapHeaders($header);
         */

        $params["Login"] = $login;
        $params["Date"] = ""; //date("Y-m-d");
        //$results = $soap->GetSuppliers();
        $response = $soap->__soapCall("GetSuppliers", array($params));
        //print_r($response);
        //exit;
        if ($response->GetSuppliersResult->SupplierDetails) {
            echo count($response->GetSuppliersResult->SupplierDetails);
            foreach ($response->GetSuppliersResult->SupplierDetails as $megasoft) {
                //$supplier = Mage::getModel('b2b/supplier')->load($megasoft->SupplierId, "reference");
                $data = (array) $megasoft;
                $entity = $this->getDoctrine()
                        ->getRepository($this->repository)
                        ->findOneBy(array("reference" => (int) $data["SupplierId"]));
                $dt = new \DateTime("now");
                if (!$entity) {
                    $entity = new Supplier();
                    $entity->setTs($dt);
                    $entity->setCreated($dt);
                    $entity->setModified($dt);
                } else {
                    //continue;
                    //$entity->setRepositories();                
                }
                $params["table"] = "megasoft_supplier";
                $q = array();
                $q[] = "`supplier_code` = '" . addslashes($data["SupplierCode"]) . "'";
                $q[] = "`supplier_name` = '" . addslashes($data["SupplierName"]) . "'";
                $q[] = "`supplier_afm` = '" . addslashes($data["SupplierAfm"]) . "'";
                $q[] = "`supplier_city` = '" . addslashes($data["SupplierCity"]) . "'";
                $q[] = "`supplier_address` = '" . addslashes($data["SupplierAddress"]) . "'";
                $q[] = "`supplier_zip` = '" . addslashes($data["SupplierZip"]) . "'";
                $q[] = "`supplier_phone01` = '" . addslashes($data["SupplierPhone01"]) . "'";
                $q[] = "`supplier_phone02` = '" . addslashes($data["SupplierPhone02"]) . "'";
                if (@$entity->getId() == 0) {
                    $q[] = "`reference` = '" . addslashes($data["SupplierId"]) . "'";
                    //$q[] = "`suppliergroup` = '1'";
                    
                    $sql = "insert " . strtolower($params["table"]) . " set " . implode(",", $q) . "";
                    echo $sql . "<BR>";
                    //$em->getConnection()->exec($sql);
                } else {
                    $sql = "update " . strtolower($params["table"]) . " set " . implode(",", $q) . " where id = '" . $entity->getId() . "'";
                    echo $sql . "<BR>";
                    //$em->getConnection()->exec($sql);
                }

            }
        }
    }    
}
