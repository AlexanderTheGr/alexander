<?php

namespace MegasoftBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main as Main;
use MegasoftBundle\Entity\Product as Product;
use MegasoftBundle\Entity\Manufacturer as Manufacturer;
use MegasoftBundle\Entity\Supplier as Supplier;
use MegasoftBundle\Entity\Productcategory as Productcategory;
use MegasoftBundle\Entity\Productcar as Productcar;
use AppBundle\Entity\Tecdoc as Tecdoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ProductController extends Main {

    var $repository = 'MegasoftBundle:Product';
    var $object = 'item';

    /**
     * @Route("/erp01/product/product")
     * 
     */
    public function indexAction() {

        /*
          $products = $this->getDoctrine()->getRepository("MegasoftBundle:Product")
          ->findAll();
          $tecdoc = new Tecdoc();
          $em = $this->getDoctrine()->getManager();
          foreach ($products as $product) {
          if ($product->getId() < 96669)
          continue;
          echo $product->getId()."<BR>";
          $product->updatetecdoc($tecdoc);
          $product->setProductFreesearch();

          $cats = $product->getCats();
          $cats2 = array();
          foreach ((array) $cats as $cat) {
          $category = $this->getDoctrine()
          ->getRepository('MegasoftBundle:Productcategory')
          ->findOneBy(array('category' => $cat, 'product' => $product->getId()));
          if (count($category) == 0) {
          //$category = new Productcategory();
          //$category->setProduct($product->getId());
          //$category->setCategory($cat);
          //@$this->flushpersist($category);
          if ($cat > 0) {
          $sql = 'insert megasoft_productcategory set product = "' . $product->getId() . '", category = "' . $cat . '"';
          $em->getConnection()->exec($sql);
          }
          }
          }

          //if ($i++ > 300) exit;
          }
         */
        return $this->render('MegasoftBundle:Product:index.html.twig', array(
                    'pagename' => 'Είδη',
                    'url' => '/erp01/product/getdatatable',
                    'view' => '/erp01/product/view',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/erp01/product/createProduct")
     */
    public function createProductAction(Request $request) {
        //return;
        $json = json_encode(array("ok"));


        $asd = $this->getArticlesSearchByIds($request->request->get("ref"));
        $asd = $asd[0];
        $json = json_encode($asd);
        //print_r($asd);


        $em = $this->getDoctrine();
        $manufacturer = $em->getRepository("MegasoftBundle:Manufacturer")
                ->findOneBy(array('title' => $asd->brandName));

        if (!$manufacturer) {
            $manufacturer = $this->createManufacturer($asd->brandName);
        } else {
            //echo $manufacturer->getTitle();
        }
        //$tecdocSupplier = $em->getRepository("MegasoftBundle:TecdocSupplier")->find($asd->brandNo);


        $erpCode = $this->clearstring($asd->articleNo) . "-" . $manufacturer->getCode();

        $product = $em->getRepository("MegasoftBundle:Product")->findOneBy(array('erpCode' => $erpCode));
        $json = array("error" => 1);
        if (@$product->id > 0) {
            $json = json_encode(array("error" => 0, "id" => (int) $product->id, 'returnurl' => '/erp01/product/view/' . (int) $product->id));
            return new Response(
                    $json, 200, array('Content-Type' => 'application/json')
            );
        }
        $tecdocSupplier = $em->getRepository("MegasoftBundle:TecdocSupplier")
                ->findOneBy(array('supplier' => $asd->brandName));

        //$erpCode = $this->clearCode($this->partno) . "-" . $manufacturer->getCode();
        $productsale = $em->getRepository('MegasoftBundle:Productsale')->find(1);
        $dt = new \DateTime("now");
        $product = new \MegasoftBundle\Entity\Product;
        $product->setProductSale($productsale);

        $product->setTecdocSupplierId($tecdocSupplier);
        $product->setTecdocCode($asd->articleNo);
        $product->setTitle($asd->genericArticleName);
        $product->setTecdocArticleId($asd->articleId);
        $product->setManufacturer($manufacturer);
        $product->setErpCode($erpCode);
        $product->setSupref('');
        $product->setStoreRetailPrice(0);
        $product->setStoreWholeSalePrice(0);
        $product->setSupplierCode($this->clearCode($asd->articleNo));

        $product->setBarcode('');
        $product->setPlace('');
        $product->setRemarks('');

        $product->setTs($dt);
        $product->setCreated($dt);
        $product->setModified($dt);

        $this->flushpersist($product);
        // $em->flush(); 

        /*
          $dt = new \DateTime("now");
          $product = new \MegasoftBundle\Entity\Product;
          $product->setSupplierCode($asd->articleNo);
          $product->setTitle($asd->genericArticleName);
          $product->setTecdocCode($asd->articleNo);
          $product->setItemMtrmark($TecdocSupplier->getId());
          $product->setTecdocSupplierId($TecdocSupplier);
          $product->setSupplierId($MegasoftSupplier);
          $product->setItemName($asd->genericArticleName);
          $product->setTecdocArticleId($asd->articleId);

          $productsale = $this->getDoctrine()
          ->getRepository('MegasoftBundle:Productsale')->find(1);
          $product->setStoreWholeSalePrice("0.00");
          $product->setStoreRetailPrice("0.00");
          $product->setItemMarkupw("0.00");
          $product->setItemMarkupr("0.00");
          $product->setProductSale($productsale);

          //$product->setItemCode($this->partno);
          $product->setItemApvcode($asd->articleNo);
          $product->setErpSupplier($asd->brand);
          $product->setItemMtrmanfctr($MegasoftSupplier->getId());
          $product->setErpCode($erpCode);
          $product->setItemCode($product->getErpCode());

          $product->setItemV5($dt);
          $product->setTs($dt);
          $product->setItemInsdate($dt);
          $product->setItemUpddate($dt);
          $product->setCreated($dt);
          $product->setModified($dt);
          @$this->flushpersist($product);
         */
        $product->updatetecdoc();
        $product->setProductFreesearch();
        $product->toMegasoft();

        $json = json_encode(array("error" => 0, "id" => (int) $product->id, 'returnurl' => '/erp01/product/view/' . (int) $product->id));

        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    private function createManufacturer($brand) {

        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $brand = strtoupper($brand);
        $manufacturer = $this->getDoctrine()->getRepository("MegasoftBundle:Manufacturer")
                ->findOneBy(array('title' => $brand));
        if ($manufacturer)
            return $manufacturer;
        $tecdocSupplier = $this->getDoctrine()->getRepository("MegasoftBundle:TecdocSupplier")
                ->findOneBy(array('supplier' => $brand));
        $login = $this->getSetting("MegasoftBundle:Webservice:Login"); //"demo-fastweb-megasoft";
        $soap = new \SoapClient("http://wsprisma.megasoft.gr/mgsft_ws.asmx?WSDL", array('cache_wsdl' => WSDL_CACHE_NONE));


        $sql = "Select max(id) as max from megasoft_manufacturer";
        $connection = $this->getDoctrine()->getConnection();
        $statement = $connection->prepare($sql);
        $statement->execute();
        $max = $statement->fetch();
        //if ($tecdocSupplier)
        $manufacturerCode = $tecdocSupplier ? $tecdocSupplier->getId() : $max["max"];

        $data["ManufacturerCode"] = $manufacturerCode;
        $data["ManufacturerName"] = $brand;
        $params["Login"] = $login;
        $params["JsonStrWeb"] = json_encode($data);
        $soap->__soapCall("SetManufacturer", array($params));
        unset($params["JsonStrWeb"]);

        $response = $soap->__soapCall("GetManufacturers", array($params));
        if (count($response->GetManufacturersResult->ManufacturerDetails) == 1) {
            $ManufacturerDetails[] = $response->GetManufacturersResult->ManufacturerDetails;
        } elseif (count($response->GetManufacturersResult->ManufacturerDetails) > 1) {
            $ManufacturerDetails = $response->GetManufacturersResult->ManufacturerDetails;
        }
        foreach ($ManufacturerDetails as $data) {
            $data = (array) $data;
            $entity = $this->getDoctrine()->getRepository("MegasoftBundle:Manufacturer")
                    ->find((int) $data["ManufacturerID"]);
            if (!$entity) {
                //$q[] = "`reference` = '" . $data[$params["megasoft_table"]] . "'";
                $sql = "insert megasoft_manufacturer set id = '" . $data["ManufacturerID"] . "', code = '" . $data["ManufacturerCode"] . "', title = '" . $data["ManufacturerName"] . "'";
                //echo $sql . "<BR>";
                $this->getDoctrine()->getConnection()->exec($sql);
            } else {
                //$sql = "update " . strtolower($params["table"]) . " set " . implode(",", $q) . " where id = '" . $entity->getId() . "'";
                //$sql = "update megasoft_manufacturer set code = '" . $data["ManufacturerCode"] . "', title = '" . $data["ManufacturerName"] . "' where id = '" . $entity->getId() . "'";
                //echo $sql . "<BR>";
                //$em->getConnection()->exec($sql);
            }
        }
        $manufacturer = $this->getDoctrine()->getRepository("MegasoftBundle:Manufacturer")
                ->findOneBy(array('title' => $brand));

        return $manufacturer;
    }

    public function getArticlesSearchByIds($search) {
        //if (file_exists(Yii::app()->params['root'] . "cache/terms/" . md5($search) . ".term")) {
        //$data = file_get_contents(Yii::app()->params['root'] . "cache/terms/" . md5($search) . ".term");
        //return $data;
        //} else {
        /*
          $url = $this->getSetting("AppBundle:Entity:tecdocServiceUrl");
          $fields = array(
          'action' => 'getSearchByIds',
          'search' => $search
          );
          $fields_string = '';
          foreach ($fields as $key => $value) {
          $fields_string .= $key . '=' . $value . '&';
          }
          rtrim($fields_string, '&');
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_POST, count($fields));
          curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
          $data = curl_exec($ch);
         */
        //file_put_contents(Yii::app()->params['root'] . "cache/terms/" . md5($search) . ".term", $data);
        $params = array(
            'search' => $search
        );
        $tecdoc = new Tecdoc();
        $data = $tecdoc->getArticlesSearchByIds($params);
        return $data->data->array;
        //return $data;
        //}
    }

    /**
     * @Route("/erp01/product/view/{id}")
     */
    public function viewAction($id) {

        $buttons = array();


        $product = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);
        $pagename = "Add new Product";
        if ($id > 0 AND count($product) > 0) {
            $product->updatetecdoc();
            $product->setProductFreesearch();
            $pagename = $product->getTitle() . " " . $product->getErpCode();
        }
        //$product->toMegasoft();
        //exit;
        $content = $this->gettabs($id);

        //$content = $this->getoffcanvases($id);
        $content = $this->content();
        return $this->render('MegasoftBundle:Product:view.html.twig', array(
                    'pagename' => $pagename,
                    'url' => '/erp01/product/save',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $content,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));


        $datatables = array();
        return $this->render('MegasoftBundle:Product:view.html.twig', array(
                    'pagename' => 'Product',
                    'url' => '/erp01/product/save',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'tabs' => $this->gettabs($id, $datatables),
                    'datatables' => $datatables,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/erp01/product/save")
     */
    public function savection() {
        $sql = 'delete from `megasoft_product` where erp_code is null or erp_code = "null"';
        $this->getDoctrine()->getConnection()->exec($sql);
        $product = new Product;
        $this->newentity[$this->repository] = $product;

        $this->initialazeNewEntity($product);
        @$this->newentity[$this->repository]->setField("status", 1);

        $this->error[$this->repository] = array();

        $entities = $this->save();

        $product = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($entities[$this->repository]);

        @$this->flushpersist($product);
        $product = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($product->getId());
        $entity = $this->getDoctrine()
                ->getRepository('MegasoftBundle:Product')
                ->find((int) $product->getId());


        if (!$product->getManufacturer() AND $product->getErpSupplier()) {
            $manufacturer = $this->createManufacturer($entity->getErpSupplier());
            $product->setManufacturer($manufacturer);
        }
        $erpCode = $this->clearstring($product->getSupplierCode()) . "-" . $product->getManufacturer()->getCode();
        $product->setErpCode2($erpCode);
        if ($product->getErpCode() == '') {
            $product->setErpCode($erpCode);
        }
        $dt = new \DateTime("now");
        $product->setTs($dt);
        $product->setBarcode($product->getSisxetisi());
        $product->setSupplierCode($this->clearstring($product->getSupplierCode()));
        $this->flushpersist($product);

        $product->setReplacer();

        //echo $product->id."\n";
        //echo $product->reference."\n";
        //$product = $this->newentity[$this->repository];
        $product->updatetecdoc(false, true);
        $product->setProductFreesearch();
        $product->toMegasoft();
        /*
          if ($product->getSisxetisi() != '') {
          $sproducts = $this->getDoctrine()
          ->getRepository($this->repository)
          ->findBy(array("sisxetisi" => $product->getSisxetisi()));
          foreach ($sproducts as $sproduct) {
          if ($sproduct->getSisxetisi() != '')
          $sproduct->toMegasoft();
          }
          }
         */
        //print_r($this->error);
        //echo $product->id;
        if (count($this->error[$this->repository])) {
            $json = json_encode(array("error" => 1, "id" => (int) $product->id, 'unique' => $this->error[$this->repository]));
        } else {
            $json = json_encode(array("error" => 0, "id" => (int) $product->id, 'returnurl' => '/erp01/product/view/' . (int) $product->id));
        }

        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    private function clearCode($code) {
        $code = str_replace(" ", "", $code);
        $code = str_replace(".", "", $code);
        $code = str_replace("-", "", $code);
        $code = str_replace("/", "", $code);
        $code = str_replace(")", "", $code);
        $code = str_replace("(", "", $code);
        $code = strtoupper($code);
        return $code;
    }

    /**
     * @Route("/erp01/product/addRelation")
     */
    public function addRelation(Request $request) {

        $json = json_encode(array("ok"));
        $product = $this->getDoctrine()
                ->getRepository($this->repository)
                ->findOneBy(array('erpCode' => $request->request->get("erp_code")));
        if (!$product)
            exit;

        $idArr = explode(":", $request->request->get("id"));
        $id = (int) $idArr[3];


        $product2 = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);

        if ($product2->getSisxetisi() == '') {
            if ($product->getSisxetisi()) {
                $product2->setSisxetisi($product->getSisxetisi());
            } else {
                $product2->setSisxetisi(str_pad($product2->getId(), 10, "0", STR_PAD_LEFT));
            }
            $this->flushpersist($product2);
        }

        if ($product2->getSisxetisi()) {
            if (!$product->getSisxetisi()) {
                $product->setSisxetisi($product2->getSisxetisi());
                $this->flushpersist($product);
            } else {
                $products = $this->getDoctrine()->getRepository($this->repository)->findBy(array("sisxetisi" => $product->getSisxetisi()));
                foreach ($products as $product) {
                    $product->setSisxetisi($product2->getSisxetisi());
                    $this->flushpersist($product);
                }
            }
        }

        /*
          $asd[] = $id;
          $asd[] = $product->getId();
          $json = json_encode($asd);
          if ($id > 0 AND count($product) > 0) {

          $sisxetisi = $this->getDoctrine()
          ->getRepository('MegasoftBundle:Sisxetiseis')
          ->findOneBy(array('product' => $id, 'sisxetisi' => $product->getId()));
          if (count($sisxetisi) == 0) {
          $sisxetisi = new Sisxetiseis();
          $sisxetisi->setProduct($id);
          $sisxetisi->setSisxetisi($product->getId());
          @$this->flushpersist($sisxetisi);
          $this->updateSisxetiseis($sisxetisi);
          }

          $sisxetisi = $this->getDoctrine()
          ->getRepository('MegasoftBundle:Sisxetiseis')
          ->findOneBy(array('sisxetisi' => $id, 'product' => $product->getId()));

          if (count($sisxetisi) == 0) {
          $sisxetisi = new Sisxetiseis();
          $sisxetisi->setProduct($product->getId());
          $sisxetisi->setSisxetisi($id);
          @$this->flushpersist($sisxetisi);
          $this->updateSisxetiseis($sisxetisi);
          }
          }
         * 
         */

        //$json = json_encode($product);
        //print_r($product);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/erp01/product/addUpload/{product}")
     */
    public function addUpload($product) {
        $path = "/home2/partsbox/public_html/partsbox/web/assets/media/";
        //$request->request->get("product");
        //print_r($_FILES);
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if ($check !== false) {
            $em = $this->getDoctrine()->getManager();
            $path .= $em->getConnection()->getDatabase();
            @mkdir($path);
            move_uploaded_file($_FILES["file"]["tmp_name"], $path . "/" . $product . ".jpg");
            //echo "File is an image - " . $check["mime"] . ".";
            echo "/assets/media/" . $em->getConnection()->getDatabase() . "/" . $product . ".jpg";
            $uploadOk = 1;
        } else {
            //echo "File is not an image.";
            $uploadOk = 0;
        }
        //echo "File: 62289290.jpg";
        exit;
    }

    /**
     * @Route("/erp01/product/addModel")
     */
    public function addModel(Request $request) {

        $product = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($request->request->get("product"));

        $cars = (array) $product->getCars();
        $cars2 = array();

        $brandmodeltypes = $this->getDoctrine()
                        ->getRepository('SoftoneBundle:BrandModelType')->findBy(array("brandModel" => $request->request->get("model")), array('brandModelType' => 'ASC'));

        foreach ($brandmodeltypes as $brandmodeltype) {
            $cars[] = $brandmodeltype->getId();
        }
        $cars = array_unique($cars);

        if (!$cars[0])
            unset($cars[0]);


        //print_r($cars);
        $product->setCars((array) $cars);
        $this->flushpersist($product);

        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $sql = "delete from megasoft_productcategory where product = '" . $product->getId() . "'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $sql = "delete from megasoft_productcar where product = '" . $product->getId() . "'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $cars = (array) $product->getCars();
        foreach ((array) $cars as $car) {
            $carobj = $this->getDoctrine()
                    ->getRepository('MegasoftBundle:Productcar')
                    ->findOneBy(array('car' => $car, 'product' => $product->getId()));
            if (count($carobj) == 0) {
                $carobj = new Productcar();
                $carobj->setProduct($product->getId());
                $carobj->setCar($car);
                @$this->flushpersist($carobj);
            }
        }
        $cats = (array) $product->getCats();
        if (!$cats[0])
            unset($cats[0]);
        foreach ((array) $cats as $cat) {
            $category = $this->getDoctrine()
                    ->getRepository('MegasoftBundle:Productcategory')
                    ->findOneBy(array('category' => $cat, 'product' => $product->getId()));
            if (count($category) == 0) {
                $category = new Productcategory();
                $category->setProduct($product->getId());
                $category->setCategory($cat);
                @$this->flushpersist($category);
            }
        }

        $json = json_encode((array) $cars);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/erp01/product/addCar")
     */
    public function addCar(Request $request) {
        $product = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($request->request->get("product"));

        $cars = (array) $product->getCars();
        $cars2 = array();
        if (!in_array($request->request->get("car"), $cars)) {
            $cars[] = $request->request->get("car");
        } else {
            foreach ((array) $cars as $key => $car) {
                if ($request->request->get("car") == $car) {
                    unset($cars[$key]);
                }
            }
        }
        if (!$cars[0])
            unset($cars[0]);

        //print_r($cars);
        $product->setCars((array) $cars);
        $this->flushpersist($product);

        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $sql = "delete from megasoft_productcategory where product = '" . $product->getId() . "'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $sql = "delete from megasoft_productcar where product = '" . $product->getId() . "'";
        $statement = $connection->prepare($sql);
        $statement->execute();

        $cars = (array) $product->getCars();
        foreach ((array) $cars as $car) {
            $carobj = $this->getDoctrine()
                    ->getRepository('MegasoftBundle:Productcar')
                    ->findOneBy(array('car' => $car, 'product' => $product->getId()));
            if (count($carobj) == 0) {
                $carobj = new Productcar();
                $carobj->setProduct($product->getId());
                $carobj->setCar($car);
                @$this->flushpersist($carobj);
            }
        }

        $cats = (array) $product->getCats();
        if (!$cats[0])
            unset($cats[0]);
        foreach ((array) $cats as $cat) {
            $category = $this->getDoctrine()
                    ->getRepository('MegasoftBundle:Productcategory')
                    ->findOneBy(array('category' => $cat, 'product' => $product->getId()));
            if (count($category) == 0) {
                $category = new Productcategory();
                $category->setProduct($product->getId());
                $category->setCategory($cat);
                @$this->flushpersist($category);
            }
        }





        $json = json_encode((array) $cars);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/erp01/product/addCategory")
     */
    public function addCategory(Request $request) {



        $idArr = explode(":", $request->request->get("product"));
        $id = (int) $idArr[3];

        $product = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($request->request->get("product"));

        $cats = (array) $product->getCats();
        foreach ((array) $cats as $cat) {
            $category = $this->getDoctrine()
                    ->getRepository('MegasoftBundle:Productcategory')
                    ->findOneBy(array('category' => $cat, 'product' => $product->getId()));
            if (count($category) == 0) {
                $category = new Productcategory();
                $category->setProduct($product->getId());
                $category->setCategory($cat);
                @$this->flushpersist($category);
            }
        }

        $json = json_encode($asd);
        if (count($product) > 0) {
            $category = $this->getDoctrine()
                    ->getRepository('MegasoftBundle:Productcategory')
                    ->findOneBy(array('category' => $request->request->get("category"), 'product' => $product->getId()));
            if (count($category) == 0) {
                $category = new Productcategory();
                $category->setProduct($product->getId());
                $category->setCategory($request->request->get("category"));
                @$this->flushpersist($category);
            } else {
                $this->flushremove($category);
            }
        }
        $categories = $this->getDoctrine()
                ->getRepository('MegasoftBundle:Productcategory')
                ->findBy(array('product' => $product->getId()));
        $cats = array();
        foreach ($categories as $category) {
            $cats[] = $category->getCategory();
        }
        if (!$cats[0])
            unset($cats[0]);
        $product->setCats($cats);
        $this->flushpersist($product);
        //$json = json_encode($product);
        //print_r($product);
        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $sql = "delete from megasoft_productcategory where product = '" . $product->getId() . "'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $sql = "delete from megasoft_productcar where product = '" . $product->getId() . "'";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $cars = (array) $product->getCars();
        foreach ((array) $cars as $car) {
            $carobj = $this->getDoctrine()
                    ->getRepository('MegasoftBundle:Productcar')
                    ->findOneBy(array('car' => $car, 'product' => $product->getId()));
            if (count($carobj) == 0) {
                $carobj = new Productcar();
                $carobj->setProduct($product->getId());
                $carobj->setCar($car);
                @$this->flushpersist($carobj);
            }
        }
        $cats = (array) $product->getCats();
        if (!$cats[0])
            unset($cats[0]);
        foreach ((array) $cats as $cat) {
            $category = $this->getDoctrine()
                    ->getRepository('MegasoftBundle:Productcategory')
                    ->findOneBy(array('category' => $cat, 'product' => $product->getId()));
            if (count($category) == 0) {
                $category = new Productcategory();
                $category->setProduct($product->getId());
                $category->setCategory($cat);
                @$this->flushpersist($category);
            }
        }


        $json = json_encode(array($request->request->get("category"), $request->request->get("product")));

        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    function updateSisxetiseis($sisx) {
        $sisxetiseis = $this->getDoctrine()
                ->getRepository('MegasoftBundle:Sisxetiseis')
                ->findBy(array('sisxetisi' => $sisx->getProduct()));

        foreach ($sisxetiseis as $sisxetis) {
            if ($sisx->getSisxetisi() != $sisxetis->getProduct()) {
                $sisxetisi = $this->getDoctrine()
                        ->getRepository('MegasoftBundle:Sisxetiseis')
                        ->findOneBy(array('product' => $sisx->getSisxetisi(), 'sisxetisi' => $sisxetis->getProduct()));

                if (count($sisxetisi) == 0) {
                    $sisxetisi = new Sisxetiseis();
                    $sisxetisi->setProduct($sisx->getSisxetisi());
                    $sisxetisi->setSisxetisi($sisxetis->getProduct());
                    try {
                        @$this->flushpersist($sisxetisi);
                        $this->updateSisxetiseis($sisxetisi);
                    } catch (Exception $e) {
                        
                    }
                }
                $sisxetisi = $this->getDoctrine()
                        ->getRepository('MegasoftBundle:Sisxetiseis')
                        ->findOneBy(array('sisxetisi' => $sisx->getSisxetisi(), 'product' => $sisxetis->getProduct()));
                if (count($sisxetisi) == 0) {
                    $sisxetisi = new Sisxetiseis();
                    $sisxetisi->setProduct($sisxetis->getProduct());
                    $sisxetisi->setSisxetisi($sisx->getSisxetisi());
                    try {
                        @$this->flushpersist($sisxetisi);
                        $this->updateSisxetiseis($sisxetisi);
                    } catch (Exception $e) {
                        
                    }
                }
            }
        }
    }

    /**
     * @Route("/erp01/product/gettab")
     */
    /*
      public function gettabs($id) {


      $entity = $this->getDoctrine()
      ->getRepository($this->repository)
      ->find($id);

      $fields["erpCode"] = array("label" => "Erp Code");
      $fields["storeWholeSalePrice01"] = array("label" => "Price Name");

      $forms = $this->getFormLyFields($entity, $fields);

      $this->addTab(array("title" => "General", "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
      $json = $this->tabs();
      return $json;
      }
     * 
     */



    public function gettabs($id) {
        $entity = $this->getDoctrine()
                ->getRepository('MegasoftBundle:Product')
                ->find($id);
        if ($id == 0 AND @ $entity->id == 0) {
            $productsale = $this->getDoctrine()
                            ->getRepository('MegasoftBundle:Productsale')->find(1);
            $entity = new Product;
            $entity->setStoreWholeSalePrice("0.00");
            $entity->setStoreRetailPrice("0.00");
            //$entity->setItemMarkupw("0.00");
            //$entity->setErpCode($this->generateRandomString());
            $entity->setWebupd(1);
            $entity->setProductSale($productsale);
        }
        $customer = $this->getDoctrine()->getRepository('MegasoftBundle:Customer')->find(1);
        //echo $entity->getGroupedDiscountPrice($customer);

        $cats = $entity->getCats();
        foreach ((array) $cats as $cat) {
            $category = $this->getDoctrine()
                    ->getRepository('MegasoftBundle:Productcategory')
                    ->findOneBy(array('category' => $cat, 'product' => $entity->getId()));
            if (count($category) == 0 AND $entity->id > 0) {
                $category = new Productcategory();
                $category->setProduct($entity->getId());
                $category->setCategory($cat);
                @$this->flushpersist($category);
            }
        }

        $entity->updatetecdoc();
        $dataarray[] = array("value" => "0", "name" => "Oxi");
        $dataarray[] = array("value" => "1", "name" => "Ναι");

        $suppliers = $this->getDoctrine()
                        ->getRepository('MegasoftBundle:Supplier')->findAll();
        $itemMtrsup = array();
        foreach ($suppliers as $supplier) {
            $itemMtrsup[] = array("value" => (string) $supplier->getId(), "name" => $supplier->getSupplierName()); // $supplier->getSupplierName();
        }


        //$cccPriceUpd = $entity->getCccPriceUpd() ? "1" : "0";
        //$entity->setCccPriceUpd($cccPriceUpd);
        /*
          $megasoftSuppliers = $this->getDoctrine()
          ->getRepository('MegasoftBundle:MegasoftSupplier')->findAll();
          foreach ($megasoftSuppliers as $megasoftSupplier) {
          $supplier[] = array("value" => (string) $megasoftSupplier->getId(), "name" => $megasoftSupplier->getTitle() . " (" . $megasoftSupplier->getCode() . ")");
          }
         * 
         */

        //$fields["reference"] = array("label" => "Ενεργό", "required" => false, "className" => "col-md-12 col-sm-12");

        $fields["active"] = array("label" => "Ενεργό", 'type' => "select", 'dataarray' => $dataarray, "required" => false, "className" => "col-md-3 col-sm-3");
        $fields["priceupd"] = array("label" => "Συχρονισμός", 'type' => "select", 'dataarray' => $dataarray, "required" => false, "className" => "col-md-3 col-sm-3");
        $fields["webupd"] = array("label" => "WEB", 'type' => "select", 'dataarray' => $dataarray, "required" => false, "className" => "col-md-3 col-sm-3");


        $fields["productSale"] = array("label" => "Προσφορά", "className" => "col-md-3", 'type' => "select", "required" => true, 'datasource' => array('repository' => 'MegasoftBundle:ProductSale', 'name' => 'title', 'value' => 'id'));


        $fields["title"] = array("label" => "Περιγραφή", "disabled" => $entity->getHasTransactions() > 0 ? true : false, "required" => true, "className" => "col-md-6 col-sm-6");
        $fields["erpCode"] = array("label" => "Κωδικός Είδους", "disabled" => $entity->getHasTransactions() > 0 ? true : false, "required" => false, "className" => "col-md-2 col-sm-2");



        $fields["erpCode2"] = array("label" => "Κωδικός Είδους 2", "required" => false, "className" => "col-md-2 col-sm-2");
        $fields["sisxetisi"] = array("label" => "Sisxetisi", "required" => false, "className" => "col-md-2 col-sm-2");

        $fields["tecdocSupplierId"] = array("label" => "Tecdoc Supplier", "required" => false, "className" => "col-md-6", 'type' => "select", 'datasource' => array('repository' => 'MegasoftBundle:TecdocSupplier', 'name' => 'supplier', 'value' => 'id', 'suffix' => 'id'));

        $fields["tecdocCode"] = array("label" => "Tecdoc Code", "required" => false, "className" => "col-md-6");


        //$fields["supplier"] = array("label" => "Supplier", "className" => "col-md-3", 'type' => "select", "required" => false, 'datasource' => array('repository' => 'MegasoftBundle:MegasoftSupplier', 'name' => 'title', 'value' => 'id', 'suffix' => 'code'));
        //$fields["supplier"] = array("label" => "Supplier", "className" => "col-md-3", 'type' => "select", "required" => false, 'dataarray' => $supplier);


        $fields["manufacturer"] = array("label" => "Supplier", "required" => false, "className" => "col-md-2", 'type' => "select", 'datasource' => array('repository' => 'MegasoftBundle:Manufacturer', 'name' => 'title', 'value' => 'id', 'suffix' => 'code'));

        $fields["erpSupplier"] = array("label" => "New Supplier", "required" => false, "className" => "col-md-3");

        $fields["supplierCode"] = array("label" => "Supplier Code", "className" => "col-md-3", "required" => true);


        $fields["place"] = array("label" => "Ράφι", "className" => "col-md-1", "required" => false);

        $fields["qty"] = array("label" => $this->getTranslation("Αποθήκη"), "className" => "col-md-2", "required" => false);
        //$fields["reserved"] = array("label" => "Δεσμευμενα", "className" => "col-md-3", "required" => false);
        //$fields["itemMtrsup"] = array("label" => "Συνήθης προμηθευτής", "className" => "col-md-2", "required" => false);        
        //$fields["supplier"] = array("label" => "Συνήθης προμηθευτής", "required" => false, "className" => "col-md-2", 'type' => "select", 'dataarray' => $itemMtrsup);

        $fields["supplier"] = array("label" => "Προμηθευτής", "required" => false, "className" => "col-md-2", 'type' => "select", 'datasource' => array('repository' => 'MegasoftBundle:Supplier', 'name' => 'supplierName', 'value' => 'id', 'suffix' => 'id'));

        $fields["supplierItemCode"] = array("label" => $this->getTranslation("Κωδικός Προμηθευτή"), "className" => "col-md-2", "required" => false);


        $fields["storeWholeSalePrice"] = array("label" => "Τιμή Χοδρικής", "className" => "col-md-2", "required" => false);
        $fields["storeRetailPrice"] = array("label" => "Τιμή Λιανικής", "className" => "col-md-2", "required" => false);

        $fields["wholeSaleMarkup"] = array("label" => "Markup Χοδρικής", "className" => "col-md-2", "required" => false);
        $fields["retailMarkup"] = array("label" => "Markup Λιανικής", "className" => "col-md-2", "required" => false);


        //$fields["remarks"] = array("label" => "Remarks", "required" => false, 'type' => "textarea", "className" => "col-md-6 col-sm-6");
        //$fields["replaced"] = array("label" => "Replaced by", "disabled" => $entity->getReplaced() == '' ? false : true, "className" => "col-md-6", "required" => false);
        $fields["replaced"] = array("label" => "Replaced by", "className" => "col-md-6", "required" => false);


        $forms = $this->getFormLyFields($entity, $fields);


        $fieldsextra["var1"] = array("label" => $this->getTranslation("Var1"), "className" => "col-md-2", "required" => false);
        $fieldsextra["var2"] = array("label" => $this->getTranslation("Var2"), "className" => "col-md-2", "required" => false);
        $fieldsextra["var3"] = array("label" => $this->getTranslation("Var3"), "className" => "col-md-2", "required" => false);
        $fieldsextra["var4"] = array("label" => $this->getTranslation("Var4"), "className" => "col-md-2", "required" => false);
        $fieldsextra["var5"] = array("label" => $this->getTranslation("Var5"), "className" => "col-md-2", "required" => false);
        $fieldsextra["var6"] = array("label" => $this->getTranslation("Var6"), "className" => "col-md-2", "required" => false);


        $fieldsextra["int1"] = array("label" => $this->getTranslation("Int1"), "className" => "col-md-2", "required" => false);
        $fieldsextra["int2"] = array("label" => $this->getTranslation("Int2"), "className" => "col-md-2", "required" => false);
        $fieldsextra["int3"] = array("label" => $this->getTranslation("Int3"), "className" => "col-md-2", "required" => false);
        $fieldsextra["int4"] = array("label" => $this->getTranslation("Int4"), "className" => "col-md-2", "required" => false);
        $fieldsextra["int5"] = array("label" => $this->getTranslation("Int5"), "className" => "col-md-2", "required" => false);
        $fieldsextra["int6"] = array("label" => $this->getTranslation("Int6"), "className" => "col-md-2", "required" => false);

        $fieldsextra["decimal1"] = array("label" => $this->getTranslation("Decimal1"), "className" => "col-md-2", "required" => false);
        $fieldsextra["decimal2"] = array("label" => $this->getTranslation("Decimal2"), "className" => "col-md-2", "required" => false);
        $fieldsextra["decimal3"] = array("label" => $this->getTranslation("Decimal3"), "className" => "col-md-2", "required" => false);
        $fieldsextra["decimal4"] = array("label" => $this->getTranslation("Decimal4"), "className" => "col-md-2", "required" => false);
        $fieldsextra["decimal5"] = array("label" => $this->getTranslation("Decimal5"), "className" => "col-md-2", "required" => false);
        $fieldsextra["decimal6"] = array("label" => $this->getTranslation("Decimal6"), "className" => "col-md-2", "required" => false);


        $formsextra = $this->getFormLyFields($entity, $fieldsextra);

        if ($id > 0 AND count($entity) > 0) {
            $entity2 = $this->getDoctrine()
                    ->getRepository('MegasoftBundle:Product')
                    ->find($id);
            $entity2->setReference("");
            $fields2["reference"] = array("label" => "Erp Code", "className" => "synafiacode col-md-12");
            $forms2 = $this->getFormLyFields($entity2, $fields2);

            $dtparams[] = array("name" => "ID", "index" => 'id', "active" => "active");
            $dtparams[] = array("name" => $this->getTranslation("Title"), "index" => 'title');
            $dtparams[] = array("name" => $this->getTranslation("Code"), "index" => 'erpCode');
            //$dtparams[] = array("name" => "Price", "index" => 'storeWholeSalePrice');
            $params['dtparams'] = $dtparams;
            $params['id'] = $dtparams;
            $params['url'] = '/erp01/product/getrelation/' . $id;
            $params['key'] = 'gettabs_' . $id;
            $params["ctrl"] = 'ctrlgettabs';
            $params["app"] = 'appgettabs';
            $datatables[] = $this->contentDatatable($params);
        }


        $tabs[] = array("title" => $this->getTranslation("General"), "datatables" => array(), "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true);
        if ($id > 0 AND count($entity) > 0) {
            $tabs[] = array("title" => $this->getTranslation("Relations"), "datatables" => $datatables, "form" => $forms2, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => false);
            $tabs[] = array("title" => $this->getTranslation("Categories"), "datatables" => '', "form" => '', "content" => $this->getCategories($entity), "index" => $this->generateRandomString(), 'search' => 'text', "active" => false);
            $tabs[] = array("title" => $this->getTranslation("Models"), "datatables" => '', "form" => '', "content" => $this->getCars($entity), "index" => $this->generateRandomString(), 'search' => 'text', "active" => false);
            $tabs[] = array("title" => $this->getTranslation("Images"), "datatables" => '', "form" => '', "content" => $this->getImagesHtml($entity), "index" => $this->generateRandomString(), 'search' => 'text', "active" => false);
            $tabs[] = array("title" => $this->getTranslation("Extra"), "datatables" => array(), "form" => $formsextra, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => false);
        }

        foreach ($tabs as $tab) {
            $this->addTab($tab);
        }

        $json = $this->tabs();
        return $json;
    }

    public function getImagesHtml($product) {
        $em = $this->getDoctrine()->getManager();

        $path = "/home2/partsbox/public_html/partsbox/web/assets/media/" . $em->getConnection()->getDatabase() . "/" . $product->getId() . ".jpg";

        if (file_exists($path)) {
            $img = "<img src='/assets/media/" . $em->getConnection()->getDatabase() . "/" . $product->getId() . ".jpg'>";
        }

        $response = $this->get('twig')->render('MegasoftBundle:Product:images.html.twig', array(
            'img' => $img,
            'product' => $product->getId(),
        ));
        return str_replace("\n", "", htmlentities($response));
    }

    public function getCars($product) {


        if ($this->getSetting("AppBundle:Erp:brand") > 0) {
            $brands = $this->getDoctrine()
                            ->getRepository('SoftoneBundle:Brand')->findBy(array("id" => 24), array('brand' => 'ASC'));
        } else {
            $brands = $this->getDoctrine()
                            ->getRepository('SoftoneBundle:Brand')->findBy(array("enable" => 1), array('brand' => 'ASC'));
        }

        $cars = (array) $product->getCars();
        //echo $product->cars;
        //print_r($cars);

        $html = "<ul class='pbrands' data-prod='" . $product->getId() . "'>";
        foreach ($brands as $brand) {
            $style1 = "";
            foreach ($cars as $car) {
                if ($brand->checkIfExists($car)) {
                    $exists = true;
                    $style1 = 'color:red';
                    //break;
                }
            }

            $brandmodels = $this->getDoctrine()
                            ->getRepository('SoftoneBundle:BrandModel')->findBy(array("brand" => $brand->getId(),'enable'=>1), array('brandModel' => 'ASC'));
            if (count($brandmodels) == 0)
                continue;
            $html .= "<li class='brandli' data-ref='" . $brand->getId() . "'>";
            $html .= "<a " . $style . " style='" . $style1 . "' data-ref='" . $brand->getId() . "' class='brandlia'>" . $brand->getBrand() . "</a>";
            $html .= "<ul  style='display:none' class='pbrandmodels pbrandmodels_" . $brand->getId() . "'>";
            foreach ($brandmodels as $brandmodel) {

                /*
                  $brandmodeltypes = $this->getDoctrine()
                  ->getRepository('SoftoneBundle:BrandModelType')->findBy(array("brandModel" => $brandmodel->getId()), array('brandModelType' => 'ASC'));
                  if (count($brandmodeltypes) == 0)
                  continue;
                 */
                $yearfrom = substr($brandmodel->getYearFrom(), 4, 2) . "/" . substr($brandmodel->getYearFrom(), 0, 4);
                $yearto = substr($brandmodel->getYearTo(), 4, 2) . "/" . substr($brandmodel->getYearTo(), 0, 4);
                $yearto = $yearto == 0 ? 'Today' : $yearto;
                $year = $yearfrom . " - " . $yearto;
                $na = $brandmodel->getBrandModel() . " " . $year;
                $na = $brandmodel->getBrandModelStr() != "" ? $brandmodel->getBrandModelStr() : $na;

                $style2 = "";
                foreach ($cars as $car) {
                    if ($brandmodel->checkIfExists($car)) {
                        $exists = true;
                        $style2 = 'color:red';
                        //break;
                    }
                }
                $html .= "<li class='brandli' data-ref='" . $brandmodel->getId() . "'>";
                $checkbox = "<input type='checkbox' data-product='" . $product->getId() . "' class='brandmodelchk' data-ref='" . $brandmodel->getId() . "' />";
                $html .= $checkbox . "<a " . $style . " style='" . $style2 . "' data-prod='" . $product->getId() . "' data-ref='" . $brandmodel->getId() . "' class='brandmodellia'>" . $na . "</a>";
                $html .= '</li>';
                $html .= "<ul style='display:none' class='pbrandmodelstypes pbrandmodelstypes_" . $brandmodel->getId() . "'>";
                /*
                  foreach ($brandmodeltypes as $brandmodeltype) {
                  $html .= "<li class='brandli' data-ref='" . $brandmodeltype->getId() . "'>";
                  $html .= "<a " . $style . " data-ref='" . $brandmodeltype->getId() . "' class='brandmodellia'>" . $brandmodeltype->getBrandModelType() . "</a>";
                  $html .= '</li>';
                  }
                 * 
                 */
                $html .= '</ul>';
            }
            $html .= '</ul>';
            $html .= '</li>';
        }
        $html .= '</ul>';
        return $html;
    }

    /**
     * @Route("/product/getBrandmodeltypes")
     */
    public function getBrandmodeltypes(Request $request) {
        //echo $request->request->get("brandModel");
        if ($this->getSetting("AppBundle:Erp:erpprefix") == '/erp01') {
            $product = $this->getDoctrine()
                    ->getRepository('MegasoftBundle:Product')
                    ->find($request->request->get("product"));
        } else {
            $product = $this->getDoctrine()
                    ->getRepository('SoftoneBundle:Product')
                    ->find($request->request->get("product"));
        }
        $cars = (array) $product->getCars();

        //print_r($cars);
        $brandmodeltypes = $this->getDoctrine()
                        ->getRepository('SoftoneBundle:BrandModelType')->findBy(array("brandModel" => $request->request->get("brandModel")), array('brandModelType' => 'ASC'));
        $html = '';

        foreach ($brandmodeltypes as $brandmodeltype) {

            $details = unserialize($brandmodeltype->getDetails());
            if (@$details["yearOfConstructionTo"]) {
                $yearfrom = substr($details["yearOfConstructionFrom"], 4, 2) . "/" . substr($details["yearOfConstructionFrom"], 0, 4);
                $yearto = substr($details["yearOfConstructionTo"], 4, 2) . "/" . substr($details["yearOfConstructionTo"], 0, 4);
                $yearto = $yearto == 0 ? 'Today' : $yearto;
                $year = " " . $yearfrom . " - " . $yearto;
            }
            if ($brandmodeltype->getEngine() != "") {
                $name = $brandmodeltype->getBrandModelType() . " " . $brandmodeltype->getPowerHp() . "ps (" . $brandmodeltype->getEngine() . ")" . $year;
            } else {
                $name = $brandmodeltype->getBrandModelType() . " " . $brandmodeltype->getPowerHp() . "ps" . $year;
            }
            //if (in_array())
            $style = '';
            $checkbox = "<input type='checkbox' data-product='" . $product->getId() . "' class='brandmodetypechk' data-ref='" . $brandmodeltype->getId() . "' />";
            if (in_array($brandmodeltype->getId(), $cars)) {
                $style = "style='color:red'";
                $checkbox = "<input checked type='checkbox' data-product='" . $product->getId() . "' class='brandmodetypechk' data-ref='" . $brandmodeltype->getId() . "' />";
            }
            //$style = "style='color:red'";    
            $html .= "<li class='brandmodetypeli' data-product='" . $product->getId() . "' data-ref='" . $brandmodeltype->getId() . "'>";
            $html .= $checkbox . "<a " . $style . " data-ref='" . $brandmodeltype->getId() . "' class='brandmodetypelia'>" . $name . "</a>";
            $html .= '</li>';
        }
        $json = json_encode(array("data" => $html));
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    public function getCategories($product) {
        $entities = $this->getDoctrine()
                ->getRepository('SoftoneBundle:Category')
                ->findBy(array("parent" => 0));
        $html = "<ul class='productcategory'>";

        $cats = (array) $product->getCats();

        foreach ($entities as $entity) {
            $html .= "<li class='parentcategoryli' data-ref='" . $entity->getId() . "'>";


            $entities2 = $this->getDoctrine()
                    ->getRepository('SoftoneBundle:Category')
                    ->findBy(array("parent" => $entity->getId()));
            $style = "";
            foreach ($entities2 as $entity2) {
                //$style = in_array($entity2->getId(), $cats) ? "style='color:red'" : '';
                if (in_array($entity2->getId(), (array) $cats)) {
                    $style = "style='color:red'";
                }
            }
            $html .= "<a " . $style . " data-ref='" . $entity->getId() . "' class='parentcategorylia'>" . $entity->getName() . "</a>";

            $html .= "<ul class='productcategory categoryul categoryul_" . $entity->getId() . "'>";

            foreach ($entities2 as $entity2) {
                $checked = in_array($entity2->getId(), (array) $cats) ? 'checked' : '';
                $style = in_array($entity2->getId(), $cats) ? "style='color:red'" : '';
                $html .= "<li " . $style . " class='categoryli categoryli_" . $entity->getId() . "'><input " . $checked . " class='productcategorychk' data-product='" . $product->getId() . "' data-ref='" . $entity2->getId() . "' type='checkbox'/>" . $entity2->getName() . "</li>";
            }
            $html .= '</ul>';

            $html .= '</li>';
        }
        $html .= '</ul>';
        return $html;
    }

    /**
     * @Route("/erp01/product/getrelation/{id}")
     */
    public function getrelationAction($id) {
        $session = new Session();
        foreach ($session->get('params_gettabs_' . $id) as $param) {
            $this->addField($param);
        }
        $this->repository = 'MegasoftBundle:Product';
        $this->q_and[] = $this->prefix . ".sisxetisi in  (Select k.sisxetisi FROM MegasoftBundle:Product k where k.id = '" . $id . "') AND " . $this->prefix . ".sisxetisi != ''  AND " . $this->prefix . ".id != '" . $id . "'";
        $json = $this->datatable();

        $datatable = json_decode($json);
        $datatable->data = (array) $datatable->data;
        foreach ($datatable->data as $key => $table) {
            $table = (array) $table;
            $table1 = array();
            foreach ($table as $f => $val) {
                $table1[$f] = $val;
            }
            $datatable->data[$key] = $table1;
        }
        $json = json_encode($datatable);


        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * 
     * 
     * @Route("/erp01/product/getdatatable")
     */
    public function getdatatableAction(Request $request) {

        $fields = array();
        //$fields = unserialize($this->getSetting("MegasoftBundle:Product:getdatatable"));
        //if (count($fields) == 0 OR $this->getSetting("MegasoftBundle:Product:getdatatable") == '') {
        $fields[] = array("name" => "ID", "index" => 'id', "active" => "active");
        $fields[] = array("name" => "Title", "index" => 'title');
        $fields[] = array("name" => "Code", "index" => 'erpCode');
        $fields[] = array("name" => "Store Code", "index" => 'erpCode2');
        $fields[] = array("name" => "Article Name", "index" => 'tecdocArticleName');

        //$fields[] = array("name" => "Supplier", "index" => 'supplier:title', 'type' => 'select', 'object' => 'MegasoftSupplier');
        $fields[] = array("name" => "Προσφορά", "index" => 'productSale:title', 'type' => 'select', 'object' => 'ProductSale');
        //$fields[] = array("name" => "Ράφι", "index" => 'itemMtrplace');
        //$fields[] = array("name" => "Συνχρ.", "index" => 'cccPriceUpd', 'method' => 'yesno');
        // $fields[] = array("name" => "Λιανική", "index" => 'storeRetailPrice');
        // $fields[] = array("name" => "Χονδρική", "index" => 'storeWholeSalePrice');
        // $fields[] = array("name" => "Αποθηκη", "function" => 'getApothiki', 'search' => 'text');
        // $fields[] = array("name" => "", "function" => 'getEditLink', 'search' => 'text');
        $this->setSetting("MegasoftBundle:Product:getdatatable", serialize($fields));
        //}


        foreach ($fields as $field) {
            $this->addField($field);
        }

        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     *  
     * 
     * @Route("/erp01/product/getReplacedProducts")
     */
    public function getReplacedProducts(Request $request) {
        exit;
        $sql = "SELECT id FROM `megasoft_product` WHERE lreplacer = '' AND replaced = '' AND `erp_code` in (SELECT `replaced` FROM `megasoft_product` WHERE `replaced` != '')";
        $connection = $this->getDoctrine()->getConnection();
        $statement = $connection->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll();
        $arr = array();

        foreach ($results as $data) {
            //$arr[] = $data;
            //print_r($data);
            //exit;
            $product = $this->getDoctrine()->getRepository("MegasoftBundle:Product")->find($data["id"]);
            $product->setChainReplacer();
            //if ($i++ > 100)
            //exit;
        }
    }

    /**
     *  SELECT * FROM `megasoft_product` WHERE `erp_code` in (SELECT `replaced` FROM `megasoft_product` WHERE `replaced` != '')
     * 
     * @Route("/erp01/product/getFanoProducts")
     */
    public function getFanoProducts(Request $request) {
        $allowedips = $this->getSetting("MegasoftBundle:Product:Allowedips");
        $allowedipsArr = explode(",", $allowedips);
        if (in_array($_SERVER["REMOTE_ADDR"], $allowedipsArr)) {
            $sql = "SELECT * FROM  `megasoft_product` where erp_supplier = 'GBG'";
            $connection = $this->getDoctrine()->getConnection();
            $statement = $connection->prepare($sql);
            $statement->execute();
            $results = $statement->fetchAll();
            $arr = array();
            foreach ($results as $data) {
                $arr[] = $data;
            }
            $json = json_encode($arr);
            return new Response(
                    $json, 200, array('Content-Type' => 'application/json')
            );
        } else {
            exit;
        }
    }

    /**
     * 
     * 
     * @Route("/erp01/product/getProductPrices")
     */
    public function getProductPrices(Request $request) {
        $allowedips = $this->getSetting("MegasoftBundle:Product:Allowedips");
        $allowedipsArr = explode(",", $allowedips);
        if (in_array($_SERVER["REMOTE_ADDR"], $allowedipsArr)) {
            $sql = "SELECT id,reference,store_retail_price, store_wholesale_price, price1,price2,price3,price4,price5 FROM  `megasoft_product`";
            $connection = $this->getDoctrine()->getConnection();
            $statement = $connection->prepare($sql);
            $statement->execute();
            $results = $statement->fetchAll();
            $arr = array();
            foreach ($results as $data) {
                $arr[] = $data;
            }
            $json = json_encode($arr);
            return new Response(
                    $json, 200, array('Content-Type' => 'application/json')
            );
        } else {
            exit;
        }
    }

    /**
     * 
     * 
     * @Route("/erp01/product/getRproducts")
     */
    public function getRproducts(Request $request) {
        $allowedips = $this->getSetting("MegasoftBundle:Product:Allowedips");
        $allowedipsArr = explode(",", $allowedips);
        if (in_array($_SERVER["REMOTE_ADDR"], $allowedipsArr)) {
            $sql = "SELECT * FROM `megasoft_product` WHERE `erp_code` in (Select CONCAT(`erp_code`, 'R') FROM megasoft_product)";
            $connection = $this->getDoctrine()->getConnection();
            $statement = $connection->prepare($sql);
            $statement->execute();
            $results = $statement->fetchAll();
            $arr = array();

            echo "kwd;apoid;sisxetisi<BR>";
            foreach ($results as $data) {
                //$arr[] = $data;
                $erpcode = substr_replace($data["erp_code"], "", -1);  //str_replace("","R",$data["erp_code"]);
                $sql2 = "SELECT * FROM `megasoft_product` WHERE `erp_code`  = '" . $erpcode . "'";
                $connection = $this->getDoctrine()->getConnection();
                $statement = $connection->prepare($sql2);
                $statement->execute();
                $results2 = $statement->fetchAll();
                echo $data["erp_code"] . ";" . $data["reference"] . ";" . $erpcode . "<BR>";
                //echo "update megasoft_product set sisxetisi = '".$erpcode."' where erp_code = '".$data["erp_code"]."';<BR>";
                foreach ($results2 as $data2) {
                    echo $data2["erp_code"] . ";" . $data2["reference"] . ";" . $data2["erp_code"] . "<BR>";
                    //echo "update megasoft_product set sisxetisi = '".$data2["erp_code"]."' where erp_code = '".$data2["erp_code"]."';<BR>";
                }
            }
            exit;
            $json = json_encode($arr);
            return new Response(
                    $json, 200, array('Content-Type' => 'application/json')
            );
        } else {
            exit;
        }
    }

    /**
     * 
     * 
     * @Route("/erp01/product/getProducts")
     */
    public function getProducts(Request $request) {
        $allowedips = $this->getSetting("MegasoftBundle:Product:Allowedips");
        $allowedipsArr = explode(",", $allowedips);
        if (in_array($_SERVER["REMOTE_ADDR"], $allowedipsArr)) {
            $sql = "SELECT * FROM  `megasoft_product` where erp_supplier != 'GBG' AND ts >= '" . date("Y-m-d", strtotime("-1 days")) . "' order by id desc";
            $connection = $this->getDoctrine()->getConnection();
            $statement = $connection->prepare($sql);
            $statement->execute();
            $results = $statement->fetchAll();
            $arr = array();
            foreach ($results as $data) {
                $arr[] = $data;
            }
            $json = json_encode($arr);
            return new Response(
                    $json, 200, array('Content-Type' => 'application/json')
            );
        } else {
            exit;
        }
    }

    /**
     * 
     * 
     * @Route("/erp01/product/getManufacturers")
     */
    public function getManufacturers(Request $request) {
        $allowedips = $this->getSetting("MegasoftBundle:Product:Allowedips");
        $allowedipsArr = explode(",", $allowedips);
        if (in_array($_SERVER["REMOTE_ADDR"], $allowedipsArr)) {
            $sql = "SELECT * FROM  `megasoft_manufacturer` ";
            $connection = $this->getDoctrine()->getConnection();
            $statement = $connection->prepare($sql);
            $statement->execute();
            $results = $statement->fetchAll();
            $arr = array();
            foreach ($results as $data) {
                $arr[] = $data;
            }
            $json = json_encode($arr);
            return new Response(
                    $json, 200, array('Content-Type' => 'application/json')
            );
        } else {
            exit;
        }
    }

    public function getSuppliers() {
        //return;
        //$login = "W600-K78438624F8";
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
                        ->getRepository('MegasoftBundle:Supplier')
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
                    //echo $sql . "<BR>";
                    $em->getConnection()->exec($sql);
                } else {
                    $sql = "update " . strtolower($params["table"]) . " set " . implode(",", $q) . " where id = '" . $entity->getId() . "'";
                    //echo $sql . "<BR>";
                    $em->getConnection()->exec($sql);
                }
            }
        }
    }

    /**
     * 
     * 
     * @Route("/erp01/product/productInfo")
     */
    public function productInfo(Request $request) {

        $buttons = array();
        //$content = $this->gettabs(1);
        //$content = $this->getoffcanvases($id);
        //$content = $this->content();

        $tecdoc = new Tecdoc();
        $article_id = $request->request->get("articleId");
        $product = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($request->request->get("ref"));

        $params["articleId"] = $article_id;

        $params["linkingTargetId"] = $request->request->get("car");
        $out["originals"] = $tecdoc->originals($params);
        $out["articleAttributes"] = $tecdoc->articleAttributesRow($params, 0) . "<img width=100% src='" . $this->media($params["articleId"]) . "'/>";

        //$asd = unserialize($this->getArticlesSearchByIds($article_id));
        //$out["articlesSearch"] = $tecdoc->getArticlesSearch($asd[0]->articleNo);
        //$out["articlesSearch"] = unserialize($this->getArticlesSearchByIds(implode(",", (array) $out["articlesSearch"])));
        //print_r( $out["articlesSearch"]);
        $egarmoges = '<ul>';
        foreach ($tecdoc->efarmoges($params) as $efarmogi) {
            $brandModelType = $this->getDoctrine()->getRepository('SoftoneBundle:BrandModelType')->find($efarmogi);
            if (!$brandModelType)
                continue;
            $brandModel = $this->getDoctrine()->getRepository('SoftoneBundle:BrandModel')->find($brandModelType->getBrandModel());
            if (!$brandModel)
                continue;
            $brand = $this->getDoctrine()->getRepository('SoftoneBundle:Brand')->find($brandModel->getBrand());
            if (!$brand)
                continue;
            $egarmoges .= '<li>' . $brand->getBrand() . ' ' . $brandModel->getBrandModel() . ' ' . $brandModelType->getBrandModelType() . '</li>';
        }
        $egarmoges .= '</ul>';
        $out["efarmoges"] = $egarmoges;

        //$content = 'sss';
        return $this->render('MegasoftBundle:Product:productInfo.html.twig', array(
                    'pagename' => 's',
                    'order' => $id,
                    'url' => '/order/save',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $out,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    public function media($tecdocArticleId) {

        //$product = json_decode($this->flat_data);
        if ($tecdocArticleId == "")
            return;


        $url = "http://service5.fastwebltd.com/";
        $fields = array(
            'action' => 'media',
            'tecdoc_article_id' => $tecdocArticleId
        );

        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $data = curl_exec($ch);
        //$this->media = $data;
        //$this->save();
        return $data;
    }

    /**
     * @Route("/erp01/product/fororderajaxjson")
     */
    public function fororderajaxjsonAction() {
        return new Response(
                "", 200
        );
    }

    function retrieveMtrcategory() {
        $params = unserialize($this->getSetting("MegasoftBundle:Product:retrieveMtrcategory"));
        if (count($params) > 0) {
            $params["megasoft_object"] = 'itecategory';
            $params["repository"] = 'MegasoftBundle:Pcategory';
            $params["megasoft_table"] = 'MTRCATEGORY';
            $params["table"] = 'megasoft_pcategory';
            $params["object"] = 'MegasoftBundle\Entity\Pcategory';
            $params["filter"] = '';
            $params["relation"] = array();
            $params["extra"] = array();
            $params["extrafunction"] = array();
            $this->setSetting("MegasoftBundle:Product:retrieveMtrcategory", serialize($params));
        }
        $this->retrieve($params);
    }

    function retrieveMtrmanfctr() {
        return;
        $params["fSQL"] = "SELECT M.* FROM MTRMANFCTR M ";
        $megasoft = new Megasoft();
        $datas = $megasoft->createSql($params);
        foreach ((array) $datas->data as $data) {
            $data = (array) $data;
            $MegasoftSupplier = $this->getDoctrine()->getRepository("MegasoftBundle:MegasoftSupplier")->find($data["MTRMANFCTR"]);
            if ($MegasoftSupplier->id == 0) {
                $sql = "Insert megasoft_megasoft_supplier SET id = '" . $data["MTRMANFCTR"] . "', title = '" . $data["NAME"] . "', code = '" . $data["CODE"] . "'";
                $this->getDoctrine()->getConnection()->exec($sql);
            }
        }
    }

    function retrieveProductPrices() {
        /*
          $soap = new \SoapClient("http://wsprisma.megasoft.gr/mgsft_ws.asmx?WSDL", array("connection_timeout"=>1,'cache_wsdl' => WSDL_CACHE_NONE));
          /*
          $ns = 'http://schemas.xmlsoap.org/soap/envelope/';
          $headerbody = array('Login' => "alexander", 'Date' => "2016-10-10");
          $header = new SOAPHeader($ns,"AuthHeader",$headerbody);
          $soap->__setSoapHeaders($header);
         */
        /*
          $login = $this->getSetting("MegasoftBundle:Webservice:Login");
          $params["Login"] = $login;
          $response = $soap->__soapCall("GetPriceLists", array($params));
          file_put_contents("GetPriceLists.xml", $response);
         * 
         */
        $databale = @explode(".", $_SERVER["HTTP_HOST"]);
        $ch = \curl_init();
        $login = $this->getSetting("MegasoftBundle:Webservice:Login");
        $header = array('Contect-Type:application/xml', 'Accept:application/xml');
        curl_setopt($ch, CURLOPT_URL, "http://wsprisma.megasoft.gr/mgsft_ws.asmx/GetPriceLists");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "login=" . $login);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        // in real life you should use something like:
        // curl_setopt($ch, CURLOPT_POSTFIELDS,
        //          http_build_query(array('postvar1' => 'value1')));
        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        file_put_contents("GetPriceLists_" . $databale[0] . ".xml", $server_output);
        $em = $this->getDoctrine()->getManager();
        $result = \simplexml_load_file("GetPriceLists_" . $databale[0] . ".xml");
        $pricelists = $result->Pricelists;
        foreach ($pricelists as $pricelist) {
            $sql = "update megasoft_product set price1 = '" . $pricelist->Value1 . "', price2 = '" . $pricelist->Value2 . "', price3 = '" . $pricelist->Value3 . "', price4 = '" . $pricelist->Value4 . "' where reference = '" . $pricelist->StoreId . "'";
            echo $sql . "<BR>";
            //if ($i++ > 100) exit;
            $em->getConnection()->exec($sql);
        }
    }

    function retrieveProduct($params = array()) {
        $login = "W600-K78438624F8";
        $login = $this->getSetting("MegasoftBundle:Webservice:Login"); //"demo-fastweb-megasoft";
        $em = $this->getDoctrine()->getManager();
        $soap = new \SoapClient("http://wsprisma.megasoft.gr/mgsft_ws.asmx?WSDL", array('cache_wsdl' => WSDL_CACHE_NONE));
        /*
          $ns = 'http://schemas.xmlsoap.org/soap/envelope/';
          $headerbody = array('Login' => "alexander", 'Date' => "2016-10-10");
          $header = new SOAPHeader($ns,"AuthHeader",$headerbody);
          $soap->__setSoapHeaders($header);
         */
        $params["Login"] = $login;

        $response = $soap->__soapCall("GetManufacturers", array($params));
        $this->getSuppliers();


        //exit;	
        if (count($response->GetManufacturersResult->ManufacturerDetails) == 1) {
            $ManufacturerDetails[] = $response->GetManufacturersResult->ManufacturerDetails;
        } elseif (count($response->GetManufacturersResult->ManufacturerDetails) > 1) {
            $ManufacturerDetails = $response->GetManufacturersResult->ManufacturerDetails;
        }


        //print_r($ManufacturerDetails);

        foreach ($ManufacturerDetails as $data) {
            $data = (array) $data;

            $entity = $this->getDoctrine()
                    ->getRepository("MegasoftBundle:Manufacturer")
                    ->find((int) $data["ManufacturerID"]);

            if (!$entity) {
                //$q[] = "`reference` = '" . $data[$params["megasoft_table"]] . "'";
                $sql = "insert megasoft_manufacturer set id = '" . $data["ManufacturerID"] . "', code = '" . addslashes($data["ManufacturerCode"]) . "', title = '" . addslashes($data["ManufacturerName"]) . "'";
                //echo $sql . "<BR>";
                $em->getConnection()->exec($sql);
            } else {
                //$sql = "update " . strtolower($params["table"]) . " set " . implode(",", $q) . " where id = '" . $entity->getId() . "'";
                $sql = "update megasoft_manufacturer set code = '" . $data["ManufacturerCode"] . "', title = '" . addslashes($data["ManufacturerName"]) . "' where id = '" . $entity->getId() . "'";
                //echo $sql . "<BR>";
                $em->getConnection()->exec($sql);
            }
        }
        //ini_set("soap.wsdl_cache_enabled", "0");
        //exit;
        /*
        $ch = \curl_init();
        $header = array('Contect-Type:application/xml', 'Accept:application/xml');
        curl_setopt($ch, CURLOPT_URL, "http://wsprisma.megasoft.gr/mgsft_ws.asmx/DownloadStoreBase");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "login=" . $login . "&Date=" . date("Y-m-d", strtotime("-1 days")) . "&ParticipateInEshop=1");
        //echo "login=" . $login . "&Date=" . date("Y-m-d", strtotime("-1 days")) . "&ParticipateInEshop=1<BR>";
       // exit;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        // in real life you should use something like:
        // curl_setopt($ch, CURLOPT_POSTFIELDS,
        //          http_build_query(array('postvar1' => 'value1')));
        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $databale = @explode(".", $_SERVER["HTTP_HOST"]);
        file_put_contents("downliad_" . $databale[0] . ".xml", $server_output);
        */

        //$StoreDetails = \simplexml_load_string($server_output);
        $databale = @explode(".", $_SERVER["HTTP_HOST"]);
        $result = \simplexml_load_file("downliad_" . $databale[0] . ".xml");

        $StoreDetails = $result->StoreDetails;
        //print_r($xml);
        //echo count($xml);
        //$params["Date"] = "2016-06-21";
        //$response = $soap->__soapCall("GetProducts", array($params));

        $cnt = count($StoreDetails);
        echo "<BR>[" . $cnt . "]<BR>";
        // exit;



        /*

          if (count($response->DownloadStoreBaseResponse) == 1) {
          $StoreDetails[] = $response->$response->DownloadStoreBaseResponse;
          } elseif (count($response->$response->DownloadStoreBaseResponse) > 1) {
          $StoreDetails = $response->$response->DownloadStoreBaseResponse;
          }



          //echo count($response->GetProductsResult->StoreDetails);
          echo "<BR>";
          exit;
          if (count($response->GetProductsResult->StoreDetails) == 1) {
          $StoreDetails[] = $response->GetProductsResult->StoreDetails;
          } elseif (count($response->GetProductsResult->StoreDetails) > 1) {
          $StoreDetails = $response->GetProductsResult->StoreDetails;
          }
         */
        //print_r($StoreDetails);
        // exit;
        
        $storeIds = array();
        foreach ($StoreDetails as $data) {
            //if ($i++ < ($cnt-10000))
            //   continue;
            $i++;
            $storeIds = array();
            if ($i > 50000 AND $i<100000) {            
                $data = (array) $data;
                $storeIds[] = array("storeid"=>addslashes($data["StoreId"]));
                $this->setProduct($data);
            } else {
                continue;
            }
            //if ($i++ > 100) return;
        }
        $params["JsonStrWeb"] = json_encode(array("items"=>$storeIds));
        $this->setCustomFields($soap,$params);
        
        $sql = 'UPDATE `megasoft_product` SET tecdoc_supplier_id = NULL WHERE  `tecdoc_supplier_id` = 0';
        $this->getDoctrine()->getConnection()->exec($sql);
        //$this->retrieveProductPrices();
        //exit;
        //;
    }
    function setCustomFields($soap,$params) {
        $response = $soap->__soapCall("GetCustomFieldsPerItem", array($params));
        //print_r($response->GetCustomFieldsPerItemResult->CustomFields);
        
        $params["table"] = "megasoft_product";
        foreach((array)$response->GetCustomFieldsPerItemResult->CustomFields as $data) {
            $data = (array) $data;
            $q = array();
            $q[] = "`decimal1` = '" . addslashes($data["CustomField_5"]) . "'";
            $q[] = "`decimal2` = '" . addslashes($data["CustomField_10"]) . "'";
            $q[] = "`decimal3` = '" . addslashes($data["CustomField_11"]) . "'";
            $q[] = "`var1` = '" . addslashes($data["CustomField_6"]) . "'";
            $q[] = "`var2` = '" . addslashes($data["CustomField_8"]) . "'";
            $q[] = "`var3` = '" . addslashes($data["CustomField_9"]) . "'";
            $q[] = "`var4` = '" . addslashes($data["CustomField_1"]) . "'";
            //$q[] = "`replaced` = '" . addslashes($data["CustomField_1"]) . "'";
            $q[] = "`int1` = '" . addslashes($data["CustomField_3"]) . "'";
            $q[] = "`int2` = '" . addslashes($data["CustomField_4"]) . "'";
            $q[] = "`int3` = '" . addslashes($data["CustomField_7"]) . "'";
            $sql = "update " . strtolower($params["table"]) . " set " . implode(",", $q) . " where reference = '" . addslashes($data["ApoId"]) . "'";
            $this->getDoctrine()->getManager()->getConnection()->exec($sql);
            echo $sql."<BR><BR><BR>";
        }
        //$this->getDoctrine()->getManager()->getConnection()->exec($sql);
    }

    function setProduct($data) {

        $data = (array) $data;

        //if ($data["StoreId"] < 207820) return;
        // print_r($data);
        //return;
        //if ($data["StoreKwd"] != "1643070G") return;
        //if ($i++ < 70000) return;
        if ($data["SupplierId"] != "") {
            echo $data["SupplierId"] . "<BR>";
        } else {
            //echo "[" . $data["SupplierId"] . "]<BR>";
            //return;
        }
        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->findOneBy(array("erpCode" => $data["StoreKwd"]));



        $dt = new \DateTime("now");

        if (!$entity) {
            $entity = new Product();
            $entity->setTs($dt);
            $entity->setCreated($dt);
            $entity->setModified($dt);
        } else {
            //echo "[" . addslashes($data["SupplierCode"]) . "] " . $entity->getId() . "<BR>";
            ///return;
            //if ($entity->getId() < 172652)
            //    return;
            //continue;
            //$entity->setRepositories();                
        }


        $manufacturer = $this->getDoctrine()
                ->getRepository("MegasoftBundle:Manufacturer")
                ->findOneBy(array("code" => $data["SupplierId"]));
        $supplier = $this->getDoctrine()
                ->getRepository("MegasoftBundle:Supplier")
                ->findOneBy(array("reference" => $data["mtrsup"]));


        $params["table"] = "megasoft_product";
        $q = array();
        //$q[] =
        $q[] = "`reference` = '" . addslashes($data["StoreId"]) . "'";
        $q[] = "`edi` = '" . addslashes($data["StoreId"]) . "'";
        $q[] = "`erp_code` = '" . addslashes($data["StoreKwd"]) . "'";
        $q[] = "`erp_code2` = '" . addslashes($data["StoreCodeErp"]) . "'";
        $q[] = "`store_retail_price` = '" . addslashes($data["StoreRetailPrice"]) . "'";
        $q[] = "`store_wholesale_price` = '" . addslashes($data["StoreWholeSalePrice"]) . "'";
        $q[] = "`retail_markup` = '" . addslashes($data["RetailMarkup"]) . "'";
        $q[] = "`wholesale_markup` = '" . addslashes($data["WholeSaleMarkup"]) . "'";
        $q[] = "`qty` = '" . addslashes($data["StoreStock"]) . "'";
        $q[] = "`supplier_code` = '" . addslashes($data["SupplierCode"]) . "'";
        if ($manufacturer) {
            $q[] = "`manufacturer` = '" . $manufacturer->getId() . "'";
            $q[] = "`erp_supplier` = '" . $manufacturer->getTitle() . "'";
        } else {
            $q[] = "`manufacturer` = NULL";
            $q[] = "`erp_supplier` = ''";
        }
        if (addslashes($data["fwSupplierId"]) > 0)
            $q[] = "`tecdoc_supplier_id` = '" . addslashes($data["fwSupplierId"]) . "'";

        $q[] = "`tecdoc_code` = '" . addslashes($data["fwCode"]) . "'";
        $q[] = "`title` = '" . addslashes($data["StoreDescr"]) . "'";
        $q[] = "`remarks` = '" . addslashes($data["remarks"]) . "'";
        $q[] = "`supref` = '" . addslashes($data["supref"]) . "'";
        $q[] = "`place` = '" . addslashes($data["place"]) . "'";
        $q[] = "`sisxetisi` = '" . addslashes($data["barcode"]) . "'";
        $q[] = "`supplier_item_code` = '" . addslashes($data["fwSupplierItemCode"]) . "'";
        $q[] = "`webupd` = '" . ($data["webupd"] == 'True' ? 1 : 0) . "'";
        $q[] = "`barcode` = '" . addslashes($data["barcode"]) . "'";
        $q[] = "`has_transactions` = '" . addslashes($data["HasTransactions"]) . "'";



        if ($supplier) {
            $q[] = "`supplier` = '" . $supplier->getId() . "'";
            /*
              $edi = $this->getDoctrine()
              ->getRepository("EdiBundle:Edi")
              ->findOneBy(array("itemMtrsup" => $supplier->getId()));
              if ($edi)
              $q[] = "`edi` = '" . $edi->getId() . "'";
             */
        }

        $q[] = "`product_sale` = '1'";
        //echo @$entity->getId()." ".$data["StoreKwd"]."<BR>";
        //return;
        if (@$entity->getId() == 0) {
            //$q[] = "`reference` = '" . $data[$params["megasoft_table"]] . "'";
            //$q[] = "`reference` = '" . addslashes($data["StoreId"]) . "'";
            $q[] = "`ts` = '" . date("Y-m-d") . "'";
            $sql = "insert " . strtolower($params["table"]) . " set " . implode(",", $q) . "";
            echo $sql . "<BR>";
            //echo "-";
            //return;
            $this->getDoctrine()->getManager()->getConnection()->exec($sql);
        } else {
            //return;
            $q[] = "`ts` = '" . date("Y-m-d") . "'";
            $sql = "update " . strtolower($params["table"]) . " set " . implode(",", $q) . " where id = '" . $entity->getId() . "'";
            echo $sql;
            //echo $entity->getId() . "<BR>";
            //echo ".";
            $this->getDoctrine()->getManager()->getConnection()->exec($sql);
        }
        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->findOneBy(array("reference" => (int) $data["StoreId"]));
        if ($entity) {
            //$entity->tecdoc = $tecdoc;
            $entity->updatetecdoc();
            $entity->setProductFreesearch();
            return $entity;
        }
    }

    function retrieveApothema($filters = false) {
        $login = "W600-K78438624F8";
        $login = $this->getSetting("MegasoftBundle:Webservice:Login"); //"demo-fastweb-megasoft";
        $em = $this->getDoctrine()->getManager();
        $soap = new \SoapClient("http://wsprisma.megasoft.gr/mgsft_ws.asmx?WSDL", array('cache_wsdl' => WSDL_CACHE_NONE));
        /*
          $ns = 'http://schemas.xmlsoap.org/soap/envelope/';
          $headerbody = array('Login' => "alexander", 'Date' => "2016-10-10");
          $header = new SOAPHeader($ns,"AuthHeader",$headerbody);
          $soap->__setSoapHeaders($header);
         */
        //exit;
        //$params["Date"] = "2017-05-24";
        //$params["ParticipateInEshop"] = 1;
        //$results = $soap->GetCustomers();
        $params["Login"] = $login;
        $response = $soap->__soapCall("GetStocks", array($params));

        echo count($response->GetStocksResult->StoreStock);
        echo "<BR>";
        //exit;	
        if (count($response->GetStocksResult->StoreStock) == 1) {
            $StockDetails[] = $response->GetStocksResult->StoreStock;
        } elseif (count($response->GetStocksResult->StoreStock) > 1) {
            $StockDetails = $response->GetStocksResult->StoreStock;
        }

        // print_r($StoreDetails);
        //exit;

        foreach ($StockDetails as $data) {
            //print_r($data);
            $data = (array) $data;

            //echo $product->id." ".$product->erp_code." --> ".$qty." -- ".$product->getApothema()."<BR>";
            $sql = "update megasoft_product set qty = '" . $data["StoreStocks"] . "'  where reference = '" . $data["StoreId"] . "'";
            echo $sql . "<BR>";
            $em->getConnection()->exec($sql);
            //if ($i++ > 100) return;
        }
    }

    /**
     * @Route("/erp01/product/setb2bproduct")
     */
    public function setb2bproduct(Request $request) {
        $allowedips = $this->getSetting("MegasoftBundle:Product:Allowedips");
        $allowedipsArr = explode(",", $allowedips);
        if (in_array($_SERVER["REMOTE_ADDR"], $allowedipsArr)) {
            $json = $request->getContent();
            //$json = '{"items":[{"storeid":"14819","qty":1,"price":0.93}],"customerid":"2","orderno":"100003383","comments":"hhjkh","reference":760}';
            //$json = '{"StoreDescr":"VALEO \u03a3\u03a5\u039c\u03a0\u03a5\u039a\u039d\u03a9\u03a4\u0397\u03a3","StoreKwd":"120241-21","StoreRetailPrice":"0.00","StoreWholeSalePrice":"0.00","RetailMarkup":"0.00","WholeSaleMarkup":"0.00","SupplierCode":"120241","SupplierId":"21","fwSupplierId":"21","fwCode":"120241","barcode":"","place":"","remarks":"","webupd":"True","supref":"158","mtrsup":"59","sisxetisi":"","StoreId":608999}';
            //$json = '{"StoreId":609004,StoreDescr":"REMSA \u0394\u0399\u03a3\u039a\u039f\u03a6\u03a1\u0395\u039d\u0391 MERCEDES","StoreKwd":"000200-153","StoreRetailPrice":"0.00","StoreWholeSalePrice":"0.00","RetailMarkup":"0.00","WholeSaleMarkup":"0.00","SupplierCode":"000200","SupplierId":"141","fwSupplierId":"153","fwCode":"000200","barcode":"","place":"","remarks":"","webupd":"True","supref":"158","mtrsup":"59","sisxetisi":""}';
            $data = json_decode($json, true);
            //print_r($data);
            //exit;
            if ($data) {
                $entity = $this->setProduct($data);
                $out["partsbox"] = $entity->getId();
            }
            return new Response(
                    json_encode((array) $out), 200, array('Content-Type' => 'application/json')
            );
        } else {
            exit;
        }
    }

    /**
     * @Route("/erp01/product/autocompletesearch")
     */
    public function autocompletesearchAction() {
        //echo $_GET["term"];
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                "SELECT  p.id, p.title, p.erpCode
                    FROM " . $this->repository . " p
                    where p.erpCode like '" . $this->clearstring($_GET["term"]) . "%' OR p.erpCode2 like '" . $this->clearstring($_GET["term"]) . "%' OR p.tecdocCode like '" . $this->clearstring($_GET["term"]) . "%'"
        );
        $results = $query->getResult();
        $jsonArr = array();
        foreach ($results as $result) {
            $json["id"] = $result["id"];
            $json["label"] = $result["title"] . ' ' . $result["erpCode"];
            $json["value"] = $result["erpCode"];
            $jsonArr[] = $json;
        }
        $json = json_encode($jsonArr);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/erp01/product/product/updatetecdoc")
     */
    public function getUpdateTecdocAction($funct = false) {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
                "SELECT  p.id
                    FROM " . $this->repository . " p
                    where p.tecdocSupplierId > 0 AND p.tecdocArticleId IS NULL order by p.id asc"
        );
        /*
          $query = $em->createQuery(
          "SELECT  p.id
          FROM " . $this->repository . " p, EdiBundle:Edi e
          where
          e.id = p.Edi AND p.dlnr > 0 order by p.id asc"
          );
         * 
         */

        $results = $query->getResult();
        echo count($results);
        $i = 0;
        $tecdoc = new Tecdoc();
        foreach ($results as $result) {
            //if ($result["id"] > 41170) {
            $ediediitem = $em->getRepository($this->repository)->find($result["id"]);
            $ediediitem->tecdoc = $tecdoc;
            $ediediitem->updatetecdoc();
            unset($ediediitem);
            echo $result["id"] . "<BR>";
            //if ($i++ > 3000) exit;
            // }
        }
        exit;
    }

    /**
     * @Route("/erp01/product/product/synchronize")
     */
    public function synchronizeAction($funct = false) {
        return;
        $megasoft = new Megasoft();
        $em = $this->getDoctrine()->getManager();
        $ediedis = $this->getDoctrine()->getRepository('EdiBundle:Edi')->findAll();
        foreach ($ediedis as $ediedi) {
            if ($ediedi->getId() == 4)
                if ($ediedi->getItemMtrsup() > 0) {
                    $products = $this->getDoctrine()->getRepository('MegasoftBundle:Product')->findBy(array("itemMtrsup" => $ediedi->getItemMtrsup()), array('id' => 'desc'));
                    foreach ($products as $product) {

                        //$brand = $product->getSupplier() ? $product->getSupplier()->getTitle() : "";
                        /*
                          $ediediitem = $this->getDoctrine()
                          ->getRepository('EdiBundle:EdiItem')
                          ->findOneBy(array("itemCode" => $product->getCccRef(), "Edi" => $ediedi));
                          if (!$ediediitem) {

                          }
                         * 
                         */
                        //$this->clearstring($search);
                        //if ($product->getItemCode2() != '333114') continue;

                        $ediediitem = false;
                        $newcccref = false;
                        $code = trim($this->clearstring($product->getCccRef()));
                        if ($code != '') {
                            $sql = "Select id from partsbox_db.edi_item where 
                                            replace(replace(replace(replace(replace(`itemcode`, '/', ''), '.', ''), '-', ''), ' ', ''), '*', '')  = '" . $code . "' AND edi = '" . $ediedi->getId() . "'
                                            limit 0,100";

                            //echo $sql . "<BR>";
                            $connection = $em->getConnection();
                            $statement = $connection->prepare($sql);
                            $statement->execute();
                            $data = $statement->fetch();
                            ;
                            //echo "<BR>";
                            echo ".";
                            if ($data["id"] > 0)
                                $ediediitem = $this->getDoctrine()->getRepository('EdiBundle:EdiItem')->find($data["id"]);
                        }
                        if (!$ediediitem) {
                            $brand = $product->getSupplier() ? $product->getSupplier()->getTitle() : "";
                            if ($brand != '') {
                                $ediediitem = $this->getDoctrine()
                                        ->getRepository('EdiBundle:EdiItem')
                                        ->findOneBy(array("partno" => $this->clearstring($product->getItemCode2()), 'brand' => $brand, "Edi" => $ediedi));
                                if ($ediediitem) {
                                    echo $this->clearstring($product->getItemCode2()) . "<BR>";
                                    $product->setCccRef($ediediitem->getItemCode());
                                    $newcccref = true;
                                }
                            }
                        }

                        //if ($brand == "BERU")
                        //if ($i++ > 240)
                        //    exit;
                        //continue;
                        if ($ediediitem) {
                            $storeWholeSalePrice = $ediediitem->getEdiMarkupPrice("storeWholeSalePrice");
                            $storeRetailPrice = $ediediitem->getEdiMarkupPrice("storeRetailPrice");
                            if ($newcccref OR round($storeWholeSalePrice, 2) != round($product->getStoreWholeSalePrice(), 2) OR round($storeRetailPrice, 2) != round($product->getStoreRetailPrice(), 2)) {
                                //echo $ediedi->getName() . " -- " . $product->getItemCode() . " -- " . $product->getSupplier()->getTitle() . " -- " . $product->getItemCode2() . " " . $ediediitem->getWholesaleprice() . " -- " . $ediediitem->getEdiMarkupPrice("storeWholeSalePrice") . " -- " . $product->getStoreWholeSalePrice() . "<BR>";
                                //if ($i++ > 15)
                                //    exit;
                                if ($storeWholeSalePrice > 0.01 AND $product->getReference() > 0) {
                                    $color = '';
                                    if ($storeWholeSalePrice == $storeRetailPrice) {
                                        $color = 'red';
                                    }
                                    echo "<div style='color:" . $color . "'>";
                                    echo $ediedi->getName() . " " . $ediediitem->getWholesaleprice() . " -- " . $product->getItemCode() . " storeWholeSalePrice:(" . $storeWholeSalePrice . "/" . $product->getStoreWholeSalePrice() . ") storeRetailPrice:(" . $storeRetailPrice . "/" . $product->getStoreRetailPrice() . ")<BR>";

                                    $product->setCccPriceUpd(1);
                                    $product->setStoreWholeSalePrice($storeWholeSalePrice);
                                    $product->setStoreRetailPrice($storeRetailPrice);
                                    //
                                    //echo $product->id." ".$product->erp_code." --> ".$qty." -- ".$product->getApothema()."<BR>";
                                    $sql = "update megasoft_product set item_pricew = '" . $storeWholeSalePrice . "', item_pricer = '" . $storeRetailPrice . "', item_cccpriceupd = 1, item_cccref = '" . $product->getCccRef() . "'   where id = '" . $product->getId() . "'";
                                    echo $sql . "<BR>";
                                    $em->getConnection()->exec($sql);
                                    //$this->flushpersist($product);
                                    //$product->toMegasoft();
                                    if ($newcccref)
                                        $sql = "UPDATE MTRL SET CCCREF='" . $product->getCccRef() . "', CCCPRICEUPD=1, PRICEW = " . $storeWholeSalePrice . ", PRICER = " . $storeRetailPrice . "  WHERE MTRL = " . $product->getReference();
                                    else
                                        $sql = "UPDATE MTRL SET CCCPRICEUPD=1, PRICEW = " . $storeWholeSalePrice . ", PRICER = " . $storeRetailPrice . "  WHERE MTRL = " . $product->getReference();

                                    $params["fSQL"] = $sql;
                                    $datas = $megasoft->createSql($params);
                                    echo $sql . "<BR>";

                                    echo "</div>";
                                }
                            } else {
                                //echo "<span style='color:red'>".$product->getItemCode()." -- ".$product->getSupplier()->getTitle()." -- " . $product->getItemCode2() . " ".$ediediitem->getWholesaleprice() . " -- ".$ediediitem->getEdiMarkupPrice("storeWholeSalePrice")." -- " . $product->getStoreWholeSalePrice() . "</span><BR>";
                            }
                        } else {
                            //echo "<span style='color:red'>".$product->getItemCode().";".$product->getSupplier()->getTitle().";" . $product->getItemCode2() . "</span><BR>";
                        }
                        //exit;
                    }
                }
        }

        exit;
    }

    /**
     * 
     * @Route("/erp01/product/retrieveMtrl/{mtrl}")
     */
    function retrieveMtrlAction($mtrl) {

        $allowedips = $this->getSetting("MegasoftBundle:Product:Allowedips");
        $allowedipsArr = explode(",", $allowedips);
        if (in_array($_SERVER["REMOTE_ADDR"], $allowedipsArr)) {
            echo $this->retrieveMtrl($mtrl);
            $product = $this->getDoctrine()
                    ->getRepository($this->repository)
                    ->findOneByReference($mtrl);
            $product->updatetecdoc();
            $product->setProductFreesearch();
            return new Response(
                    "", 200
            );
        } else {
            exit;
        }
    }

    /**
     * 
     * @Route("/erp01/product/retrieveMegasoft")
     */
    function retrieveMegasoftDataAction($params = array()) {
        //$allowedips = $this->getSetting("MegasoftBundle:Product:Allowedips");
        //$allowedipsArr = explode(",", $allowedips);
        //if (in_array($_SERVER["REMOTE_ADDR"], $allowedipsArr)) {
        set_time_limit(100000);
        ini_set('memory_limit', '2256M');

        echo $this->retrieveProduct();
        file_put_contents("retrieveMegasoft.txt", $allowedipsArr);
        //echo $this->retrieveApothema();
        return new Response(
                "", 200
        );
        //}
    }

    /**
     * 
     * @Route("/erp01/product/retrieveApothema")
     */
    function retrieveApothemaAction() {
        $allowedips = $this->getSetting("MegasoftBundle:Product:Allowedips");
        $allowedipsArr = explode(",", $allowedips);
        file_put_contents("ip.txt", $_SERVER["REMOTE_ADDR"]);
        if (in_array($_SERVER["REMOTE_ADDR"], $allowedipsArr)) {
            //echo "aaaa";
            //exit;
            file_put_contents("ip1.txt", $_SERVER["REMOTE_ADDR"]);
            $this->retrieveApothema();
            exit;
        } else {
            //echo 'sss';
            exit;
        }
    }

    //getmodeltypes
    /**
     * 
     * @Route("/erp01/product/getbrands")
     */
    function getBrandsction(Request $request) {
        $url = 'http://www.partsbay.gr/antallaktika/init/getbrands';
        $fields_string = '';
        $fields["brand"] = $request->request->get("brand");
        foreach ($fields as $key => $value) {
            @$fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $out = json_decode(curl_exec($ch));
    }

    /**
     * 
     * @Route("/erp01/product/getmodels")
     */
    function getModelsAction(Request $request) {
        $url = 'http://www.partsbay.gr/antallaktika/init/getmodels';
        $fields_string = '';
        $fields["brand"] = $request->request->get("brand");
        foreach ($fields as $key => $value) {
            @$fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $out = json_decode(curl_exec($ch));
    }

    /**
     * 
     * @Route("/erp01/product/getmodeltypes")
     */
    function getModeltypesAction(Request $request) {
        $url = 'http://www.partsbay.gr/antallaktika/init/getmodeltypes';
        $fields_string = '';
        $fields["brand"] = $request->request->get("brand");
        $fields["model"] = $request->request->get("model");
        foreach ($fields as $key => $value) {
            @$fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $out = json_decode(curl_exec($ch));
    }

}
