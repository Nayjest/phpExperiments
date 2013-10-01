<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vistepanenko
 * Date: 25.09.13
 * Time: 17:58
 * To change this template use File | Settings | File Templates.
 */

namespace S\Doctrine;


class NamingConvention
{
    public static function getClassByAlias($alias)
    {
        return str_replace('.','\\',$alias);
//        $parts = explode('.', $alias);
//        $parts = array_map('ucfirst', $parts);
//        return join('\\', $parts);
    }

    public static function getTableNameByClass($className)
    {
        if ($className[0] == '\\') {
            $className = substr($className, 1);
        }
        return strtolower(str_replace('\\', '_', $className));
    }

    public static function getAliasByClass($className)
    {
        if ($className[0] == '\\') {
            $className = substr($className, 1);
        }
        return str_replace('\\','.',$className);
//        $parts = explode('\\', $className);
//        return join('.', $parts);
    }

    public static function getAreaByClass($className) {
        list($area, $name)  = static::getAreaAndNameByClass($className);
        return $area;
    }

    public static function getAreaAndNameByClass($className) {
        if ($className[0] == '\\') {
            $className = substr($className, 1);
        }
        $parts = explode('\\', $className);
        $name = array_pop($parts);
        $area = join($parts, '.');
        return [$area, $name];
    }

    public static function getRelationName($className) {
        list($area, $name)  = static::getAreaAndNameByClass($className);
        return strtolower($name);
    }

    public static function plural($name)
    {
        $last = strlen($name) - 1;
        switch ($name[$last]) {
            case 'y':
                $vowels = ['a', 'e', 'i', 'o', 'u', 'y'];
                if ($last > 0 and !in_array($name[$last - 1], $vowels)) {
                    $name[$last] = 'i';
                    return ($name . 'es');
                }
                break;
            case 's':
            case 'x':
            case 'o':
                return ($name . 'es');
            case 'h':
                if ($last > 0 and ($name[$last - 1] == 's' or $name[$last - 1] == 'c')) {
                    return ($name . 'es');
                }
        }
        return ($name . 's');
    }


}