<?php

/**
 * Dummy: Invalid Serivce
 *
 * @package   ThoughtsIdeas\Wordpress\Infrastructure
 * @author    Thoughts & Ideas <hello@thoughtsandideas.uk>
 * @link      https://www.thoughtsandideas.uk/
 * @license   MIT
 * @copyright 2026 Thoughts & Ideas Limited.
 */

declare(strict_types=1);

namespace ThoughtsIdeas\Wordpress\Infrastructure\Tests\Unit\Services;

use ThoughtsIdeas\Wordpress\Infrastructure\Services\Registrable;

final class DummyInvalidService implements Registrable
{
    protected string $name = 'DummyService';

    /**
     * @var non-empty-string
     */
    protected string $hook;

    public function __construct(
        string $hook_prefix
    ) {
        $this->hook = "{$hook_prefix}.{$this->name}";
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @phpstan-return non-empty-string
     */
    public function getHook(): string
    {
        return $this->hook;
    }

    public function register(): void
    {
        // Add WordPress Hooks here.
    }
}
