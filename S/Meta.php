<?php

namespace S;

use \S\Doctrine\NamingConvention;
use \S\Meta\Entity;

class Meta
{
    private static $cfg;

    public static function initialize(array $data)
    {
        self::$cfg = $data;
    }

    public static function getEntityByClassName($className)
    {

        if ($className[0] == '\\') {
            $className = substr($className, 1);
        }
        $parts = explode('\\', $className);
        $name = array_pop($parts);
        $area = join($parts, '.');

        if (empty(self::$cfg['areas'][$area]['entities'][$name])) {
            return null;
        }
        return new Entity(self::$cfg['areas'][$area]['entities'][$name]);
    }

    public static function getEntityClassNames()
    {
        $config  = self::$cfg;
        if (empty($config) or empty($config['areas'])) {
            return [];
        }
        $classes = [];
        foreach ($config['areas'] as $areaName => $areaData) {
            if (empty($areaData['entities'])) {
                continue;
            }
            foreach ($areaData['entities'] as $name => $classData) {
                $classes[] = NamingConvention::getClassByAlias($areaName . '.' . $name);
            }
        }
        return $classes;
    }
}