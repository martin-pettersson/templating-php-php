<?php

/*
 * Copyright (c) 2025 Martin Pettersson
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace N7e\Templating\Php;

use N7e\Templating\TemplateNotFoundExceptionInterface;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(TemplateEngine::class)]
#[CoversClass(TemplateNotFoundException::class)]
class TemplateEngineTest extends TestCase
{
    private array $templateDirectories = [
        __DIR__ . '/fixtures/templates'
    ];

    private TemplateEngine $templateEngine;

    #[Before]
    public function setUp(): void
    {
        $this->templateEngine = new TemplateEngine($this->templateDirectories);
    }

    #[Test]
    public function shouldThrowExceptionIfTemplateNotFound(): void
    {
        $this->expectException(TemplateNotFoundExceptionInterface::class);

        $this->templateEngine->render('not-found');
    }

    #[Test]
    public function shouldLocateTemplateByName(): void
    {
        $this->assertEquals('title', $this->templateEngine->render('index'));
    }

    #[Test]
    public function shouldLocateTemplateByNameAndExtension(): void
    {
        $this->assertEquals('title', $this->templateEngine->render('index.php'));
    }

    #[Test]
    public function shouldLocateTemplateInSubDirectory(): void
    {
        $this->assertEquals('title', $this->templateEngine->render('sub/index'));
    }

    #[Test]
    public function shouldRenderTemplateInGivenContext(): void
    {
        $this->assertEquals('context', $this->templateEngine->render('index', ['title' => 'context']));
    }
}
