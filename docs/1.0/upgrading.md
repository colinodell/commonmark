---
layout: default
title: Upgrading from 0.19 to 1.0
redirect_from: /0.20/upgrading/
---

# Upgrading from 0.19 to 1.0

## Previous Deprecations Removed

All previously-deprecated code has been removed. This includes:

 - The `safe` option (use `html_input` and `allow_unsafe_links` options instead)
 - All deprecated `RegexHelper` constants
 - `DocParser::getEnvironment()` (you should obtain it some other way)
 - `AbstractInlineContainer` (use `AbstractInline` instead and make `isContainer()` return `true`)

## Text Encoding

This library used to claim it supported ISO-8859-1 encoding but that never truly worked - everything assumed the text was encoded as UTF-8 or ASCII. We've therefore dropped support for ISO-8859-1 and any other unexpected encodings. If you were using some other encoding, you'll now need to convert your Markdown to UTF-8 prior to running it through this library.

Additionally, all public `getEncoding()` or `setEncoding()` methods have been removed, so assume that you're working with UTF-8.

## Inline Processors

The "inline processor" functionality has been removed and replaced with a proper "delimiter processor" feature geared specifically towards dealing with delimiters (which is what the previous implementation tried to do - poorly).

No direct upgrade path exists as this implementation was not widely used, or only used for implementing delimiter processing.  If you fall in the latter category, simply leverage the new functionality instead.  Otherwise, if you have another good use case for inline processors, please let us know in the issue tracker.

## Delimiters

Now that we have proper delimiter handling, we've `final`ized the `Delimiter` class and extracted a `DelimiterInterface` from it.  If you previous extended from `Delimiter` you'll need to implement this new interface instead.

## `DocParser`

The `DocParser` class is now `final` as it was never intended to be extended, especially given how so much logic was in `private` methods.  Any custom implementations should implement the new `DocParserInterface` interface instead.

Additionally, the `getEnvironment()` method has been deprecated and excluded from that new interface, as it was only used internally by the `DocParser` and other better ways exist to obtain an environment where needed.

## `Configuration`

The `Configuration` class is now `final` and implements a new `ConfigurationInterface`.  If any of your parsers/renders/etc implement `ConfigurationAwareInterface` you'll need to update that method to accept the new interface instead of the concrete class.

We also renamed/added the following methods:

| Old Name        | New Name    |
|-----------------|-------------|
| `getConfig()`   | `get()`     |
| _n/a_           | `set()`     |
| `setConfig()`   | `replace()` |
| `mergeConfig()` | `merge()`   |

## `AbstractInlineContainer`

The `AbstractInlineContainer` class added an unnecessary level of inheritance and was therefore deprecated. If you previously extended this class, you should now extend from `AbstractInline` and override `isContainer()` to return `true`.

## `AdjoiningTextCollapser`

The `AdjoiningTextCollapser` is an internal class used to combine multiple `Text` elements into one.  If you were using this yourself (unlikely) you'll need to refer to its new name instead: `AdjacentTextMerger`. And if you previously used `collapseTextNodes()` you'll want to switch to using `mergeChildNodes()` instead.
