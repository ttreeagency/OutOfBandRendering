<?php
declare(strict_types=1);

namespace Ttree\OutOfBandRendering\Domain\Model;

use Neos\Flow\Annotations as Flow;
use Neos\Cache\Frontend\StringFrontend;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Ttree\OutOfBandRendering\Exception\DynamicPresetPathException;
use Ttree\OutOfBandRendering\Exception\InvalidPresetDefinitionName;

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

    protected string $name;

    public function __construct(string $name)
    {
        if (!str_starts_with($name, '@')) throw new InvalidPresetDefinitionName('Missing @ prefix', 1705293616);
        $this->name = (string)$name;
    }

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
    public function canHandle(NodeInterface $node): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getFusionPath(NodeInterface $node): string
    {
        $cacheKey = hash('sha256', substr(trim($this->name), 1));
        if (!$this->cache->has($cacheKey)) throw new DynamicPresetPathException(sprintf('Fusion path not found, key=%s', $cacheKey));
        return $this->cache->get($cacheKey);
    }
}
