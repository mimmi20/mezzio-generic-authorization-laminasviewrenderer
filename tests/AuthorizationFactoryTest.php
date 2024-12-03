<?php

/**
 * This file is part of the mimmi20/mezzio-generic-authorization-laminasviewrenderer package.
 *
 * Copyright (c) 2021-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Mimmi20\Mezzio\GenericAuthorization\LaminasView;

use Mimmi20\Mezzio\GenericAuthorization\AuthorizationInterface;
use Override;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

use function assert;

final class AuthorizationFactoryTest extends TestCase
{
    private AuthorizationFactory $factory;

    /** @throws void */
    #[Override]
    protected function setUp(): void
    {
        $this->factory = new AuthorizationFactory();
    }

    /**
     * @throws Exception
     * @throws ContainerExceptionInterface
     */
    public function testInvocation(): void
    {
        $authorizationInterface = $this->createMock(AuthorizationInterface::class);

        $container = $this->getMockBuilder(ContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $container->expects(self::once())
            ->method('get')
            ->with(AuthorizationInterface::class)
            ->willReturn($authorizationInterface);

        assert($container instanceof ContainerInterface);
        $authorization = ($this->factory)($container);

        self::assertInstanceOf(Authorization::class, $authorization);
    }
}
