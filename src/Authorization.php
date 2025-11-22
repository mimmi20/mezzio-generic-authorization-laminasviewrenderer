<?php

/**
 * This file is part of the mimmi20/mezzio-generic-authorization-laminasviewrenderer package.
 *
 * Copyright (c) 2021-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Mimmi20\Mezzio\GenericAuthorization\LaminasView;

use Laminas\View\Helper\HelperInterface;
use Mezzio\Authentication\UserInterface;
use Mimmi20\Mezzio\GenericAuthorization\AuthorizationInterface;
use Psr\Http\Message\ServerRequestInterface;

use function count;

final readonly class Authorization implements HelperInterface
{
    /** @throws void */
    public function __construct(private AuthorizationInterface $authorization)
    {
        // nothing to do
    }

    /**
     * Check if a role is granted for a resource
     *
     * @throws void
     *
     * @api
     */
    public function isGranted(
        string | null $role = null,
        string | null $resource = null,
        string | null $privilege = null,
        ServerRequestInterface | null $request = null,
    ): bool {
        return $this->authorization->isGranted($role, $resource, $privilege, $request);
    }

    /**
     * Check if a role is granted for a user
     *
     * @throws void
     *
     * @api
     */
    public function isGrantedForUser(
        UserInterface $user,
        string | null $resource = null,
        string | null $privilege = null,
        ServerRequestInterface | null $request = null,
    ): bool {
        $roles = [];

        foreach ($user->getRoles() as $role) {
            $roles[] = $role;
        }

        if (count($roles)) {
            foreach ($roles as $role) {
                if ($this->authorization->isGranted($role, $resource, $privilege, $request)) {
                    return true;
                }
            }
        } elseif ($this->authorization->isGranted(null, $resource, $privilege, $request)) {
            return true;
        }

        return false;
    }
}
