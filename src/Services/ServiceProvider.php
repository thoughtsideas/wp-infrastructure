<?php

/**
 * Abstract: Serivce Provider
 *
 * @package   ThoughtsIdeas\Wordpress\Infrastructure
 * @author    Thoughts & Ideas <hello@thoughtsandideas.uk>
 * @link      https://www.thoughtsandideas.uk/
 * @license   MIT
 * @copyright 2022-2024 Thoughts & Ideas Limited.
 */

declare(strict_types=1);

namespace ThoughtsIdeas\Wordpress\Infrastructure\Services;

abstract class ServiceProvider implements Provider
{
    protected string $identifier;

    protected string $hook_prefix;

    /**
     * @var array<string>
     */
    protected array $service_collection = [];

    /**
     * @var array<string,Service>
     */
    private array $service_container = [];

    public function __construct(
        string $hook_prefix
    ) {
        $this->hook_prefix = $hook_prefix;
    }

    /**
     * Return collection of Services provided by this Service Provider.
     *
     * @return array<string,Service>
     */
    public function getServiceContainer(): array
    {
        return $this->service_container;
    }

    public function initializeCollection(): void
    {
        foreach ( $this->service_collection as $service_class ) {
            /**
             * @var Service $service
             */
            $service = $this->initializeService( $service_class );
            $this->service_container[ $service::class ] = $service;
            $this->service_container[ $service::class ]->register();
        }
    }

    private function initializeService(string $service): Service
    {

        /**
         * @var Service $return
         */
        $return = new $service(
            hook_prefix: "{$this->hook_prefix}.{$this->identifier}"
        );

        // if ( ! ( $service instanceof Service ) ) {
        //     throw new \TypeError(
        //         \sprintf(
        //             'Service %s must be an instance of Service',
        //             $service
        //         )
        //     );
        // }

        return $return;
    }
}
