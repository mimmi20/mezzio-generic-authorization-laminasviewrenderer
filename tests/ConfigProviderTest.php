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

use Mezzio\GenericAuthorization\LaminasView\Authorization;
use Mezzio\GenericAuthorization\LaminasView\ConfigProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

final class ConfigProviderTest extends TestCase
{
    private ConfigProvider $provider;

    protected function setUp(): void
    {
        $this->provider = new ConfigProvider();
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testReturnedArrayContainsDependencies(): void
    {
        $config = ($this->provider)();
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

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testReturnedArrayContainsDependencies2(): void
    {
        $viewHelpers = $this->provider->getViewHelperConfig();
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
