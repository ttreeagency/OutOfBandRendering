<?php
namespace Ttree\OutOfBandRendering\Domain\Model;

use Neos\ContentRepository\Core\Projection\ContentGraph\Node;

/**
 * Abstract Preset Definition
 */
abstract class AbstractPresetDefinition implements PresetDefinitionInterface
{
    /**
     * Execution priority for the current preset definition
     */
    protected int $priority = 1;

    /**
     * {@inheritdoc}
     *
     * @return integer
     */
    public function getName(): string
    {
        $calledClassName = explode('\\', get_called_class());
        return strtolower(trim(preg_replace('/([A-Z])/', '-$1', str_replace('PresetDefinition', '', array_pop($calledClassName))), '-'));
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * {@inheritdoc}
     *
     * @param Node $node
     * @return bool
     */
    public function canHandle(Node $node): bool
    {
        return true;
    }
}
