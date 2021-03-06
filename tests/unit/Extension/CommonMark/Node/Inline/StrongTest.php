<?php

declare(strict_types=1);

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\CommonMark\Tests\Unit\Extension\CommonMark\Node\Inline;

use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;
use PHPUnit\Framework\TestCase;

final class StrongTest extends TestCase
{
    public function testEmptyConstructor(): void
    {
        $emphasis = new Strong();
        $this->assertSame('**', $emphasis->getOpeningDelimiter());
        $this->assertSame('**', $emphasis->getClosingDelimiter());
    }

    public function testConstructor(): void
    {
        $emphasis = new Strong('__');
        $this->assertSame('__', $emphasis->getOpeningDelimiter());
        $this->assertSame('__', $emphasis->getClosingDelimiter());
    }
}
