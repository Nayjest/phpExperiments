<?php
namespace S\Meta;

class Validator {
    protected $function;
    protected $options;
    public function __construct($function, $options = []) {
        $this->function = $function;
        $this->options = $options;
    }

    public function validate($data) {
        return call_user_func($this->function, $data, $this->options);
    }

    public static function fromConfig($key, $options = []) {
        return new Validator($key, $options);
    }
}