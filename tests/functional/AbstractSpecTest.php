<?php

declare(strict_types=1);

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * Original code based on the CommonMark JS reference parser (https://bitly.com/commonmark-js)
 *  - (c) John MacFarlane
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\CommonMark\Tests\Functional;

use League\CommonMark\CommonMarkConverter;
use PHPUnit\Framework\TestCase;

abstract class AbstractSpecTest extends TestCase
{
    /** @var CommonMarkConverter */
    protected $converter;

    protected function setUp(): void
    {
        $this->converter = new CommonMarkConverter();
    }

    /**
     * @dataProvider dataProvider
     *
     * @param string $markdown Markdown to parse
     * @param string $html     Expected result
     */
    public function testSpecExample(string $markdown, string $html): void
    {
        // Replace visible tabs in spec
        $markdown = \str_replace('→', "\t", $markdown);
        $html     = \str_replace('→', "\t", $html);

        $actualResult = (string) $this->converter->convertToHtml($markdown);

        $failureMessage  = 'Unexpected result:';
        $failureMessage .= "\n=== markdown ===============\n" . $this->showSpaces($markdown);
        $failureMessage .= "\n=== expected ===============\n" . $this->showSpaces($html);
        $failureMessage .= "\n=== got ====================\n" . $this->showSpaces($actualResult);

        $this->assertEquals($html, $actualResult, $failureMessage);
    }

    public function dataProvider(): \Generator
    {
        yield from $this->loadSpecExamples();
    }

    public function loadSpecExamples(): \Generator
    {
        if (($data = \file_get_contents($this->getFileName())) === false) {
            $this->fail('Could not load tests from ' . $this->getFileName());
        }

        $matches = [];
        // Normalize newlines for platform independence
        $data = \preg_replace('/\r\n?/', "\n", $data);
        $data = \preg_replace('/<!-- END TESTS -->.*$/', '', $data);
        \preg_match_all('/^`{32} (example ?\w*)\n([\s\S]*?)^\.\n([\s\S]*?)^`{32}$|^#{1,6} *(.*)$/m', $data, $matches, PREG_SET_ORDER);

        $examples       = [];
        $currentSection = 'Example';
        $exampleNumber  = 0;

        foreach ($matches as $match) {
            if (isset($match[4])) {
                $currentSection = $match[4];
                continue;
            }

            $exampleNumber++;

            $testName = \trim($currentSection . ' #' . $exampleNumber);

            $markdown = $match[2];
            $markdown = \str_replace('→', "\t", $markdown);

            yield $testName => [
                'markdown' => $markdown,
                'html'     => $match[3],
                'type'     => $match[1],
            ];
        }

        return $examples;
    }

    private function showSpaces(string $str): string
    {
        $str = \strtr($str, ["\t" => '→', ' ' => '␣']);

        return $str;
    }

    abstract protected function getFileName(): string;
}
