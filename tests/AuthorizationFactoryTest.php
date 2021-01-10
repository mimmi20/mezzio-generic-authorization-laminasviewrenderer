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
use PHPUnit\Framework\TestCase;

final class AuthorizationFactoryTest extends TestCase
{
    /** @var AuthorizationFactory */
    private $factory;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->factory = new AuthorizationFactory();
    }

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\MockObject\RuntimeException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     *
     * @return void
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

        \assert($container instanceof ContainerInterface);
        $authorization = ($this->factory)($container);

        self::assertInstanceOf(Authorization::class, $authorization);
    }
}
