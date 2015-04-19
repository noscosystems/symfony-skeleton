<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    /**
     * Register Bundles
     *
     * @access public
     * @return array
     */
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new AppBundle\AppBundle(),
        ];

        $bundles = array_merge($bundles, $this->getCmfBundles());

        if (in_array($this->getEnvironment(), ['dev', 'test'])) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    /**
     * Get the bundles required if CMF functionality is enabled.
     *
     * @access protected
     * @return array
     */
    protected function getCmfBundles()
    {
        return [
            new Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle,
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle,
            new Doctrine\Bundle\PHPCRBundle\DoctrinePHPCRBundle,

            new Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle,
            new Symfony\Cmf\Bundle\RoutingAutoBundle\CmfRoutingAutoBundle,

            new Knp\Bundle\MenuBundle\KnpMenuBundle,
            new Sonata\CoreBundle\SonataCoreBundle,
            new Sonata\jQueryBundle\SonatajQueryBundle,
            new Sonata\BlockBundle\SonataBlockBundle,
            new Sonata\AdminBundle\SonataAdminBundle,
            new Sonata\DoctrinePHPCRAdminBundle\SonataDoctrinePHPCRAdminBundle,

            new FOS\JsRoutingBundle\FOSJsRoutingBundle,
            new Symfony\Cmf\Bundle\TreeBrowserBundle\CmfTreeBrowserBundle,

            new Symfony\Cmf\Bundle\CoreBundle\CmfCoreBundle,
            new Symfony\Cmf\Bundle\MenuBundle\CmfMenuBundle,
        ];
    }

    /**
     * Register Container Configuration
     *
     * @access public
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     * @return void
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(
            file_exists($config = __DIR__ . '/config/config_' . $this->getEnvironment() . '.yml')
                ? $config
                : __DIR__ . '/config/config.yml'
        );
        // Now we have loaded our configuration (and more importantly, parameters) - reload all environmental variables
        // named for Symfony into the parameter bag so that we can override the configuration quickly in an emergancy
        // without amending any application files (which may be specific to the current installation).
        // Don't forget to clear the cache after changing the environmental variables!
        $envParameters = $this->getEnvParameters();
        $loader->load(function ($container) use ($envParameters) {
            $container->getParameterBag()->add($envParameters);
        });
    }
}
