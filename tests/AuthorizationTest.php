<?php
/**
 * This file is part of the mimmi20/mezzio-generic-authorization-laminasviewrenderer package.
 *
 * Copyright (c) 2021-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Mimmi20\Mezzio\GenericAuthorization\LaminasView;

use Mezzio\Authentication\UserInterface;
use Mimmi20\Mezzio\GenericAuthorization\AuthorizationInterface;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

final class AuthorizationTest extends TestCase
{
    /** @throws Exception */
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

    /** @throws Exception */
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
        $matcher                = self::exactly(2);
        $authorizationInterface->expects($matcher)
            ->method('isGranted')
            ->willReturnCallback(
                static function (
                    string | null $role = null,
                    string | null $innerResource = null,
                    string | null $innerPrivilege = null,
                    ServerRequestInterface | null $innerRequest = null,
                ) use (
                    $matcher,
                    $role1,
                    $role2,
                    $resource,
                    $privilege,
                    $request,
                ): bool {
                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame($role1, $role),
                        default => self::assertSame($role2, $role),
                    };

                    self::assertSame($resource, $innerResource);
                    self::assertSame($privilege, $innerPrivilege);
                    self::assertSame($request, $innerRequest);

                    return match ($matcher->numberOfInvocations()) {
                        1 => false,
                        default => true,
                    };
                },
            );

        $authorization = new Authorization($authorizationInterface);

        self::assertTrue($authorization->isGrantedForUser($user, $resource, $privilege, $request));
    }

    /** @throws Exception */
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
        $matcher                = self::exactly(2);
        $authorizationInterface->expects($matcher)
            ->method('isGranted')
            ->willReturnCallback(
                static function (
                    string | null $role = null,
                    string | null $innerResource = null,
                    string | null $innerPrivilege = null,
                    ServerRequestInterface | null $innerRequest = null,
                ) use (
                    $matcher,
                    $role1,
                    $role2,
                    $resource,
                    $privilege,
                    $request,
                ): bool {
                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame($role1, $role),
                        default => self::assertSame($role2, $role),
                    };

                    self::assertSame($resource, $innerResource);
                    self::assertSame($privilege, $innerPrivilege);
                    self::assertSame($request, $innerRequest);

                    return false;
                },
            );

        $authorization = new Authorization($authorizationInterface);

        self::assertFalse($authorization->isGrantedForUser($user, $resource, $privilege, $request));
    }
}
