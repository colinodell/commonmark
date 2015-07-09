<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * Original code based on the CommonMark JS reference parser (http://bitly.com/commonmark-js)
 *  - (c) John MacFarlane
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\CommonMark\Inline\Parser;

use League\CommonMark\ContextInterface;
use League\CommonMark\InlineParserContext;
use League\CommonMark\Inline\Element\Text;

class SmartPunctParser extends AbstractInlineParser
{
    /**
     * @return string[]
     */
    public function getCharacters()
    {
        return ['-', '.'];
    }

    /**
     * @param ContextInterface $context
     * @param InlineParserContext $inlineContext
     *
     * @return bool
     */
    public function parse(ContextInterface $context, InlineParserContext $inlineContext)
    {
        $cursor = $inlineContext->getCursor();
        $ch = $cursor->getCharacter();

        // Ellipses
        if ($ch === '.' && $matched = $cursor->match('/^\\.( ?\\.)\\1/'))
        {
            $inlineContext->getInlines()->add(new Text("…"));
            return true;
        }

        // Em/En-dashes
        elseif ($ch === '-' && $matched = $cursor->match('/^(?<!-)(-{2,})/'))
        {
            $count = strlen($matched);

            $em_count = floor($count / 3);
            $count -= $em_count * 3;

            $en_count = floor($count / 2);
            $count -= $en_count * 2;

            $em_dash = '—';
            $en_dash = '–';
            $inlineContext->getInlines()->add(new Text(
                str_repeat($em_dash, $em_count).
                str_repeat($en_dash, $en_count).
                str_repeat("-", $count)
            ));
            return true;
        }

        return false;
    }
}