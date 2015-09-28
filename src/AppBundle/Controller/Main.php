<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
    var $rmd;

    function __construct() {
        
    }

    public function tabs() {
        $data["tabs"] = $this->tabs;
        return json_encode($data);
    }

    public function datatable() {
        ini_set("memory_limit", "1256M");
        $request = Request::createFromGlobals();

        $results = array();
        $recordsTotal = 0;
        $recordsFiltered = 0;
        $this->q_or = array();
        $this->q_and = array();
        $s = array();

        if ($request->request->get("length")) {
            $em = $this->getDoctrine()->getManager();

            $dt_order = $request->request->get("order");
            $dt_search = $request->request->get("search");
            $dt_columns = $request->request->get("columns");

            $recordsTotal = $em->getRepository($this->repository)->recordsTotal();
            $fields = array();

            foreach ($this->fields as $index => $field) {
                $fields[] = $field["index"];
                $field_relation = explode(":", $field["index"]);

                if (count($field_relation) == 1) {
                    if ($this->clearstring($dt_search["value"])) {
                        $this->q_or[] = $this->prefix . "." . $field["index"] . " LIKE '%" . $this->clearstring($dt_search["value"]) . "%'";
                    }
                    if ($this->clearstring($dt_columns[$index]["search"]["value"])) {
                        $this->q_and[] = $this->prefix . "." . $this->fields[$index]["index"] . " LIKE '%" . $this->clearstring($dt_columns[$index]["search"]["value"]) . "%'";
                    }
                    $s[] = $this->prefix . "." . $field_relation[0];
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
        foreach ($results as $result) {
            $json = array();
            foreach ($data["fields"] as $field) {
                $field_relation = explode(":", $field["index"]);
                if (count($field_relation) > 1) {
                    $obj = $em->getRepository($this->repository)->find($result["id"]);
                    foreach ($field_relation as $relation) {
                        if ($obj)
                            $obj = $obj->getField($relation);
                    }
                    $json[] = $obj;
                } else {
                    $json[] = $result[$field["index"]];
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

    function clearstring($string) {
        return addslashes(str_replace(array("'"), "", trim($string)));
    }

    function createSelect($s) {
        $this->select = count($s) > 0 ? implode(",", $s) : $this->prefix . ".*";
    }

    function createWhere() {
        $this->where = count($this->q_or) > 0 ? " WHERE (" . implode(" OR ", $this->q_or) . ")" : " WHERE " . $this->prefix . ".id > 0";
        $this->where = count($this->q_and) > 0 ? $where . " AND (" . implode(" AND ", $this->q_and) . ")" : $this->where;
        return $this->where;
    }

    function createOrderBy($fields, $dt_order) {
        $field_order = explode(":", $fields[$dt_order[0]["column"]]);
        $this->orderBy = $this->prefix . '.' . $field_order[0] . ' ' . $dt_order[0]["dir"] . ' ';
        return $this->orderBy;
    }

    function addField($field = array()) {
        $this->fields[] = $field;
        return $this;
    }

    function addTab($tab = array()) {
        $this->tabs[] = $tab;
        return $this;
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

    public function datatableAction($ctrl, $app, $url) {

        return $this->render('elements/datatable.twig', array(
                    'url' => $url,
                    'ctrl' => $ctrl,
                    'app' => $app,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    public function tabAction($ctrl, $app, $url, $action) {
        return $this->form($ctrl, $app, $url, $action);
    }

    public function tabsAction($ctrl, $app, $url) {
        return $this->render('elements/tabs.twig', array(
                    'pagename' => 'Customers',
                    'url' => $url,
                    'ctrl' => $ctrl,
                    'app' => $app,
                    'type' => '',
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    public function form1() {
        return $this->get('twig')->render('elements/forms_1.twig');
    }
    public function form2() {
        return $this->get('twig')->render('elements/forms_2.twig');
    }
}
