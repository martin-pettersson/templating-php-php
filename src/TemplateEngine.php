<?php

/*
 * Copyright (c) 2025 Martin Pettersson
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace N7e\Templating\Php;

use N7e\Templating\TemplateEngineInterface;

/**
 * PHP-template implementation of a template engine.
 */
class TemplateEngine implements TemplateEngineInterface
{
    /**
     * Available template directories.
     *
     * @var string[]
     */
    private readonly array $templateDirectories;

    /**
     * Create a new template engine instance.
     *
     * @param string[] $templateDirectories Available template directories.
     */
    public function __construct(array $templateDirectories)
    {
        $this->templateDirectories = $templateDirectories;
    }

    /** {@inheritDoc} */
    public function render(string $template, array $context = []): string
    {
        $templateFile = $this->locate($template);

        ob_start();

        extract($context);
        include $templateFile;

        return (string) ob_get_clean();
    }

    /**
     * Locate and return the path of a given template.
     *
     * @param string $template Name of template to locate.
     * @return string Path to the given template.
     * @throws \N7e\Templating\Php\TemplateNotFoundException
     */
    private function locate(string $template): string
    {
        $filename = $this->filenameOf($template);

        foreach ($this->templateDirectories as $directory) {
            $file = rtrim($directory, '/') . '/' . $filename;

            if (is_readable($file)) {
                return $file;
            }
        }

        throw new TemplateNotFoundException($template);
    }

    /**
     * Return the filename of a given template.
     *
     * @param string $template Arbitrary template.
     * @return string Filename of the given template.
     */
    private function filenameOf(string $template): string
    {
        return ! strrpos($template, '.php', strlen($template) - 4) ? $template . '.php' : $template;
    }
}
