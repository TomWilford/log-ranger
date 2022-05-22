<?php

namespace Wilf\Tests\Console;

use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends \Symfony\Component\HttpKernel\Kernel
{

    /**
     * @inheritDoc
     */
    public function registerBundles(): iterable
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/../config/services.yml');
    }
}