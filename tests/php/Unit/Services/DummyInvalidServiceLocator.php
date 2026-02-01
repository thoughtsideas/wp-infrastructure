<?php

/**
 * Dummy: Serivce Locator
 *
 * @package   ThoughtsIdeas\Wordpress\Infrastructure
 * @author    Thoughts & Ideas <hello@thoughtsandideas.uk>
 * @link      https://www.thoughtsandideas.uk/
 * @license   MIT
 * @copyright 2022-2024 Thoughts & Ideas Limited.
 */

declare(strict_types=1);

namespace ThoughtsIdeas\Wordpress\Infrastructure\Tests\Unit\Services;

use ThoughtsIdeas\Wordpress\Infrastructure\Main;
use ThoughtsIdeas\Wordpress\Infrastructure\Services\ServiceLocator;

final class DummyInvalidServiceLocator extends ServiceLocator implements Main
{
    protected string $identifier = 'Plugin';

    protected string $name = 'DummyServiceLocator';

    /**
     * @var array<string>
     */
    protected array $provider_collection = [
        DummyInvalidServiceProvider::class,
    ];
}
