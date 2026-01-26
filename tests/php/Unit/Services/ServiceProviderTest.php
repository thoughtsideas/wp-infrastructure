<?php

/**
 * Test: Service Provider
 *
 * @package ThoughtsIdeas\Wordpress\Infrastructure
 */

declare(strict_types=1);

namespace ThoughtsIdeas\Wordpress\Infrastructure\Tests\Unit\Services;

use ThoughtsIdeas\Wordpress\Infrastructure\Services\Provider;
use ThoughtsIdeas\Wordpress\Infrastructure\Services\Service;
use ThoughtsIdeas\Wordpress\Infrastructure\Services\ServiceProvider;
use ThoughtsIdeas\Wordpress\Infrastructure\Tests\TestCase;

class ServiceProviderTest extends TestCase
{
    /**
     * Basic test to ensure class implements Provider interface.
     *
     * @test
     * @covers \ThoughtsIdeas\Wordpress\Infrastructure\Services\ServiceProvider
     *
     * @return void
     */
    public function testInstanceOfProvider(): void
    {
        self::assertInstanceOf(
            Provider::class,
            new DummyServiceProvider(
                hook_prefix: 'ThoughtsIdeas.Plugin'
            )
        );
    }

    /**
     * Ensure class is instance of ServiceProvider.
     *
     * @test
     * @covers \ThoughtsIdeas\Wordpress\Infrastructure\Services\ServiceProvider
     *
     * @return void
     */
    public function testInstanceOfServiceProvider(): void
    {
        self::assertInstanceOf(
            ServiceProvider::class,
            new DummyServiceProvider(
                hook_prefix: 'ThoughtsIdeas.Plugin'
            )
        );
    }

    /**
     * Service is initialized.
     *
     * @test
     * @covers \ThoughtsIdeas\Wordpress\Infrastructure\Services\ServiceProvider::initializeCollection
     * @covers \ThoughtsIdeas\Wordpress\Infrastructure\Services\ServiceProvider::initializeService
     *
     * @return void
     */
    public function testInitializeService(): void
    {
        $service_provider = new DummyServiceProvider(
            hook_prefix: 'ThoughtsIdeas.Plugin'
        );

        $service_provider->initializeCollection();

        $act = $service_provider->getServiceContainer();

        self::assertInstanceOf(
            expected: Service::class,
            actual: $act['ThoughtsIdeas\Wordpress\Infrastructure\Tests\Unit\Services\DummyService']
        );
    }

    /**
     * Get Service Collection
     *
     * @test
     * @covers \ThoughtsIdeas\Wordpress\Infrastructure\Services\ServiceProvider::getServiceContainer
     *
     * @return void
     */
    public function testGetServiceContainerReturnsArray(): void
    {
        $service_provider = new DummyServiceProvider(
            hook_prefix: 'ThoughtsIdeas.Plugin'
        );

        $service_provider->initializeCollection();
        $act = $service_provider->getServiceContainer();

        self::assertInstanceOf(
            expected: DummyService::class,
            actual: $act['ThoughtsIdeas\Wordpress\Infrastructure\Tests\Unit\Services\DummyService']
        );
    }
}
