<?php
class Utils {
    public static function constructFromConfig($instance, $config) {
        foreach ($config as $key => $value) {
            if (!property_exists($instance, $key)) {
                throw new \Exception ('Wrong configuration field: ' . $key);
            }
            $instance->$key = $value;
        }
        return $instance;
    }
}