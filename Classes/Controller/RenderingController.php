<?php
namespace Ttree\OutOfBandRendering\Controller;

use Neos\ContentRepository\Core\Projection\ContentGraph\Node;
use Neos\ContentRepository\Core\SharedModel\Node\NodeAddress;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Exception;
use Neos\Flow\Mvc\Controller\ActionController;
use Neos\Flow\Property\PropertyMapper;
use Neos\Neos\FrontendRouting\Exception\NodeNotFoundException;
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
    protected PresetDefinitionFactory $presetDefinitionFactory;

    #[\Neos\Flow\Annotations\Inject]
    protected \Neos\ContentRepositoryRegistry\ContentRepositoryRegistry $contentRepositoryRegistry;

    /**
     * @param string $node JSON encoded NodeAddress
     * @param string $preset
     * @throws Exception
     */
    public function showAction(string $node, string $preset)
    {
        $node = NodeAddress::fromJsonString($node);
        $contentRepository = $this->contentRepositoryRegistry->get($node->contentRepositoryId);
        $subgraph = $contentRepository->getContentSubgraph($node->workspaceName, $node->dimensionSpacePoint);

        $node = $subgraph->findNodeById($node->aggregateId);

        if (!$node instanceof Node) throw new NodeNotFoundException('The requested node does not exist or isn\'t accessible to the current user', 1442327533);

        $this->view->assign('value', $node);

        $presetDefinition = $this->presetDefinitionFactory->create($preset, $node);
        $this->view->setFusionPath($presetDefinition->getFusionPath($node));
    }

}
