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
use PHPUnit\Framework\TestCase;

final class ConfigProviderTest extends TestCase
{
    /** @var ConfigProvider */
    private $provider;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->provider = new ConfigProvider();
    }

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     *
     * @return void
     */
    public function testReturnedArrayContainsDependencies(): void
    {
        $config = ($this->provider)();
        self::assertIsArray($config);

        self::assertArrayHasKey('view_helpers', $config);

        $viewHelpers = $config['view_helpers'];
        self::assertIsArray($viewHelpers);
        self::assertArrayHasKey('factories', $viewHelpers);
        self::assertArrayHasKey('aliases', $viewHelpers);

        $factories = $viewHelpers['factories'];
        self::assertIsArray($factories);
        self::assertArrayHasKey(Authorization::class, $factories);

        $aliases = $viewHelpers['aliases'];
        self::assertIsArray($aliases);
        self::assertArrayHasKey('authorization', $aliases);
        self::assertArrayHasKey('Authorization', $aliases);
    }
}
