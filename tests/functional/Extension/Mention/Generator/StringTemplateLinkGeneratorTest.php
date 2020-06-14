<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\CommonMark\Tests\Functional\Extension\Mention\Generator;

use League\CommonMark\Extension\Mention\Generator\StringTemplateLinkGenerator;
use League\CommonMark\Extension\Mention\Mention;
use League\CommonMark\Inline\Element\Text;
use PHPUnit\Framework\TestCase;

final class StringTemplateLinkGeneratorTest extends TestCase
{
    public function testIt()
    {
        $generator = new StringTemplateLinkGenerator('https://www.twitter.com/%s');

        $mention = $generator->generateMention(new Mention('@', 'colinodell'));
        assert($mention instanceof Mention);

        $this->assertSame('https://www.twitter.com/colinodell', $mention->getUrl());

        $label = $mention->firstChild();
        assert($label instanceof Text);
        $this->assertSame('@colinodell', $label->getContent());
    }
}
