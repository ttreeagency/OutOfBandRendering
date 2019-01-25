<?php
namespace Ttree\OutOfBandRendering\Domain\Model;

use Neos\ContentRepository\Domain\Model\NodeInterface;

/**
 * Preset Definition Interface
 */
interface PresetDefinitionInterface
{
    /**
     * Return the priority of this PresetDefinition. PresetDefinitions with a high priority are chosen before low priority.
     *
     * @return int
     * @api
     */
    public function getPriority(): int;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * Here, the PresetDefinition can do some additional runtime checks to see whether
     * it can handle the given node.
     *
     * @param NodeInterface $node
     * @return bool TRUE
     * @api
     */
    public function canHandle(NodeInterface $node): bool;

    /**
     * @param NodeInterface $node
     * @return string
     */
    public function getFusionPath(NodeInterface $node): string;
}
