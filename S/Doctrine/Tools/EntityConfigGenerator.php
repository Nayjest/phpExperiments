<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vistepanenko
 * Date: 27.09.13
 * Time: 19:14
 * To change this template use File | Settings | File Templates.
 */

namespace S\Doctrine\Tools;

use S\Doctrine\NamingConvention;
use \S\Meta;
use \S\Meta\Entity;
use \S\Meta\Field;

class EntityConfigGenerator
{
    protected $data;

    /**
     * @var \S\Meta\Entity
     */
    protected $meta;

    public function generate($className)
    {
        $this->meta = Meta::getEntityByClassName($className);
        $this->data = [
            $className => [
                'type' => 'entity',
                'table' => $this->meta->getTable(),
                'id' => $this->generateId(),
                'fields' => [],
                'lifecycleCallbacks' => [
                    // required to persist partial scope-related objects
                    'postPersist' => ['postPersist'],
                ]
            ]
        ];
        $this->processFields();
        return $this->data;
    }

    protected function generateId()
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

    protected function processFields()
    {
        /** @var $field \S\Meta\Field */
        foreach ($this->meta->getFields() as $field) {
            if ($field->isNativeEntityField()) {
                $this->data['fields'][$field->name] = $this->generateField($field);
            } else {
                if (!empty($field->scopes)) {
                    $this->processScopedField($field);
                } else {
                    throw new \Exception("Error generating {$field->name} field");
                }
            }

        }
    }


    /**
     * @param Field $field
     * @return array
     */
    protected function generateField(Field $field)
    {
        return [
            'type' => $field->type
        ];

    }


    /**
     * @param Field $field
     * @return bool
     */
    protected function processScopedField(Field $field)
    {

        $className = $field->getStoringClassName();

        // creating scope object
        if (!isset($this->data[$className])) {
            $tableName = NamingConvention::getTableNameByClass($className);


            $partialToMainRelationName = NamingConvention::getRelationName($this->meta->getClassName());
            $mainToPartialRelationName = NamingConvention::plural(
                NamingConvention::getRelationName($className)
            );
            $this->data[$className] = [
                'type' => 'entity',
                'table' => $tableName,
                'fields' => [],
                'id' => [
                    $partialToMainRelationName => [
                        'associationKey' => true,
                    ]
                ]
            ];

            // add fields to id
            foreach ($field->scopes as $scope) {
                $this->data[$className]['id'][$scope] = [
                    'type' => 'string',
                    'generator' => [
                        'strategy' => 'NONE'
                    ]
                ];
            }

            // create relation between main and scope objects
            $this->data[$className]['manyToOne'][$partialToMainRelationName] = [
                'targetEntity' => $this->meta->getClassName(),
                'inversedBy' => $mainToPartialRelationName
            ];
            $this->data[$this->mainClass]['oneToMany'][$mainToPartialRelationName] = [
                'targetEntity' => $className,
                'mappedBy' => $partialToMainRelationName
            ];
        }
        // add field to scope object
        $this->data[$className]['fields'][$field->name] = $this->generateField($field);
    }

}