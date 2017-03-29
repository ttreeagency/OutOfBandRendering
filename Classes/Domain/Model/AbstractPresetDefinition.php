<?php
namespace Ttree\OutOfBandRendering\Domain\Model;

use Neos\ContentRepository\Domain\Model\NodeInterface;

/**
 * Abstract Preset Definition
 */
abstract class AbstractPresetDefinition implements PresetDefinitionInterface {

    /**
     * {@inheritdoc}
     *
     * @var integer
     */
    protected $priority = 1;

    /**
     * {@inheritdoc}
     *
     * @return integer
     */
    public function getName() {
        $calledClassName = explode('\\', get_called_class());
        return strtolower(trim(preg_replace('/([A-Z])/', '-$1', str_replace('PresetDefinition', '', array_pop($calledClassName))), '-'));
    }

    /**
     * {@inheritdoc}
     *
     * @return integer
     */
    public function getPriority() {
        return $this->priority;
    }

    /**
     * {@inheritdoc}
     *
     * @param NodeInterface $node
     * @return boolean
     */
    public function canHandle(NodeInterface $node) {
        return TRUE;
    }

}
