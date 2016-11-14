<?php

namespace App;

use \PDO;

class MyPDO extends PDO {

    const PARAM_host='localhost';
    const PARAM_port='3306';
    const PARAM_db_name='testsoap';
    const PARAM_user='root';
    const PARAM_db_pass='';

    public function __construct($options=null){
        parent::__construct('mysql:host='.MyPDO::PARAM_host.';port='.MyPDO::PARAM_port.';dbname='.MyPDO::PARAM_db_name, MyPDO::PARAM_user, MyPDO::PARAM_db_pass, $options);
        parent::setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }

    /**
     * $db->query("DELETE FROM table_test WHERE t1=? AND t2=? AND t3=?",$t1,$t2,$t3);
     * @param string $query
     * @return PDOStatement
     */
    public function execute($query){ //secured query with prepare and execute
        $args = func_get_args();
        array_shift($args); //first element is not an argument but the query itself, should removed

        $reponse = parent::prepare($query);
        $reponse->execute($args);
        return $reponse;
    }

    /**
     * $ret = $db->query("SELECT * FROM table_test WHERE t1=? AND t2=? AND t3=?",$t1,$t2,$t3);
     * @param string $query
     * @return array
     */
    public function query($query){ //secured query with prepare and execute
        $args = func_get_args();
        array_shift($args); //first element is not an argument but the query itself, should removed

        $reponse = parent::prepare($query);
        $reponse->execute($args);
        return $reponse->fetchAll();
    }
}