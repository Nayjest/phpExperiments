<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vistepanenko
 * Date: 11.09.13
 * Time: 19:41
 * To change this template use File | Settings | File Templates.
 */

namespace S\Config;


class AbstractConfig {

    use \S\ConfigurableObject;

    private $_data;

    public function initializeFields($config) {
        $this->_data = $config;
    }


    public function __get($name) {
        return $this->_data[$name];
    }

    /**
     * @todo remove
     */
    public function __set($name, $value) {
        return $this->_data[$name] = $value;
    }

}