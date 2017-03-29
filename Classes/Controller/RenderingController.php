<?php
namespace Ttree\OutOfBandRendering\Controller;

use Ttree\OutOfBandRendering\Factory\PresetDefinitionFactory;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Exception;
use Neos\Flow\Mvc\Controller\ActionController;
use Neos\Flow\Property\PropertyMapper;
use Neos\Neos\Controller\Exception\NodeNotFoundException;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Fusion\View\FusionView;

/**
 * Suggest Controller
 */
class RenderingController extends ActionController {

    /**
     * @var FusionView
     */
    protected $view;

    /**
     * @var string
     */
    protected $defaultViewObjectName = 'Neos\Neos\View\FusionView';

    /**
     * @var PropertyMapper
     * @Flow\Inject
     */
    protected $propertyMapper;

    /**
     * @Flow\Inject
     * @var PresetDefinitionFactory
     */
    protected $presetDefinitionFactory;

    /**
     * @param string $node
     * @param string $preset
     * @throws Exception
     */
    public function showAction($node, $preset) {
        /** @var NodeInterface $node */
        $node = $this->propertyMapper->convert($node, 'Neos\ContentRepository\Domain\Model\NodeInterface');
        if ($node === NULL) {
            throw new NodeNotFoundException('The requested node does not exist or isn\'t accessible to the current user', 1442327533);
        }
        $this->view->assign('value', $node);
        $presetDefinition = $this->presetDefinitionFactory->create($preset, $node);
        $this->view->setFusionPath($presetDefinition->getTypoScriptPath($node));
    }

}
