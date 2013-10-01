<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vistepanenko
 * Date: 11.09.13
 * Time: 20:00
 * To change this template use File | Settings | File Templates.
 */

namespace S\Doctrine;


class EntityConfigGenerator
{
    protected $data;
    protected $mainClass;
    protected $mainTable;

    public function generateAndWrite($cfg, $folder)
    {
        if (!file_exists($folder)) {
            mkdir($folder);
        }
        $data = $this->generate($cfg);
        foreach ($data as $class => $record) {
            $fn = $this->determinateYmlFileName($class);
            $yaml = \Symfony\Component\Yaml\Yaml::dump(
                [$class => $record],
                4
            );
            file_put_contents($folder . DIRECTORY_SEPARATOR . $fn, $yaml);
        }
    }

    public function generate($cfg)
    {
        $this->mainClass = $this->determinateClassName($cfg);
        $this->mainTable = $this->determinateTableName($this->mainClass);
        $this->data = [
            $this->mainClass => [
                'type' => 'entity',
                'table' => $this->mainTable,
                'id' => $this->determinateId($cfg),
                'lifecycleCallbacks' => [
                    'prePersist' => ['prePersist'],
                    'postPersist' => ['postPersist'],
                ]
            ]
        ];
        $this->data[$this->mainClass]['fields'] = $this->determinateFields($cfg);
        return $this->data;
    }

    protected function determinateId(&$cfg)
    {
        return [
            'id' => [
                'type' => 'integer',
                'generator' => [
                    'strategy' => 'AUTO'
                ]
            ]
        ];
    }

    protected function determinateTableName($className)
    {
        return strtolower(str_replace('\\', '_', $className));
    }

    protected function plural($name)
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

    protected function determinateClassName(&$cfg)
    {
        $name = $cfg['name'];
        $area = $cfg['area'];
        return str_replace('.', '\\', $area) . '\\' . $name;
    }

    protected function determinateYmlFileName($className)
    {
        return str_replace('\\', '.', $className) . '.dcm.yml';
    }


    protected function determinateFields(&$cfg)
    {
        $fieldsCfg = $cfg['fields'];
        $fields = [];
        foreach ($fieldsCfg as $name => $fieldCfg) {
            $data = $this->processField($name, $fieldCfg, $cfg);
            if ($data) {
                $fields[$name] = $data;
            }
        }

        return $fields;
    }

    protected function sanitizeFieldData($fieldCfg)
    {
        unset($fieldCfg['scopes']);
        unset($fieldCfg['name']);
        return $fieldCfg;
    }

    protected function processField($name, $fieldCfg, $cfg)
    {
        if ($this->processFieldScopes($name, $fieldCfg, $cfg)) {
            return false;
        }
        return $this->sanitizeFieldData($fieldCfg);
    }

    protected function processFieldScopes($name, $fieldCfg, $cfg)
    {
        if (empty($fieldCfg['scopes'])) {
            return false;
        }
        $scopes = $fieldCfg['scopes'];

        $className = $this->mainClass . '_' . join('_', array_map('ucfirst', $scopes));

        // creating scope object
        if (!isset($this->data[$className])) {
            $tableName = $this->determinateTableName($className);
            $parts = explode('\\',$this->mainClass);
            $basicName = strtolower(array_pop($parts));
            $partialToMainRelationName = $basicName;
            $mainToPartialRelationName = $this->plural(str_replace($this->mainTable, 'scope', $tableName));

            $this->data[$className] = [
                'type' => 'entity',
                'table' => $tableName,
                'fields' => [],
                'id' => [
                    $basicName => [
                        'associationKey' => true,
                    ]
                ]
            ];

            // add fields to id
            foreach ($scopes as $scope) {
                $this->data[$className]['id'][$scope] = [
                    'type' => 'string',
                    'generator' => [
                        'strategy' => 'NONE'
                    ]
                ];
            }

            // create relation between main and scope objects


            $this->data[$className]['manyToOne'][$partialToMainRelationName] = [
                'targetEntity' => $this->mainClass,
                'inversedBy' => $mainToPartialRelationName
            ];
            $this->data[$this->mainClass]['oneToMany'][$mainToPartialRelationName] = [
                'targetEntity' => $className,
                'mappedBy' => $partialToMainRelationName
            ];
        }
        // add field to scope object
        $this->data[$className]['fields'][$name] = $this->sanitizeFieldData($fieldCfg);
        return true;

    }


    protected function addField($className, $name, $cfg)
    {
        if (!isset($this->data[$className])) {
            $this->data[$className] = [
                'type' => 'entity',
                'fields' => []
            ];
        }
        $this->data[$className]['fields'][$name] = $cfg;
    }

}