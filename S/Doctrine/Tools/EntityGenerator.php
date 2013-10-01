<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vistepanenko
 * Date: 26.09.13
 * Time: 15:38
 * To change this template use File | Settings | File Templates.
 */

namespace S\Doctrine\Tools;

use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\Common\Util\Inflector;
use Doctrine\DBAL\Types\Type;

use \S\Meta;

/**
 * Generic class used to generate PHP5 entity classes from ClassMetadataInfo instances.
 *
 *     [php]
 *     $classes = $em->getClassMetadataFactory()->getAllMetadata();
 *
 *     $generator = new \Doctrine\ORM\Tools\EntityGenerator();
 *     $generator->setGenerateAnnotations(true);
 *     $generator->setGenerateStubMethods(true);
 *     $generator->setRegenerateEntityIfExists(false);
 *     $generator->setUpdateEntityIfExists(true);
 *     $generator->generate($classes, '/path/to/generate/entities');
 *
 *
 * @link    www.doctrine-project.org
 * @since   2.0
 * @author  Benjamin Eberlei <kontakt@beberlei.de>
 * @author  Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author  Jonathan Wage <jonwage@gmail.com>
 * @author  Roman Borschel <roman@code-factory.org>
 */
class EntityGenerator extends \Doctrine\ORM\Tools\EntityGenerator
{

    /**
     * @var string
     */
    protected static $classTemplate =
'<?php

<namespace>

use Doctrine\ORM\Mapping as ORM;

<entityAnnotation>
<entityClassName>
{
<entitySExtension>
<entityBody>
}
';
    /**
     * Generates a PHP5 Doctrine 2 entity class from the given ClassMetadataInfo instance.
     *
     * @param ClassMetadataInfo $metadata
     *
     * @return string
     */
    public function generateEntityClass(ClassMetadataInfo $metadata)
    {

        $md =  Meta::getEntityByClassName($metadata->getName());
        if (!$md) {
            return parent::generateEntityClass($metadata);
        }

        $placeHolders = array(
            '<namespace>',
            '<entityAnnotation>',
            '<entityClassName>',
            '<entityBody>',
            '<entitySExtension>'
        );

        $replacements = array(
            $this->generateEntityNamespace($metadata),
            $this->generateEntityDocBlock($metadata),
            $this->generateEntityClassName($metadata),
            $this->generateEntityBody($metadata),
            $this->generateEntitySExtension($md, $metadata)
        );

        $code = str_replace($placeHolders, $replacements, self::$classTemplate);

        return str_replace('<spaces>', $this->spaces, $code);
    }

    public function generateEntitySExtension($md, $metadata) {
        $src = '<spaces>use \S\Doctrine\ScopedEntity;';
        return $src;
    }



    /**
     * @param ClassMetadataInfo $metadata
     *
     * @return string
     */
    protected function generateEntityLifecycleCallbackMethods(ClassMetadataInfo $metadata)
    {
//        if (isset($metadata->lifecycleCallbacks) && $metadata->lifecycleCallbacks) {
//            $methods = array();
//
//            foreach ($metadata->lifecycleCallbacks as $name => $callbacks) {
//                foreach ($callbacks as $callback) {
//                    if ($code = $this->generateLifecycleCallbackMethod($name, $callback, $metadata)) {
//                        $methods[] = $code;
//                    }
//                }
//            }
//
//            return implode("\n\n", $methods);
//        }

        return "";
    }

}
