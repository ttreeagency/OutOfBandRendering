<?php
namespace Carbon\OutOfBandRendering\Domain\Model;

use Neos\ContentRepository\Domain\Model\NodeInterface;

/**
 * Abstract Preset Definition
 */
class GenericPresetDefinition extends AbstractPresetDefinition
{
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
    public function __construct(string $name, array $configuration)
    {
        $this->name = (string)$name;
        $this->path = (string)$configuration['path'];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
     * @param NodeInterface $node
     * @return bool
     */
    public function canHandle(NodeInterface $node): bool
    {
        return true;
    }

    /**
     * @param NodeInterface $node
     * @return string
     */
    public function getFusionPath(NodeInterface $node): string
    {
        return $this->path;
    }
}
