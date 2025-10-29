<?php
namespace Ttree\OutOfBandRendering\Domain\Model;

use Neos\ContentRepository\Core\Projection\ContentGraph\Node;

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
     * @param Node $node
     * @return bool TRUE
     * @api
     */
    public function canHandle(Node $node): bool;

    /**
     * @param Node $node
     * @return string
     */
    public function getFusionPath(Node $node): string;
}
