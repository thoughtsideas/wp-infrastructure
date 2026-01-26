<?php

/**
 * Abstract: Serivce Locator
 *
 * @package   ThoughtsIdeas\Wordpress\Infrastructure
 * @author    Thoughts & Ideas <hello@thoughtsandideas.uk>
 * @link      https://www.thoughtsandideas.uk/
 * @license   MIT
 * @copyright 2022-2024 Thoughts & Ideas Limited.
 */

declare(strict_types=1);

namespace ThoughtsIdeas\Wordpress\Infrastructure\Services;

abstract class ServiceLocator implements Locator
{
    /**
     * WordPress action to trigger the service registration on.
     */
    protected string $registration_action = 'plugins_loaded';

    protected string $name;

    protected string $identifier;

    protected string $hook_prefix;

    /**
     * @var array<string>
     */
    protected array $provider_collection = [];

    /**
     * Providers to be loaded.
     *
     * @var array<string,Provider>
     */
    private array $provider_container = [];

    public function __construct(
        string $hook_prefix
    ) {
        $this->hook_prefix    = $hook_prefix;
    }

    public function getHook(): string
    {
        return "{$this->hook_prefix}.{$this->identifier}";
    }

    public function bootstrap(): void
    {
        \add_action(
            $this->registration_action,
            [ $this, 'initializeProviderCollection' ],
            10,
            0
        );
    }

    /**
     * @return array<string,Provider>
     */
    public function getProviderCollection(): array
    {
        return $this->provider_container;
    }

    public function initializeProviderCollection(): void
    {
        foreach ( $this->provider_collection as $provider_class ) {
            $provider = $this->initializeProvider( $provider_class );
            $this->provider_container[ $provider::class ] = $provider;

            $this->provider_container[ $provider::class ]->initializeCollection();
        }
    }

    public function initializeProvider(string $service_provider): ServiceProvider
    {

        /**
         * @var ServiceProvider $return
         */
        $return = new $service_provider(
            $this->getHook()
        );

        if ( ! ( $return instanceof ServiceProvider ) ) {
            throw new \TypeError(
                sprintf(
                    'Service Provider %s must be an instance of ServiceProvider',
                    $service_provider
                )
            );
        }

        return $return;
    }
}
