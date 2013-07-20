<?php
namespace S;

use \S\ConfigurableObject;
use \S\Scope;

trait ScopesSupport
{
    use ConfigurableObject;

    private $config;
    private $scope;

    /**
     * @param $config
     * @param Scope | null $scope
     */
    protected function initialize($config, $scope = null) {
        $this->scope = $scope;
        $this->config  = $config; // @todo issue if config have config field
        $this->initializeFields(
            array_replace_recursive(
                $this->getDefaults(),
                $config,
                $scope ? $this->getScopeChanges($scope): []
            )
        );
    }


    protected function getScopeChanges(Scope $scope) {
        if (empty($this->config['scopes'])) {
            return null;
        }
        $scopeDependencies = $this->config['scopes'];
        $delta = [];
        foreach ($scopeDependencies as $key => $changes) {
            $value = $scope->get($key);
            if ($value) {
                $delta = array_replace_recursive($delta, $changes);
            }
        }
        return $delta;
    }


    public function scope(Scope $scope) {
        $this->initializeFields(
           $this->getScopeChanges($scope)
        );
    }
}
