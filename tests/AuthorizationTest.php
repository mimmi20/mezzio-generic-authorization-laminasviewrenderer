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

use Mezzio\Authentication\UserInterface;
use Mezzio\GenericAuthorization\AuthorizationInterface;
use Mezzio\GenericAuthorization\LaminasView\Authorization;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

final class AuthorizationTest extends TestCase
{
    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     *
     * @return void
     */
    public function testIsGranted(): void
    {
        $role      = 'test-role';
        $resource  = 'test-resource';
        $privilege = 'test-privilege';
        $request   = $this->createMock(ServerRequestInterface::class);

        $authorizationInterface = $this->getMockBuilder(AuthorizationInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $authorizationInterface->expects(self::once())
            ->method('isGranted')
            ->with($role, $resource, $privilege, $request)
            ->willReturn(true);

        $authorization = new Authorization($authorizationInterface);

        self::assertTrue($authorization->isGranted($role, $resource, $privilege, $request));
    }

    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     *
     * @return void
     */
    public function testIsGrantedForUser(): void
    {
        $role1     = 'test-role1';
        $role2     = 'test-role2';
        $resource  = 'test-resource';
        $privilege = 'test-privilege';
        $request   = $this->createMock(ServerRequestInterface::class);

        $user = $this->getMockBuilder(UserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $user->expects(self::once())
            ->method('getRoles')
            ->willReturn([$role1, $role2]);

        $authorizationInterface = $this->getMockBuilder(AuthorizationInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $authorizationInterface->expects(self::exactly(2))
            ->method('isGranted')
            ->withConsecutive([$role1, $resource, $privilege, $request], [$role2, $resource, $privilege, $request])
            ->willReturn(false, true);

        $authorization = new Authorization($authorizationInterface);

        self::assertTrue($authorization->isGrantedForUser($user, $resource, $privilege, $request));
    }

    /**
     * @throws \PHPUnit\Framework\Exception
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     *
     * @return void
     */
    public function testIsNotGrantedForUser(): void
    {
        $role1     = 'test-role1';
        $role2     = 'test-role2';
        $resource  = 'test-resource';
        $privilege = 'test-privilege';
        $request   = $this->createMock(ServerRequestInterface::class);

        $user = $this->getMockBuilder(UserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $user->expects(self::once())
            ->method('getRoles')
            ->willReturn([$role1, $role2]);

        $authorizationInterface = $this->getMockBuilder(AuthorizationInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $authorizationInterface->expects(self::exactly(2))
            ->method('isGranted')
            ->withConsecutive([$role1, $resource, $privilege, $request], [$role2, $resource, $privilege, $request])
            ->willReturn(false, false);

        $authorization = new Authorization($authorizationInterface);

        self::assertFalse($authorization->isGrantedForUser($user, $resource, $privilege, $request));
    }
}
