<?php

namespace TBela\CSS\Value;

/**
 * Css string value
 * @package TBela\CSS\Value
 */
class FontFamily extends CssString
{
    /**
     * @inheritDoc
     */
    public static function matchToken ($token, $previousToken = null, $previousValue = null) {

        return $token->type == 'css-string' || $token->type == static::type();
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */

    protected static function doParse($string, $capture_whitespace = true, $context = '', $contextName = '')

    {

        $type = static::type();
        $tokens = static::getTokens($string, $capture_whitespace, $context, $contextName);

        foreach ($tokens as $token) {

            if (static::matchToken($token)) {

                if ($token->type == 'css-string') {

                    $token->value = static::stripQuotes($token->value);
                }

                $token->type = $type;
            }
        }

        return new Set(static::reduce($tokens));
    }
}
