<?php
declare(strict_types=1);

namespace Ttree\OutOfBandRendering\Domain\Model;

use Neos\Flow\Annotations as Flow;
use Neos\Cache\Frontend\StringFrontend;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Ttree\OutOfBandRendering\Exception\DynamicPresetPathException;

/**
 * Dynamic Preset Definition
 */
class DynamicPresetDefinition extends AbstractPresetDefinition
{
    /**
     * @Flow\Inject
     * @var StringFrontend
     */
    protected $cache;

    protected DynamicPresetName $name;

    public function __construct(string $name)
    {
        $this->name = DynamicPresetName::fromSegment($name);
    }

    public function getName(): string
    {
        return $this->name->getName();
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
    public function canHandle(NodeInterface $node): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getFusionPath(NodeInterface $node): string
    {
        $cacheKey = $this->name->getHash();
        if (!$this->cache->has($cacheKey)) throw new DynamicPresetPathException(sprintf('Fusion path not found, key=%s', $cacheKey));
        return $this->cache->get($cacheKey);
    }
}
