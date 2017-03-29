<?php
namespace Ttree\OutOfBandRendering\Domain\Model;

use Neos\ContentRepository\Domain\Model\NodeInterface;

/**
 * Preset Definition Interface
 */
interface PresetDefinitionInterface {

    /**
     * Return the priority of this PresetDefinition. PresetDefinitions with a high priority are chosen before low priority.
     *
     * @return integer
     * @api
     */
    public function getPriority();

    /**
     * @return string
     */
    public function getName();

    /**
     * Here, the PresetDefinition can do some additional runtime checks to see whether
     * it can handle the given node.
     *
     * @param NodeInterface $node
     * @return boolean TRUE
     * @api
     */
    public function canHandle(NodeInterface $node);

    /**
     * @param NodeInterface $node
     * @return string
     */
    public function getTypoScriptPath(NodeInterface $node);

}
