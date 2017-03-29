<?php
namespace Ttree\OutOfBandRendering\Factory;

use Ttree\OutOfBandRendering\Domain\Model\GenericPresetDefinition;
use Ttree\OutOfBandRendering\Domain\Model\PresetDefinitionInterface;
use Ttree\OutOfBandRendering\Exception\DuplicatePresetDefinitionException;
use Ttree\OutOfBandRendering\Exception\PresetNotFoundException;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\ObjectManagement\ObjectManagerInterface;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Flow\Reflection\ReflectionService;

/**
 * Preset Definition Factory
 *
 * @Flow\Scope("singleton")
 * @api
 */
class PresetDefinitionFactory {

    const PRESET_DEFINITION_INTERFACE = PresetDefinitionInterface::class;

    /**
     * @Flow\Inject
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var array
     */
    protected $presetDefinitions = [];

    /**
     * @Flow\InjectConfiguration(path="presets")
     * @var array
     */
    protected $staticPresets;

    /**
     * @var boolean
     */
    protected $initialized = FALSE;

    /**
     * @param $presetName
     * @param NodeInterface $node
     * @return PresetDefinitionInterface
     * @throws PresetNotFoundException
     */
    public function create($presetName, NodeInterface $node) {
        $this->initialize();
        if (!isset($this->presetDefinitions[$presetName]) && !isset($this->staticPresets[$presetName])) {
            throw new PresetNotFoundException(sprintf('Preset "%s" not found', $presetName), 1442471214);
        }
        if (!isset($this->presetDefinitions[$presetName]) && isset($this->staticPresets[$presetName])) {
            return new GenericPresetDefinition($presetName, $this->staticPresets[$presetName]);
        }
        foreach ($this->presetDefinitions[$presetName] as $presetDefinition) {
            /** @var PresetDefinitionInterface $presetDefinition */
            if ($presetDefinition->canHandle($node)) {
                return $presetDefinition;
            }
        }
        throw new PresetNotFoundException(sprintf('Unable to found a preset named "%s" to handle a node with identifier "%s"', $presetName, $node->getIdentifier()), 1442471333);
    }

    /**
     * Returns all class names implementing the TypeConverterInterface.
     *
     * @param ObjectManagerInterface $objectManager
     * @return array Array of preset definition implementations
     * @Flow\CompileStatic
     */
    static public function getPresetDefinitionImplementationClassNames($objectManager) {
        $reflectionService = $objectManager->get(ReflectionService::class);
        return $reflectionService->getAllImplementationClassNamesForInterface(self::PRESET_DEFINITION_INTERFACE);
    }

    /**
     * @return void
     * @throws DuplicatePresetDefinitionException
     */
    protected function initialize() {
        if ($this->initialized === TRUE) {
            return;
        }
        $classNames = static::getPresetDefinitionImplementationClassNames($this->objectManager);
        foreach ($classNames as $className) {
            if ($className === GenericPresetDefinition::class) {
                continue;
            }
            /** @var PresetDefinitionInterface $presetDefinition */
            $presetDefinition = $this->objectManager->get($className);
            if (isset($this->presetDefinitions[$presetDefinition->getName()][$presetDefinition->getPriority()])) {
                throw new DuplicatePresetDefinitionException('There exist at least two preset definitions which handle the preset named "' . $presetDefinition->getName() . '" with priority "' . $presetDefinition->getPriority(), 1442471005);
            }
            $this->presetDefinitions[$presetDefinition->getName()][$presetDefinition->getPriority()] = $presetDefinition;
        }
        $this->initialized = TRUE;
    }

}
