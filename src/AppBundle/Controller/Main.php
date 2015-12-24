<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class Main extends Controller {

    var $fields = array();
    var $tabs = array();
    var $repository;
    var $prefix = 'p';
    var $q_or = array();
    var $q_and = array();
    var $where;
    var $select;
    var $orderBy;
    var $rmd;

    function __construct() {
    }

    public function content() {
        $data["tabs"] = $this->tabs;
        $data["offcanvases"] = $this->offcanvases;
        return $data;
    }

    public function tabs() {
        $data["tabs"] = $this->tabs;
        return $data;
    }

    public function offcanvases() {
        $data["offcanvases"] = $this->offcanvases;
        return $data;
    }

    public function datatable() {
        ini_set("memory_limit", "1256M");
        $request = Request::createFromGlobals();

 
        $recordsTotal = 0;
        $recordsFiltered = 0;
        //$this->q_or = array();
        //$this->q_and = array();

        $s = array();
        if ($request->request->get("length")) {
            $em = $this->getDoctrine()->getManager();

            $doctrineConfig = $em->getConfiguration();
            $doctrineConfig->addCustomStringFunction('FIELD', 'DoctrineExtensions\Query\Mysql\Field');

            $dt_order = $request->request->get("order");
            $dt_search = $request->request->get("search");
            $dt_columns = $request->request->get("columns");
            $recordsTotal = $em->getRepository($this->repository)->recordsTotal();
            $fields = array();
            foreach ($this->fields as $index => $field) {
                if (@$field["index"]) {
                    $fields[] = $field["index"];
                    $field_relation = explode(":", $field["index"]);
                    if (count($field_relation) == 1) {
                        if ($this->clearstring($dt_search["value"]) != "") {
                            $this->q_or[] = $this->prefix . "." . $field["index"] . " LIKE '%" . $this->clearstring($dt_search["value"]) . "%'";
                        }
                        if (@$this->clearstring($dt_columns[$index]["search"]["value"]) != "") {
                            $this->q_and[] = $this->prefix . "." . $this->fields[$index]["index"] . " LIKE '%" . $this->clearstring($dt_columns[$index]["search"]["value"]) . "%'";
                        }
                        $s[] = $this->prefix . "." . $field_relation[0];
                    } else {
                        if ($dt_search["value"] === true) {
                            if ($this->clearstring($dt_search["value"]) != "") {
                                $this->q_or[] = $this->prefix . "." . $field_relation[0] . " = '" . $this->clearstring($dt_search["value"]) . "'";
                            }
                        }
                        if (@$this->clearstring($dt_columns[$index]["search"]["value"]) != "") {
                            $field_relation = explode(":", $this->fields[$index]["index"]);
                            $this->q_and[] = $this->prefix . "." . $field_relation[0] . " = '" . $this->clearstring($dt_columns[$index]["search"]["value"]) . "'";
                            //$s[] = $this->prefix . "." . $field_relation[0];  
                        }
                    }
                }
            }

            $this->createWhere();
            $this->createOrderBy($fields, $dt_order);
            $this->createSelect($s);
            $select = count($s) > 0 ? implode(",", $s) : $this->prefix . ".*";

            $recordsFiltered = $em->getRepository($this->repository)->recordsFiltered($this->where);

            $query = $em->createQuery(
                            'SELECT  ' . $this->select . '
                                FROM ' . $this->repository . ' ' . $this->prefix . '
                                ' . $this->where . '
                                ORDER BY ' . $this->orderBy
                    )
                    ->setMaxResults($request->request->get("length"))
                    ->setFirstResult($request->request->get("start"));
            $results = $query->getResult();
        }
        $data["fields"] = $this->fields;
        $jsonarr = array();
        $r = explode(":", $this->repository);

        foreach (@(array)$results as $result) {
            $json = array();
            foreach ($data["fields"] as $field) {
                if (@$field["index"]) {
                    $field_relation = explode(":", $field["index"]);
                    if (count($field_relation) > 1) {
                        //echo $this->repository;
                        $obj = $em->getRepository($this->repository)->find($result["id"]);
                        foreach ($field_relation as $relation) {
                            if ($obj)
                                $obj = $obj->getField($relation);
                        }
                        $val = $obj;
                    } else {
                        $val = $result[$field["index"]];
                    }
                    if (@$field["method"]) {
                        $method = $field["method"] . "Method";
                        $json[] = $this->$method($val);
                    } else {
                        if (@$field["input"]) {
                            $json[] = "<input id='" . str_replace(":", "", $this->repository) . ucfirst($field["index"]) . "_" . $result["id"] . "' data-id='" . $result["id"] . "' class='" . str_replace(":", "", $this->repository) . ucfirst($field["index"]) . "' type='" . $field["input"] . "' value='" . $val . "'>";
                        } else {
                            $json[] = $val;
                        }
                    }
                } elseif (@$field["function"]) {
                    $func = $field["function"]; 
                    $obj = $em->getRepository($this->repository)->find($result["id"]);
                    $json[] = $obj->$func(count($results));
                }
            }
            $json["DT_RowClass"] = "dt_row_" . strtolower($r[1]);
            $json["DT_RowId"] = 'dt_id_' . strtolower($r[1]) . '_' . $result["id"];
            $jsonarr[] = $json;
        }
        $data["data"] = $jsonarr;
        $data["recordsTotal"] = $recordsTotal;
        $data["recordsFiltered"] = $recordsFiltered;
        return json_encode($data);
    }

    function yesnoMethod($value) {
        return $value ? "YES" : "NO";
    }

    function clearstring($string) {
        return addslashes(str_replace(array("'"), "", trim($string)));
    }

    function createSelect($s) {
        foreach ($s as $v => $f) {
            //$s[$v] = "IDENTITY(".$f.")";
        }
        $this->select = count($s) > 0 ? implode(",", $s) : $this->prefix . ".*";
    }

    function createWhere() {
        $this->where = count($this->q_or) > 0 ? " WHERE (" . implode(" OR ", $this->q_or) . ")" : " WHERE " . $this->prefix . ".id > 0";
        $this->where = count($this->q_and) > 0 ? $this->where . " AND (" . implode(" AND ", $this->q_and) . ")" : $this->where;
        return $this->where;
    }

    function createOrderBy($fields, $dt_order) {
        $bundle = explode(":", $this->repository);
        $field_order = explode(":", $fields[$dt_order[0]["column"]]);
        if (count($field_order) > 1) {
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery(
                    'SELECT  ' . $this->prefix . '.id
                                FROM ' . $bundle[0] . ':' . $field_order[0] . ' ' . $this->prefix . '
                                ORDER BY ' . $this->prefix . '.' . $field_order[1]
            );
            $results = $query->getResult();
            foreach ($results as $res) {
                $d[] = $res["id"];
            }
            if ($d) {
                $fei = implode(",", $d);
            }
            $this->orderBy = "FIELD(" . $this->prefix . "." . $field_order[0] . "," . $fei . ")" . " " . $dt_order[0]["dir"] . ' '; //$this->prefix . '.' . $field_order[0] . ' ' . $dt_order[0]["dir"] . ' ';
        } else {
            $this->orderBy = $this->prefix . '.' . $field_order[0] . ' ' . $dt_order[0]["dir"] . ' ';
        }
        return $this->orderBy;
    }

    function addField($field = array()) {
        $bundle = explode(":", $this->repository);
        if (@$field["type"] == "select") {
            $field["content"] = '<input class="style-primary-bright form-control search_init" type="radio" />';
        } elseif (@$field["index"]) {
            $field_order = explode(":", $field["index"]);
            if (@$field["method"] == "yesno") {
                $field["content"] = '<select class="style-primary-bright form-control search_init">';
                $field["content"] .= '<option value="">All</option>';

                $field["content"] .= '<option value="0">NO</option>';
                $field["content"] .= '<option value="1">YES</option>';

                $field["content"] .= '</select>';
            } elseif (count($field_order) > 1 AND @ $field["type"] == "select") {
                $em = $this->getDoctrine()->getManager();
                $query = $em->createQuery(
                        'SELECT  ' . $this->prefix . '.id, ' . $this->prefix . '.' . $field_order[1] . '
                                FROM ' . $bundle[0] . ':' . ucfirst($field_order[0]) . ' ' . $this->prefix . '
                                ORDER BY ' . $this->prefix . '.' . $field_order[1]
                );
                $results = $query->getResult();
                $field["content"] = '<select class="style-primary-bright form-control search_init">';
                $field["content"] .= '<option value="">Select</option>';
                foreach ($results as $result) {
                    $field["content"] .= '<option value="' . $result["id"] . '">' . $result[$field_order[1]] . '</option>';
                }
                $field["content"] .= '</select>';
            } else {
                $field["content"] = '<input class="style-primary-bright form-control search_init" type="text" />';
            }
        }
        $this->fields[] = $field;
        //print_r($this->fields);
        //echo "<BR>";
        return $this;
    }

    function addTab($tab = array()) {
        $this->tabs[] = $tab;
        return $this;
    }

    function addOffCanvas($offcanvas = array()) {
        $this->offcanvases[] = $offcanvas;
        return $this;
    }

    function contentDatatable($params) {
        $session = new Session();
        $session->set('params_' . $params['key'], $params['dtparams']);
        foreach ($params['dtparams'] as $param) {
            $fields[] = array('content' => $param["name"],'input' => @$param["input"]);
        }
        $datatable = array(
            'url' => $params['url'], // '/order/getitems/' . $id,
            'fields' => $fields,
            'drawCallback' => @$params["drawCallback"],
            'ctrl' => @$params["ctrl"] ? $params["ctrl"] : $this->generateRandomString(),
            'app' => @$params["app"] ? $params["app"] : $this->generateRandomString());
        return $datatable;
    }

    function generateRandomString($length = 15) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function datatableAction($ctrl = "", $app = "", $url = "") {
        if ($ctrl != 'none')
            return $this->render('elements/datatable.twig', array(
                        'url' => $url,
                        'ctrl' => $ctrl,
                        'app' => $app,
                        'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
            ));
        return new Response();
    }

    public function tabAction($ctrl, $app, $url, $action) {
        return $this->form($ctrl, $app, $url, $action);
    }

    public function tabsAction($ctrl, $app, $url, $tabs) {
        $tabs = (array) json_decode($tabs);
        return $this->render('elements/tabs.twig', array(
                    'pagename' => '',
                    'url' => $url,
                    'ctrl' => $ctrl,
                    'app' => $app,
                    'tabs' => $tabs,
                    'type' => '',
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    public function contentAction($ctrl, $app, $url, $content) {


        return $this->render('elements/content.twig', array(
                    'pagename' => '',
                    'url' => $url,
                    'ctrl' => $ctrl,
                    'app' => $app,
                    'content' => $content,
                    'type' => '',
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    public function offCanvasAction($ctrl, $app, $url, $offcanvases) {
        $tabs = (array) json_decode($offcanvases);
        return $this->render('elements/offcanvas.twig', array(
                    'pagename' => '',
                    'url' => $url,
                    'ctrl' => $ctrl,
                    'app' => $app,
                    'offcanvases' => $offcanvases,
                    'type' => '',
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    function formLybase64() {
        $json = json_encode(array("ok"));
        $content = $this->get("request")->getContent();
        $data = json_decode($content);
        $post = array();
        foreach ($data->data as $key64 => $val64) {
            $post[base64_decode($key64)] = base64_decode($val64);
        }
        return $post;
    }

    function save() {
        $data = $this->formLybase64();
        
        $entities = array();

        foreach ($data as $key => $val) {
            $df = explode(":", $key);
            if (!@$entities[$df[0] . ":" . $df[1]]) {
                $entities[$df[0] . ":" . $df[1]] = $this->getDoctrine()
                        ->getRepository($df[0] . ":" . $df[1])
                        ->find($df[3]);
            }
            if ($df[3] == 0) {
                $entities[$df[0] . ":" . $df[1]] = $this->newentity[$df[0] . ":" . $df[1]];
            }
            $entities[$df[0] . ":" . $df[1]]->setField($df[2], $val);
        }
        foreach ($entities as $key => $entity) {
            $this->flushpersist($entity);
            $out[$key] = $entity->getId();
        }
        return $out;
    }
    function flushpersist($entity) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();
    }
    function flushremove($entity) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();
    }
    function getFormLyFields($entity, $fields) {
        $forms["model"] = array();
        foreach ($fields as $field => $options) {
            @$options["type"] = $options["type"] ? $options["type"] : "input";
            @$options["required"] = $options["required"] ? $options["required"] : true;
            $forms["fields"][] = array("key" => $field, "id" => $this->repository . ":" . $field . ":" . $entity->getId(), "defaultValue" => $entity->getField($field), "type" => "input", "templateOptions" => array("type" => '', "label" => $options["label"], "required" => $options["required"]));
        }
        return $forms;
    }

}
