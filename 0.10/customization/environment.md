---
layout: default
title: The Environment
---

The Environment
===============

All parsers, renderers, etc. must be registered with the `Environment` class so that the library is aware of them.

A pre-configured `Environment` can be obtained like this:

~~~php
use League\CommonMark;

$environment = Environment::createCommonMarkEnvironment();
~~~

All of the core renders, parsers, etc. will be pre-registered and ready to go.

You can customize this default `Environment` (or even a new, empty one) using any of the methods below.
(These are the same methods used by `Environment::createCommonMarkEnvironment()` to register the standard functionality.)

## addBlockParser()

~~~php
public function addBlockParser(BlockParserInterface $parser);
~~~

Registers the given `BlockParserInterface` with the environment.

See [Block Parsing](/customization/block-parsing/) for details.

## addBlockRenderer()

~~~php
public function addBlockRenderer($blockClass, BlockRendererInterface $blockRenderer);
~~~

Registers a `BlockRendererInterface` to handle a specific type of block (`$blockClass`).

See [Block Rendering](/customization/block-rendering/) for details.

## addInlineParser()

~~~php
public function addInlineParser(InlineParserInterface $parser);
~~~

Registers the given `InlineParserInterface` with the environment.

See [Inline Parsing](/customization/inline-parsing/) for details.

## addInlineProcessor()

~~~php
public function addInlineProcessor(InlineProcessorInterface $processor);
~~~

Registers the given `InlineProcessorInterface` with the environment.

**TODO:** Add documentation for this.

## addInlineRenderer()

~~~php
public function addInlineRenderer($inlineClass, InlineRendererInterface $renderer);
~~~

Registers an `InlineRendererInterface` to handle a specific type of inline (`$inlineClass`).
A single renderer can handle multiple inline classes, but you must register it separately for each type. (The same renderer instance can be re-used if desired.)

See [Inline Rendering](/customization/inline-rendering/) for details.
