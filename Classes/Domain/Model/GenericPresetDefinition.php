<?php
declare(strict_types=1);

namespace Ttree\OutOfBandRendering\Domain\Model;

use Neos\ContentRepository\Core\Projection\ContentGraph\Node;

/**
 * Generic Preset Definition
 */
class GenericPresetDefinition extends AbstractPresetDefinition
{
    protected string $name;

    protected string $path;

    public function __construct(string $name, array $configuration)
    {
        $this->name = (string)$name;
        $this->path = (string)$configuration['path'];
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * {@inheritdoc}
     */
    public function canHandle(Node $node): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getFusionPath(Node $node): string
    {
        return $this->path;
    }
}
