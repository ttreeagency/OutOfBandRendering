<?php
declare(strict_types=1);

namespace Ttree\OutOfBandRendering\Domain\Model;

use Neos\Flow\Annotations as Flow;

/**
 * Dynamic Preset Definition
 */
class DynamicPresetName
{
    protected string $name;

    protected function __construct(string $name)
    {
        if (!str_starts_with($name, '@')) throw new \InvalidArgumentException('Missing @ prefix', 1705293616);
        $this->name = trim($name);
    }

    public static function fromSegment(string $name)
    {
        $name = trim($name);
        if (str_starts_with($name, '@')) {
            return new DynamicPresetName($name);
        }
        return new DynamicPresetName(sprintf('@%s', $name));
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHash(): string
    {
        return hash('sha256', $this->name);
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
