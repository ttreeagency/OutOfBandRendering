<?php
declare(strict_types=1);

namespace Ttree\OutOfBandRendering\Fusion;

use Neos\Cache\Frontend\StringFrontend;
use Neos\Flow\Annotations as Flow;
use Neos\Fusion\FusionObjects\AbstractFusionObject;

class RegisterPathImplementation extends AbstractFusionObject {

    /**
     * @Flow\Inject
     * @var StringFrontend
     */
    protected $cache;

    public function getValue(): string
    {
        return (string)$this->fusionValue('value');
    }

    public function getSegment(): string
    {
        return hash('sha256', (string)$this->fusionValue('segment'));
    }

    public function evaluate() {
        $segments = explode('__meta', $this->path);
        $path = rtrim(array_shift($segments), '/');
        $this->cache->set(
            $this->getSegment(),
            $path
        );
        return $this->getValue();
    }

}
