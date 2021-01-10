<?php
/**
 * This file is part of the mimmi20/mezzio-generic-authorization-laminasviewrenderer package.
 *
 * Copyright (c) 2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace Mezzio\GenericAuthorization\LaminasView;

use Interop\Container\ContainerInterface;
use Mezzio\GenericAuthorization\AuthorizationInterface;

final class AuthorizationFactory
{
    /**
     * Create and return a navigation view helper instance.
     *
     * @param ContainerInterface $container
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     *
     * @return Authorization
     */
    public function __invoke(ContainerInterface $container): Authorization
    {
        return new Authorization(
            $container->get(AuthorizationInterface::class)
        );
    }
}
