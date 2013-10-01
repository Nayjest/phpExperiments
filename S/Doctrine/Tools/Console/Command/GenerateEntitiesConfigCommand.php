<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vistepanenko
 * Date: 27.09.13
 * Time: 19:55
 * To change this template use File | Settings | File Templates.
 */

namespace S\Doctrine\Tools\Console\Command;

use Symfony\Component\Console\Command\Command;
use S\Doctrine\Tools\EntityConfigGenerator;
use \S\Meta;

class GenerateEntitiesConfigCommand  extends Command {

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $classes = Meta::getEntityClassNames();
        $cg = new EntityConfigGenerator();
        foreach ($classes as $className) {
            $cfg = $cg->generate($className);
            foreach ($cfg as $class => $record) {
                $fn = str_replace('\\', '.', $class) . '.dcm.yml';
                $yaml = \Symfony\Component\Yaml\Yaml::dump(
                    [$class => $record],
                    4
                );
                file_put_contents('runtime' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . $fn, $yaml);
            }
        }
    }

}