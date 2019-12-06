<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    private const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    public function registerBundles(): iterable
    {
        $contents = require $this->getProjectDir().'/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                yield new $class();
            }
        }
    }

    public function getProjectDir(): string
    {
        return \dirname(__DIR__);
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $container->addResource(new FileResource($this->getProjectDir().'/config/bundles.php'));
        $container->setParameter('container.dumper.inline_class_loader', \PHP_VERSION_ID < 70400 || !ini_get('opcache.preload'));
        $container->setParameter('container.dumper.inline_factories', true);
        $confDir = $this->getProjectDir().'/config';

        $loader->load($confDir.'/{packages}/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{packages}/'.$this->environment.'/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{services}'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{services}_'.$this->environment.self::CONFIG_EXTS, 'glob');
    }

    protected function configureRoutes(RouteCollectionBuilder $routes): void
    {
        $confDir = $this->getProjectDir().'/config';

        $routes->import($confDir.'/{routes}/'.$this->environment.'/*'.self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir.'/{routes}/*'.self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir.'/{routes}'.self::CONFIG_EXTS, '/', 'glob');
    }

    /**
     * You can modify the container here before it is dumped to PHP code.

    public function process(ContainerBuilder $container)
    {
        // get all event listeners
        $services = $container->findTaggedServiceIds("kernel.event_listener");
        $orig = $container->getDefinition('App\\EventListener\\ListenerDecorator');
        $args = $orig->getArguments();

        foreach($services as $key => $id) {
            $inner = $container->getDefinition($key);

            $decoratedDef = new Definition('App\\EventListener\\ListenerDecorator');
            $decoratedDef->setAutoconfigured(true);
            $decoratedDef->setAutowired(true);
            // replace it with inner service
            $container->setDefinition($key . '.inner', $inner);
            $decoratedDef->addMethodCall('decorate', [new Reference($key . '.inner')]);
            foreach ($inner->getTags() as $key => $tags) {
                foreach($tags as $tag)
                    $decoratedDef->addTag($key, $tag);
            }
            $inner->clearTags();

            $container->setDefinition($key . microtime(), $decoratedDef);
        }

    }*/
}
