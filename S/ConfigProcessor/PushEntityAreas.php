<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vistepanenko
 * Date: 27.09.13
 * Time: 17:49
 * To change this template use File | Settings | File Templates.
 */

namespace S\ConfigProcessor;


class PushEntityAreas implements IConfigProcessor
{

    /**
     * @param array $cfg objects config
     * @return array
     */
    public function process(array &$cfg) {
        if (empty($cfg['areas'])) {
            return $cfg;
        }
        foreach($cfg['areas'] as $areaName => &$data) {
            if (empty($data['entities'])) {
                continue;
            }
            foreach ($data['entities'] as $entityName => &$entity) {
                if (empty($entity['name'])) {
                    $entity['name'] = $entityName;
                }
                $entity['area'] = $areaName;

            }
        }
    }
}