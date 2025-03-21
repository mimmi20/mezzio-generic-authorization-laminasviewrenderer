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

use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;

final class ConfigProviderTest extends TestCase
{
    /** @throws Exception */
    public function testReturnedArrayContainsDependencies(): void
    {
        $config = (new ConfigProvider())();
        self::assertIsArray($config);
        self::assertCount(1, $config);
        self::assertArrayHasKey('view_helpers', $config);

        $viewHelpers = $config['view_helpers'];
        self::assertIsArray($viewHelpers);
        self::assertCount(2, $viewHelpers);
        self::assertArrayHasKey('factories', $viewHelpers);
        self::assertArrayHasKey('aliases', $viewHelpers);

        $factories = $viewHelpers['factories'];
        self::assertIsArray($factories);
        self::assertCount(1, $factories);
        self::assertArrayHasKey(Authorization::class, $factories);

        $aliases = $viewHelpers['aliases'];
        self::assertIsArray($aliases);
        self::assertCount(2, $aliases);
        self::assertArrayHasKey('authorization', $aliases);
        self::assertArrayHasKey('Authorization', $aliases);
    }

    /** @throws Exception */
    public function testReturnedArrayContainsDependencies2(): void
    {
        $viewHelpers = (new ConfigProvider())->getViewHelperConfig();
        self::assertIsArray($viewHelpers);
        self::assertCount(2, $viewHelpers);
        self::assertArrayHasKey('factories', $viewHelpers);
        self::assertArrayHasKey('aliases', $viewHelpers);

        $factories = $viewHelpers['factories'];
        self::assertIsArray($factories);
        self::assertCount(1, $factories);
        self::assertArrayHasKey(Authorization::class, $factories);

        $aliases = $viewHelpers['aliases'];
        self::assertIsArray($aliases);
        self::assertCount(2, $aliases);
        self::assertArrayHasKey('authorization', $aliases);
        self::assertArrayHasKey('Authorization', $aliases);
    }
}
