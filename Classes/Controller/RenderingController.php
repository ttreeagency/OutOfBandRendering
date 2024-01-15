<?php
namespace Ttree\OutOfBandRendering\Controller;

use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\ContentRepository\Domain\Projection\Content\TraversableNodes;
use Neos\ContentRepository\Domain\Service\ContextFactoryInterface;
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
     * @Flow\Inject
     */
    protected PropertyMapper $propertyMapper;

    /**
     * @Flow\Inject
     */
    protected ContextFactoryInterface $contentContext;

    /**
     * @Flow\Inject
     */
    protected PresetDefinitionFactory $presetDefinitionFactory;

    /**
     * @param string $node
     * @param string $preset
     * @throws Exception
     */
    public function showAction(string $node, string $preset)
    {
        $context = $this->contentContext->create();
        $node = $context->getNodeByIdentifier($node);
        if ($node === null) {
            $node = $this->propertyMapper->convert($node, NodeInterface::class);
            if (!$node instanceof TraversableNodes) throw new NodeNotFoundException('The requested node does not exist or isn\'t accessible to the current user', 1442327533);
        }

        $this->view->assign('value', $node);

        $presetDefinition = $this->presetDefinitionFactory->create($preset, $node);
        $this->view->setFusionPath($presetDefinition->getFusionPath($node));
    }

}
