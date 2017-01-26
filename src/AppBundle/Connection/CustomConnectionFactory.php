<?php

namespace AppBundle\Connection;

use Doctrine\Bundle\DoctrineBundle\ConnectionFactory;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\Configuration;

class CustomConnectionFactory extends ConnectionFactory {

    public function createConnection(array $params, Configuration $config = null, EventManager $eventManager = null, array $mappingTypes = array()) {
        // Discover and override $params array here.
        // A real-world example might obtain them from zookeeper,
        // consul or etcd for example. You'll probably want to cache
        // anything you obtain from such a service too.
        //print_r($_SERVER);REMOTE_ADDR
        $params['driver'] = 'pdo_mysql';
        $params['host'] = 'localhost';
        $params['port'] = 3306;
        /*
          if ($_SERVER["REMOTE_ADDR"] == '127.0.0.1') {

          $params['dbname'] = 'partsbox_symfony';
          $params['user'] = 'root';
          $params['password'] = '123456';

          } else {
          $params['dbname'] = 'partsbox_db2';
          $params['user'] = 'partsbox';
          $params['password'] = ')7uT[LJOPyX$';
          }
         */
        $databale = @explode(".", $_SERVER["HTTP_HOST"]);
        if (@$_SERVER["COMPUTERNAME"] == 'ALEXANDERDIMEAS') {
            $params['dbname'] = 'partsbox_symfony6';
            $params['user'] = 'root';
            $params['password'] = '123456';
        } elseif ($databale[0]) {
            $params['dbname'] = 'partsbox_'.$databale[0];
            $params['user'] = 'partsbox';
            $params['password'] = ')7uT[LJOPyX$';     
        } else {
            $params['dbname'] = 'partsbox_symfony6';
            $params['user'] = 'root';
            $params['password'] = '123456';
            
            $params['dbname'] = 'partsbox_partsbox6';
            $params['user'] = 'partsbox';
            $params['password'] = ')7uT[LJOPyX$';   
            //            
            $params['dbname'] = 'partsbox_gratsias';
            $params['user'] = 'partsbox';
            $params['password'] = ')7uT[LJOPyX$';               
        }             

        return parent::createConnection($params, $config, $eventManager, $mappingTypes);
        /*
        if ($_SERVER["REQUEST_URI"] == '/account/test/asddasdgh') {
            return parent::createConnection($params, $config, $eventManager, $mappingTypes);
        } else {
            echo file_get_contents("http://localhost:8000/account/test/asddasdgh");
            return parent::createConnection($params, $config, $eventManager, $mappingTypes);
        }
         * 
         */
    }

}
