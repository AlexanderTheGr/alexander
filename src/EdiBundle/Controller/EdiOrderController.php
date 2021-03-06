<?php

namespace EdiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use EdiBundle\Entity\EdiOrder as EdiOrder;
use EdiBundle\Entity\EdiOrderItem as EdiOrderItem;
use AppBundle\Controller\Main as Main;
use AppBundle\Entity\Tecdoc as Tecdoc;

class EdiOrderController extends Main {

    var $repository = 'EdiBundle:EdiOrder';
    var $newentity = '';

    /**
     * @Route("/edi/edi/order")
     */
    public function indexAction() {

        $buttons = array();
        $buttons[] = array("label" => 'Get PartMaster', 'position' => 'right', 'class' => 'btn-success');

        return $this->render('EdiBundle:Edi:index.html.twig', array(
                    'pagename' => 'Edis',
                    'url' => '/edi/edi/order/getdatatable',
                    'view' => '/edi/edi/order/view',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/edi/edi/order/view/{id}")
     */
    public function viewAction($id) {
        $buttons = array();

        $dtparams[] = array("name" => "ID", "index" => 'id', "active" => "active");
        $dtparams[] = array("name" => "Product", "index" => 'viacaredi:description');
        $dtparams[] = array("name" => "Product", "index" => 'qty');
        $dtparams[] = array("name" => "Product", "index" => 'price');
        $params['dtparams'] = $dtparams;
        $params['id'] = $dtparams;
        $params['url'] = '/edi/edi/order/getitems/' . $id;

        $buttons = array();


        $json = json_encode(array());
        $EdiOrder = $this->getDoctrine()
                ->getRepository('EdiBundle:EdiOrder')
                ->find($id);

        if ($EdiOrder->getReference() == 0) {
            $buttons[] = array("label" => 'Send Order', 'position' => 'right', 'attr' => 'data-id=' . $id, 'class' => 'btn-success EdiSendOrder');
        }

        $content = $this->gettabs($id);
        $content = $this->getoffcanvases($id);

        $content = $this->content();


        return $this->render('EdiBundle:Edi:orderview.html.twig', array(
                    'pagename' => 'EDI O: ' . $EdiOrder->getRemarks(),
                    'url' => '/edi/edi/order/save',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $content,
                    'rules' => array(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/edi/edi/order/save")
     */
    public function saveAction() {

        $entity = new EdiOrder;
        $this->newentity[$this->repository] = $entity;
        $this->newentity[$this->repository]->setField("reference", 0);
        $out = $this->save();

        $jsonarr = array();
        if ($this->newentity[$this->repository]->getId()) {
            $jsonarr["returnurl"] = "/edi/edi/order/view/" . $this->newentity[$this->repository]->getId();
        }
        $json = json_encode($jsonarr);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    protected function gettabs($id) {
        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);
        if ($id == 0 AND @ $entity->id == 0) {
            $entity = new EdiOrder;
            $this->newentity[$this->repository] = $entity;
        }
        $buttons = array();
        $buttons[] = array("label" => 'Get PartMaster', 'position' => 'right', 'class' => 'btn-success');

        $dataarray[] = array("value" => "06", "name" => "06");
        $dataarray[] = array("value" => "10", "name" => "10");
        $dataarray[] = array("value" => "12", "name" => "12");
        $dataarray[] = array("value" => "14", "name" => "14");
        $dataarray[] = array("value" => "15", "name" => "15");

        $dataarray[] = array("value" => "qty1", "name" => "ΚΑΡΠΟΥ");
        $dataarray[] = array("value" => "qty2", "name" => "ΚΟΡΩΠΙ");
        $dataarray[] = array("value" => "qty3", "name" => "ΛΙΟΣΙΩΝ");

        //$tabfields["PurchaseOrderNo"] = array("label" => "Purchase Order No","value"=>1);
        $tabfields["remarks"] = array("label" => "Remarks");
        $tabfields["store"] = array("label" => "Store", 'type' => "select", 'dataarray' => $dataarray);
        $tabfields["ship"] = array("label" => "Ship");

        $tabforms = $this->getFormLyFields($entity, $tabfields);

        $dtparams[] = array("name" => "ID", "index" => 'id', "active" => "active");
        $dtparams[] = array("name" => "Code", "index" => 'EdiItem:itemCode');
        $dtparams[] = array("name" => "Product", "index" => 'EdiItem:description');
        //$dtparams[] = array("name" => "Store", "index" => 'store');

        if ($entity->getReference() == 0) {
            $dtparams[] = array("name" => "Qty", "input" => "text", "index" => 'qty');
        } else {
            $dtparams[] = array("name" => "Qty", "index" => 'qty');
        }

        $dtparams[] = array("name" => "Price", "index" => 'price');


        //$dtparams[] = array("name" => "Discount", "index" => 'discount');
        $dtparams[] = array("name" => "Final Price", "index" => 'fprice');
        $params['dtparams'] = $dtparams;
        $params['id'] = $dtparams;
        $params['key'] = 'gettabs_' . $id;
        $params['url'] = '/edi/edi/order/getitems/' . $id;
        $params["ctrl"] = 'ctrlgettabs';
        $params["app"] = 'appgettabs';
        $datatables[] = $this->contentDatatable($params);

        $this->addTab(array("title" => "General", 'buttons' => $buttons, "form" => $tabforms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        if ($entity->getId()) {
            $this->addTab(array("title" => "Items", "datatables" => $datatables, "form" => '', "content" => $this->getTabContentSearch($entity->getId()), "index" => $this->generateRandomString(), 'search' => 'text', "active" => false));
        }
        return $this->tabs();
    }

    protected function getoffcanvases($id) {
        $dtparams[] = array("name" => "ID", "index" => 'id', "input" => 'checkbox', "active" => "active");
        $dtparams[] = array("name" => "Part No", "index" => 'partno', 'search' => 'text');
        $dtparams[] = array("name" => "Description", "index" => 'description', 'search' => 'text');
        $dtparams[] = array("name" => "Price", "index" => 'wholesaleprice', "input" => 'text', 'search' => 'text');
        //$dtparams[] = array("name" => "ID", "function" => 'getAvailability', "active" => "active");
        $params['dtparams'] = $dtparams;
        $params['id'] = $dtparams;
        $params['key'] = 'getoffcanvases_' . $id;
        $params['url'] = '/edi/edi/order/getfororderitems/' . $id;
        $params["ctrl"] = 'ctrlgetoffcanvases';
        $params["app"] = 'appgetoffcanvases';
        $params["drawCallback"] = 'fororder(' . $id . ')';

        $datatables[] = $this->contentDatatable($params);
        //$datatables = array();
        $this->addOffCanvas(array('id' => 'asdf', "content" => 'sss', "index" => $this->generateRandomString(), "datatables" => $datatables));
        return $this->offcanvases();
    }

    function getTabContentSearch($edi) {
        $response = $this->get('twig')->render('EdiBundle:Edi:ediordersearch.html.twig', array('edi' => $edi));
        return str_replace("\n", "", htmlentities($response));
    }

    /**
     * @Route("/edi/order/addorderitem/")
     */
    public function addorderitemAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        if ($request->request->get("id") > 0) {
            $Ediitem = $this->getDoctrine()
                    ->getRepository('EdiBundle:EdiItem')
                    ->find($request->request->get("id"));
            $product = $Ediitem->toErp();
        } elseif ($request->request->get("product") > 0) {
            $Ediitem = $this->getDoctrine()
                    ->getRepository('EdiBundle:EdiItem')
                    ->findOneBy(array("product" => $request->request->get("product")));
            
            $Ediitem = $this->getDoctrine()
                    ->getRepository('EdiBundle:EdiItem')
                    ->find($request->request->get("product"));
            $product = $Ediitem->toErp();
        } else {
            return;
        }

        if (@$Ediitem->id == 0)
            return;
        if ($request->request->get("qty") > 0) {


            if ($request->request->get("order") > 0) {
                $EdiOrder = $this->getDoctrine()
                        ->getRepository('EdiBundle:EdiOrder')
                        ->find($request->request->get("order"));
            } elseif ($request->request->get("order") == 0) {

                /*
                  $query = $em->createQuery(
                  'SELECT p
                  FROM EdiBundle:EdiOrder p
                  WHERE
                  p.reference = 0
                  AND p.Edi = :edi AND p.store = :store'
                  )->setParameter('edi', $Ediitem->getEdi());
                  $EdiOrder = $query->setMaxResults(1)->getOneOrNullResult();
                 */
                $EdiOrder = $this->getDoctrine()
                                ->getRepository('EdiBundle:EdiOrder')->findOneBy(array("reference" => '', "store" => $request->request->get("store"), "Edi" => $Ediitem->getEdi()));
                if (!$EdiOrder) {
                    $EdiOrder = new EdiOrder;
                    $dt = new \DateTime("now");
                    $this->newentity[$this->repository] = $EdiOrder;
                    $EdiOrder->setEdi($Ediitem->getEdi());
                    $EdiOrder->setStore($request->request->get("store") ? $request->request->get("store") : "Default");
                    $EdiOrder->setShip("");
                    $EdiOrder->setRemarks($Ediitem->getEdi()->getName() . "_" . $request->request->get("store"));
                    $EdiOrder->setInsdate($dt);
                    $EdiOrder->setCreated($dt);
                    $EdiOrder->setModified($dt);
                    $this->flushpersist($EdiOrder);
                    $EdiOrder->setRemarks("EL1-" . $EdiOrder->getId() . " " . $Ediitem->getEdi()->getName() . "_" . $request->request->get("store"));
                    $this->flushpersist($EdiOrder);
                }
                $EdiOrder->setRemarks("EL1-" . $EdiOrder->getId() . " " . $Ediitem->getEdi()->getName() . "_" . $request->request->get("store"));
                $this->flushpersist($EdiOrder);
            }


            //$availability = $Ediitem->getQtyAvailability($request->request->get("qty"));
            //$Available = (array) $availability["Header"];
            //$price = $availability["PriceOnPolicy"];
            $price = 0;
            /*
              if (@$availability["Availability"] != 'green') {
              $json = json_encode(array("error" => true, "message" => $Available["Available"]));
              return new Response(
              $json, 200, array('Content-Type' => 'application/json')
              );
              }
             */
            $store = 1; //$Available["SUGGESTED_STORE"];
            /*
              $json = json_encode($availability);
              return new Response(
              $json, 200, array('Content-Type' => 'application/json')
              );
             * 
             */

            $query = $em->createQuery(
                    'SELECT p
                            FROM EdiBundle:EdiOrderItem p
                            WHERE 
                            p.EdiItem = ' . $Ediitem->getId() . '
                            AND p.EdiOrder = ' . $EdiOrder->getId() . ''
            );
            $EdiOrderItem = $query->setMaxResults(1)->getOneOrNullResult();

            if (@ $EdiOrderItem->id == 0) {
                $EdiOrderItem = new EdiOrderItem;
            }
            $qty = $request->request->get("qty");
            $price = $request->request->get("price");

            $price = $price > 0 ? $price : $Ediitem->getEdiQtyAvailability($qty);
            //echo $price;
            $EdiOrderItem->setEdiOrder($EdiOrder);
            $EdiOrderItem->setEdiItem($Ediitem);
            $EdiOrderItem->setField("qty", $qty);
            $EdiOrderItem->setField("price", $price);
            $EdiOrderItem->setField("porder", (int)$request->request->get("porder") );
            $EdiOrderItem->setField("fprice", (float) $price * $qty);
            $EdiOrderItem->setField("discount", 0);
            $EdiOrderItem->setField("store", $store);
            $EdiOrderItem->setField("chk", 1);
            try {
                $this->flushpersist($EdiOrderItem);
                $json = json_encode(array("error" => false, "product"=>$product->getId(),"message" => $Ediitem->getEdi()->getName() . " " . $Ediitem->getItemCode() . " μπήκε στο καλάθι"));
            } catch (\Exception $e) {
                $json = json_encode(array("error" => true, "message" => $e->getMessage()));
            }
        } else {
            try {
                //$this->flushpersist($EdiOrderItem);
                $json = json_encode(array("error" => false, "product"=>$product->getId(), "message" => $Ediitem->getEdi()->getName() . " " . $Ediitem->getItemCode() . " μπήκε στο καλάθι"));
            } catch (\Exception $e) {
                $json = json_encode(array("error" => true, "message" => $e->getMessage()));
            }
        }

        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/edi/edi/order/editorderitem/")
     */
    public function editorderitemAction(Request $request) {
        $EdiOrderItem = $this->getDoctrine()
                ->getRepository('EdiBundle:EdiOrderItem')
                ->find($request->request->get("id"));
        if ($request->request->get("qty")) {
            $EdiOrderItem->setQty($request->request->get("qty"));
            /*
              $availability = $EdiOrderItem->getEdi()->getQtyAvailability($request->request->get("qty"));
              $Available = (array) $availability["Header"];
              $store = $Available["SUGGESTED_STORE"];
              if ($availability["Header"]["Available"] == 'N') {
              $json = json_encode(array("error" => true, "message" => $Available["Available"]));
              return new Response(
              $json, 200, array('Content-Type' => 'application/json')
              );
              }
             * 
             */
            //$price = $Available["PriceOnPolicy"];
            //$EdiOrderItem->setPrice($price);
            // $EdiOrderItem->setField("store", $store);
        } else if ($request->request->get("price"))
            $EdiOrderItem->setPrice($request->request->get("price"));
        else if ($request->request->get("discount"))
            $EdiOrderItem->setDiscount($request->request->get("discount"));
        elseif ($request->request->get("qty") == 0) {
            try {
                $this->flushremove($EdiOrderItem);
                $json = json_encode(array("error" => false));
            } catch (\Exception $e) {
                $json = json_encode(array("error" => true, "message" => "Product Exists"));
            }
            return new Response(
                    $json, 200, array('Content-Type' => 'application/json')
            );
        }
        $fprice = ($EdiOrderItem->getPrice() * $EdiOrderItem->getQty()) * (1 - ($EdiOrderItem->getDiscount() / 100));
        $EdiOrderItem->setFprice($fprice);
        try {
            $this->flushpersist($EdiOrderItem);
            $json = json_encode(array("error" => false));
        } catch (\Exception $e) {
            $json = json_encode(array("error" => true, "message" => "Product Exists"));
        }
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/edi/edi/order/getitems/{id}")
     */
    public function getitemsAction($id) {
        $session = new Session();
        foreach ($session->get('params_gettabs_' . $id) as $param) {
            $this->addField($param);
        }
        $this->repository = 'EdiBundle:EdiOrderItem';
        $this->q_and[] = $this->prefix . ".EdiOrder = " . $id;
        //$this->q_and[] = $this->prefix . ".viacarediorder = " . $id;
        $json = $this->datatable();


        $data = (array) json_decode($json);
        $jsonarr = $data["data"];
        $jsono = array();

        foreach ($jsonarr as $json) {
            foreach ($json as $key => $val) {
                if ($key == 5) {
                    @$jsono[$key] += $val;
                } elseif ($key == 4) {
                    @$jsono[$key] = "Total";
                } else {
                    $jsono[$key] = '';
                }
            }
        }
        $jsono["DT_RowClass"] = "bold dt_row";
        if (@$jsono[5] > 0) {
            $jsonarr[] = $jsono;
        }
        $data["data"] = $jsonarr;
        $json = json_encode($data);

        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/edi/edi/order/getfororderitems/{id}")
     */
    public function getfororderitemsAction($id) {
        $session = new Session();
        foreach ($session->get('params_getoffcanvases_' . $id) as $param) {
            $this->addField($param);
        }
        $this->repository = 'EdiBundle:EdiItem';

        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/edi/edi/order/sendorder/")
     */
    public function sendorderAction(Request $request) {
        $json = json_encode(array());
        $EdiOrder = $this->getDoctrine()
                ->getRepository('EdiBundle:EdiOrder')
                ->find($request->request->get("id"));
        if ($EdiOrder->getReference() == "") {
            $orderNo = @$EdiOrder->sendOrder();
            $EdiOrder->setReference($orderNo);
            $this->flushpersist($EdiOrder);
        }

        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/edi/edi/order/getdatatable")
     */
    public function getdatatableAction(Request $request) {
        //$this->repository = 'EdiBundle:Edi';
        $this->addField(array("name" => "ID", "index" => 'id'));
        $this->addField(array("name" => "Reference", "index" => 'reference'));
        $this->addField(array("name" => "Order", "index" => 'remarks'));
        $this->addField(array("name" => "Store", "index" => 'store'));
        $this->addField(array("name" => "Ship", "index" => 'ship'));
        $json = $this->datatable();

        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/edi/edi/order/ediiteminfo")
     */
    public function ediiteminfoAction(Request $request) {

        $EdiOrderItem = $this->getDoctrine()
                ->getRepository('EdiBundle:EdiOrderItem')
                ->find($request->request->get("id"));
        $item = $EdiOrderItem->getEdiItem();
        $tecdoc = new Tecdoc();
        if ($item->getTecdocArticleId() > 0) {
            $params["tecdoc_article_id"] = $item->getTecdocArticleId();

            $docs = $tecdoc->getArticleImages(array("articleId" => $params["tecdoc_article_id"]));
            @mkdir("assets/tmp/");
            foreach ($docs->data->array as $image) {

                $docfile = "assets/tmp/" . $image->folder . "-" . $image->file . ".jpg";
                $this->convertImageToJpg($image->path, $docfile);
                $attr = ($o == true) ? array('image', 'small_image', 'thumbnail') : array();
                $o = false;
                if (file_exists($docfile)) {
                    //echo $docfile;
                    $data["img"] = "<img src='/" . $docfile . "' />";
                }

                break;
            }

            $params["articleId"] = $item->getTecdocArticleId();
            $originals = $tecdoc->getOriginals($params);
            $data["img"] = "<ul>";
            foreach ($originals->data->array as $v) {
                $data["img"] .= "<li><b>" . $v->brand . "</b>: " . $v->original . "</li>";
            }
            $data["orginal"] .= "</ul>";


            $attributs = $tecdoc->getAssignedArticlesByIds(
                    array(
                        "articleId" => $item->getTecdocArticleId(),
                        "linkingTargetId" => ""
            ));
            $arr = array();
            $descrption .= "<ul class='product_attributes'>";
            $attributes = array();
            foreach ($attributs->data->array[0]->articleAttributes->array as $attribute) {
                if (!$attributes[$attribute->attrId]) {
                    $attributes[$attribute->attrId][] = trim(str_replace("[" . $attribute->attrUnit . "]", "", $attribute->attrName)) . ": " . $attribute->attrValue . $attribute->attrUnit;
                } else {
                    $attributes[$attribute->attrId][] = $attribute->attrValue . $attribute->attrUnit;
                }
            }
            foreach ($attributes as $attrId => $attribute) {
                //if (!in_array($attribute->attrId, $arr)) {
                $arr[$attrId] = $attribute->attrId;
                $descrption .= "<li class='attr_" . $attrId . "'>" . implode(" / ", $attribute) . "</li>";
                //}
            }
            $descrption .= "</ul>";

            $data["img"] = $descrption;

            echo $descrption;
        }

        $json = json_encode($data);

        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

}
