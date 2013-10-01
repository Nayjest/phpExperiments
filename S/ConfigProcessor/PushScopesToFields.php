<?php
namespace S\ConfigProcessor;
use S\ConfigProcessor\IConfigProcessor;

/**
 * Class PushScopesToFields
 *
 * Class processes object configuration,
 * Moves scopes defined on object configuration level to configuration of fields
 *
 * ==== Example: ====
 * before:
 * [
 *     'fields' => [
 *         'name' => [
 *             'type' => 'String',
 *          ]
 *     ],
 *     'scopes' => ['store', 'lang']
 * ]
 * after:
 * [
 *     'fields' => [
 *         'name' => [
 *             'type' => 'String',
 *             'scopes' => ['lang']
 *          ],
 *         'description' => [
 *             'type' => 'String',
 *             'scopes' => ['lang']
 *          ]
 *     ],
 *     'scopes' => [
 *         'lang' => ['name', 'description']
 *     ]
 * ]
 *
 *
 *
 * @package S\ConfigProcessor
 */
class PushScopesToFields implements IConfigProcessor
{

    /**
     * @param array $cfg objects config
     * @return array
     */
    public function process(array &$cfg)
    {

        if (empty($cfg['scopes']) or empty($cfg['fields'])) {
            return $cfg;
        }

        $fieldNames = array_keys($cfg['fields']);

        foreach ($fieldNames as $fieldName) {
            foreach ($cfg['scopes'] as $scopeName => $scopeFields) {
                if (in_array($fieldName, $scopeFields)) {
                    if (isset($cfg['fields'][$fieldName]['scopes'])) {
                        $cfg['fields'][$fieldName]['scopes'][] = $scopeName;
                    } else {
                        $cfg['fields'][$fieldName]['scopes'] = [$scopeName];
                    }
                }
            }
        }
        return $cfg;

    }

}
