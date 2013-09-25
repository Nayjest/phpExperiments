<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vistepanenko
 * Date: 11.09.13
 * Time: 19:56
 * To change this template use File | Settings | File Templates.
 */

namespace S\Config;


class Object extends AbstractConfig {

    public function initialize($config) {
        $fields = $config['fields'];
        foreach ($fields as $name=>$field) {

        }
        unset($config['fields']);
        parent::initialize($config);
    }

    public function getScopes() {
        $d = $this->_data;
        $scopes =  (isset($d['scopes']))?$d['scopes']:[];
    }
}