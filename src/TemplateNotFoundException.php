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
use RuntimeException;

/**
 * Represents an exception thrown when a desired template cannot be located.
 */
class TemplateNotFoundException extends RuntimeException implements TemplateNotFoundExceptionInterface
{
}
