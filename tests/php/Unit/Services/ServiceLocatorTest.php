<?php

/**
 * Test: Service Locator
 *
 * @package ThoughtsIdeas\Wordpress\Infrastructure
 */

declare(strict_types=1);

namespace ThoughtsIdeas\Wordpress\Infrastructure\Tests\Unit\Services;

use stdClass;
use ThoughtsIdeas\Wordpress\Infrastructure\Services\Locator;
use ThoughtsIdeas\Wordpress\Infrastructure\Services\ServiceProvider;
use ThoughtsIdeas\Wordpress\Infrastructure\Tests\TestCase;

class ServiceLocatorTest extends TestCase
{
    /**
     * Basic test to ensure class implements Locator interface.
     *
     * @test
     * @covers \ThoughtsIdeas\Wordpress\Infrastructure\Services\ServiceLocator
     *
     * @return void
     */
    public function testInstanceOfProvider(): void
    {
        self::assertInstanceOf(
            Locator::class,
            new DummyServiceLocator(
                hook_prefix: 'ThoughtsIdeas'
            )
        );
    }

    /**
     * Get Service Collection
     *
     * @test
     * @covers \ThoughtsIdeas\Wordpress\Infrastructure\Services\ServiceLocator::getProviderCollection
     *
     * @return void
     */
    public function testGetProviderCollectionReturnsArray(): void
    {
        $service_locator = new DummyServiceLocator(
            hook_prefix: 'ThoughtsIdeas'
        );

        $service_locator->initializeProviderCollection();

        self::assertIsArray(
            $service_locator->getProviderCollection()
        );
    }

    /**
     * ServiceProvider is added to collection.
     *
     * @test
     * @covers \ThoughtsIdeas\Wordpress\Infrastructure\Services\ServiceLocator::initializeProviderCollection
     *
     * @return void
     */
    public function testInitializerProviderCollection(): void
    {
        $service_locator = new DummyServiceLocator(
            hook_prefix: 'ThoughtsIdeas'
        );

        $service_locator->initializeProviderCollection();

        $act = $service_locator->getProviderCollection();

        self::assertInstanceOf(
            ServiceProvider::class,
            $act['ThoughtsIdeas\Wordpress\Infrastructure\Tests\Unit\Services\DummyServiceProvider']
        );
    }

    /**
     * Get Hook returns correct hook name.
     *
     * @test
     * @covers \ThoughtsIdeas\Wordpress\Infrastructure\Services\ServiceLocator::getHook
     *
     * @return void
     */
    public function testGetHookReturnsCorrectHook(): void
    {
        $service_locator = new DummyServiceLocator(
            hook_prefix: 'ThoughtsIdeas'
        );

        $act = $service_locator->getHook();

        self::assertEquals(
            expected: 'ThoughtsIdeas.Plugin',
            actual: $act
        );
    }

    /**
     * @covers \ThoughtsIdeas\Wordpress\Infrastructure\Services\ServiceLocator::bootstrap
     */
    public function testRegisteringOfHooks(): void
    {
        $instance = new DummyServiceLocator(
            hook_prefix: 'ThoughtsIdeas'
        );
        $instance->bootstrap();

        self::assertEquals(
            10,
            has_action(
                'plugins_loaded',
                [ $instance, 'initializeProviderCollection' ]
            )
        );
    }

    /**
     * Service Provider is initialized.
     *
     * @test
     * @covers \ThoughtsIdeas\Wordpress\Infrastructure\Services\ServiceLocator::initializeProvider
     *
     * @return void
     */
    public function testServiceProviderInitialized(): void
    {
        $service_locator = new DummyServiceLocator(
            hook_prefix: 'ThoughtsIdeas'
        );

        $act = $service_locator->initializeProvider(
            service_provider: DummyServiceProvider::class
        );

        self::assertInstanceOf(
            expected: DummyServiceProvider::class,
            actual: $act
        );
    }

    /**
     * @covers \ThoughtsIdeas\Wordpress\Infrastructure\Services\ServiceLocator::initializeProvider
     */
    public function testIgnoreNonServiceProviders(): void
    {
        $this->expectException( \TypeError::class );

        $non_service_provider = new stdClass;

        $service_locator = new DummyServiceLocator(
            hook_prefix: 'ThoughtsIdeas'
        );

        $act = $service_locator->initializeProvider(
            service_provider: $non_service_provider::class
        );
    }
}
