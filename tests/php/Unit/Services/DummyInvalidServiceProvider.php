<?php

/**
 * Dummy: Invalid Serivce Provider
 *
 * @package   ThoughtsIdeas\Wordpress\Infrastructure
 * @author    Thoughts & Ideas <hello@thoughtsandideas.uk>
 * @link      https://www.thoughtsandideas.uk/
 * @license   MIT
 * @copyright 2026 Thoughts & Ideas Limited.
 */

declare(strict_types=1);

namespace ThoughtsIdeas\Wordpress\Infrastructure\Tests\Unit\Services;

use ThoughtsIdeas\Wordpress\Infrastructure\Services\ServiceProvider;

final class DummyInvalidServiceProvider extends ServiceProvider
{
    protected string $identifier = 'Provider';

    /**
     * @var array<string>
     */
    protected array $service_collection = [
        DummyInvalidService::class,
    ];

    public function __construct(
        string $hook_prefix
    ) {
        $this->hook_prefix = $hook_prefix;
    }
}
