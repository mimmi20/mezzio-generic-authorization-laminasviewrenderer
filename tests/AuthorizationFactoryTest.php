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

namespace MezzioTest\GenericAuthorization\LaminasView;

use Interop\Container\ContainerInterface;
use Mezzio\GenericAuthorization\AuthorizationInterface;
use Mezzio\GenericAuthorization\LaminasView\Authorization;
use Mezzio\GenericAuthorization\LaminasView\AuthorizationFactory;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

use function assert;

final class AuthorizationFactoryTest extends TestCase
{
    private AuthorizationFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new AuthorizationFactory();
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
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
