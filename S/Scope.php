<?php
namespace S;

class Scope
{
    public $data = []; // @todo temporary public

    public function __construct($data) {
        $this->data = $data;
    }

    public function get($key)
    {
        $parts = explode($key, '.');
        $value = array_pop($parts);
        $current = $this->data;
        foreach ($parts as $level) {
            if (is_array($current) and  array_key_exists($level, $current)) {
                $current = $current[$level];
            } else {
                return false;
            }
        }
        if (is_array($current)) {
            if (isset($current[$value])) {
                return $current[$value];
            }
            return false;
        } elseif ($current === $value) {
            return $value;
        }
        return false;
    }

    public function filter($data) {
        $result = [];
        foreach ($data as $key => $changes) {
            $value = $this->get($key);
            if ($value) {
                $result = array_replace_recursive($result, $changes);
            }
        }
        return $result;
    }

}
