<?php
namespace Ttree\OutOfBandRendering\Domain\Model;

use TYPO3\TYPO3CR\Domain\Model\NodeInterface;

/**
 * Abstract Preset Definition
 */
class GenericPresetDefinition extends AbstractPresetDefinition {

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $path;

    /**
     * @param string $name
     * @param array $configuration
     */
    public function __construct($name, array $configuration)
    {
        $this->name = (string)$name;
        $this->path = (string)$configuration['path'];
    }

    /**
     * @return integer
     */
    public function getName() {
        return $this->name;
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

    /**
     * @param NodeInterface $node
     * @return string
     */
    public function getTypoScriptPath(NodeInterface $node)
    {
        return $this->path;
    }
}
