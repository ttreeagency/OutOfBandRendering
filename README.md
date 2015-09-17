# TypoScript Out of Band rendering helpers

This package provide some helpers to work with TypoScript Out of Band rendering in Neos CMS

**Package under development, API can change at any time**

How to use ?
------------

Edit your distribution ```Routes.yaml``` and add the required routes:

    -
      name: 'Ttree.OutOfBandRendering'
      uriPattern: '<TtreeOutOfBandRenderingSubroutes>'
      subRoutes:
        'TtreeOutOfBandRenderingSubroutes':
          package: 'Ttree.OutOfBandRendering'
          variables:
            'defaultUriSuffix': ''
            
With this configuration you can access the URL endpoint at ```http://www.domain.com/api/v1/rendering```.

Check the [Routes.yaml](Configuration/Routes.yaml) in this package, if you need a custom URL.
    
Make it work
------------

The endpoint require two parameters:

- **node**: the full node path of the rendering node
- **preset**: the preset name, check bellow for informations about Presets

You need a ```PresetDefintion``` object, the easy way is to extend the ```AbstractPresetDefinition``` like this:

```php

use Ttree\OutOfBandRendering\Domain\Model\AbstractPresetDefinition;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;

class CustomPresetPresetDefinition extends AbstractPresetDefinition  {

    /**
     * @param NodeInterface $node
     * @return string
     */
    public function getTypoScriptPath(NodeInterface $node) {
        return 'page<Ttree.ArchitectesCh:DefaultPage>/body<TYPO3.TypoScript:Template>/content/main<TYPO3.Neos:PrimaryContent>/enterpriseProfile<TYPO3.TypoScript:Matcher>/element<Ttree.ArchitectesCh:EnterpriseProfile>/reportSection<Ttree.ArchitectesCh:EnterpriseProfileSection>/content<Ttree.ArchitectesCh:ReportMenu>';
    }
}

```

The ```PresetDefinitionInterface``` force you to defined the following methods:

- **PresetDefinitionInterface::getPriority**: Return an integer to define the preset priority (higher has more priority, like in the Flow Framework PropertyMapper
- **PresetDefinitionInterface::getName**: Return the name of the preset (used in the endpoint URL)
- **PresetDefinitionInterface::canHandle**: Receive the current document node as argument, and allow you to add more logic to decide if a preset can handle the given node
- **PresetDefinitionInterface::getTypoScriptPath**: Receive the current document node as argument, must return the TypoScript path to render

What's next ?
-------------

- Implement authorization support

Acknowledgments
---------------

Development sponsored by [ttree ltd - neos solution provider](http://ttree.ch).

We try our best to craft this package with a lots of love, we are open to
sponsoring, support request, ... just contact us.

License
-------

Licensed under MIT, see [LICENSE](LICENSE)
