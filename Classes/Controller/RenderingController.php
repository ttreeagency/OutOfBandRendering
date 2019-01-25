<?php
namespace Ttree\OutOfBandRendering\Controller;

use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Exception;
use Neos\Flow\Mvc\Controller\ActionController;
use Neos\Flow\Property\PropertyMapper;
use Neos\Neos\Controller\Exception\NodeNotFoundException;
use Neos\Neos\View\FusionView;
use Ttree\OutOfBandRendering\Factory\PresetDefinitionFactory;

/**
 * Suggest Controller
 */
class RenderingController extends ActionController
{
    /**
     * @var FusionView
     */
    protected $view;

    /**
     * @var string
     */
    protected $defaultViewObjectName = FusionView::class;

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
    public function showAction(string $node, string $preset)
    {
        /** @var NodeInterface $node */
        $node = $this->propertyMapper->convert($node, NodeInterface::class);
        if ($node === null) {
            throw new NodeNotFoundException('The requested node does not exist or isn\'t accessible to the current user', 1442327533);
        }
        $this->view->assign('value', $node);
        $presetDefinition = $this->presetDefinitionFactory->create($preset, $node);
        $this->view->setFusionPath($presetDefinition->getFusionPath($node));
    }

}
