<?php
/**
 * This file is part of the Cloudinary PHP package.
 *
 * (c) Cloudinary
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cloudinary;

/**
 * Class StringUtils
 *
 * @internal
 */
class StringUtils
{
    public const MAX_STRING_LENGTH = 255;

    /**
     * Converts camelCase to snake_case.
     *
     * @param string $input     The input string.
     * @param string $separator Optional custom separator.
     *
     */
    public static function camelCaseToSnakeCase(string $input, string $separator = '_'): string
    {
        $val = preg_replace('/(?<!^)[A-Z]/', $separator . '$0', $input);

        if (is_null($val)) {
            return $input;
        }

        return strtolower($val);
    }

    /**
     * Converts snake_case to camelCase.
     *
     * @param string $input     The input string.
     * @param string $separator Optional custom separator.
     *
     */
    public static function snakeCaseToCamelCase(string $input, string $separator = '_'): string
    {
        return lcfirst(str_replace($separator, '', ucwords($input, $separator)));
    }

    /**
     * Creates acronym from input string.
     *
     * Example: my_input_string -> mis; color_space -> cs;
     *
     * @param string           $input      The input string.
     * @param array            $exclusions The list of words to omit from acronym. Useful for internal names.
     * @param non-empty-string $delimiter  The delimiter between words.
     *
     */
    public static function toAcronym(string $input, array $exclusions = [], string $delimiter = '_'): string
    {
        $acronym = '';
        $parts = ArrayUtils::safeFilter(ArrayUtils::blacklist(explode($delimiter, $input), $exclusions));
        if (! empty($parts)) {
            foreach ($parts as $word) {
                $acronym .= $word[0];
            }
        }

        return $acronym;
    }

    /**
     * Determines whether $haystack starts with $needle.
     *
     * @param ?string $haystack The string to search in.
     * @param ?string $needle   The string to search for.
     *
     */
    public static function startsWith(?string $haystack, ?string $needle): bool
    {
        return str_starts_with($haystack ?? '', $needle ?? '');
    }

    /**
     * Determines whether $haystack ends with $needle.
     *
     * @param ?string $haystack The string to search in.
     * @param ?string $needle   The string to search for.
     *
     */
    public static function endsWith(?string $haystack, ?string $needle): bool
    {
        return str_ends_with($haystack ?? '', $needle ?? '');
    }

    /**
     * Ensures that the string is wrapped with specified character(s).
     *
     * @param string $string The input string.
     * @param string $char   The wrapping character(s).
     *
     */
    public static function ensureWrappedWith(string $string, string $char): string
    {
        if (! self::startsWith($string, $char)) {
            $string = $char . $string;
        }

        if (! self::endsWith($string, $char)) {
            $string .= $char;
        }

        return $string;
    }

    /**
     * Determines whether $haystack contains $needle.
     *
     * @param ?string $haystack The string to search in.
     * @param string  $needle   The string to search for.
     *
     */
    public static function contains(?string $haystack, string $needle): bool
    {
        if (empty($haystack)) {
            return false;
        }

        return str_contains($haystack, $needle);
    }

    /**
     * Truncates prefix from the string.
     *
     * @param ?string $string The input string.
     * @param string  $prefix Prefix to truncate.
     *
     * @return ?string The resulting string.
     */
    public static function truncatePrefix(?string $string, string $prefix): ?string
    {
        if (is_string($string) && self::startsWith($string, $prefix)) {
            return substr($string, strlen($prefix));
        }

        return $string;
    }

    /**
     * Removes characters from the middle of the string to ensure it is no more than $maxLength characters long.
     *
     * Removed characters are replaced with $glue, which is by default '...'.
     *
     * This method will give priority to the right-hand side of the string when data is truncated.
     *
     * @param string $string    The input string.
     * @param int    $maxLength Maximum string length.
     *
     */
    public static function truncateMiddle(
        string $string,
        int $maxLength = self::MAX_STRING_LENGTH,
        string $glue = '...'
    ): string {
        // Early exit if no truncation necessary
        if (strlen($string) <= $maxLength) {
            return $string;
        }

        $numRightChars = (int)ceil($maxLength / 2);

        $numLeftChars = (int)floor($maxLength / 2);
        $glue         = substr($glue, 0, $numLeftChars); // Pathological case, when glue is longer than a half
        $numLeftChars -= strlen($glue);

        return sprintf('%s%s%s', substr($string, 0, $numLeftChars), $glue, substr($string, 0 - $numRightChars));
    }

    /**
     * Ensures that string starts with prefix.
     *
     * @param string $string The string to search in.
     * @param string $prefix The string to search for.
     *
     */
    public static function ensureStartsWith(string $string, string $prefix): string
    {
        if (! self::startsWith($string, $prefix)) {
            return $prefix . $string;
        }

        return $string;
    }

    /**
     * Based on http://stackoverflow.com/a/1734255/526985
     *
     * @param string $str The input string.
     *
     * @return string Resulting string.
     */
    public static function smartEscape(string $str): string
    {
        $revert = ['%3A' => ':', '%2F' => '/'];

        return strtr(rawurlencode($str), $revert);
    }

    /**
     * URL-encodes dot (.) character
     *
     * @param string $string The input string
     *
     * @return string|string[]|null
     */
    public static function encodeDot(string $string): array|string|null
    {
        return str_replace('.', '%2E', $string);
    }

    /**
     * Escapes characters.
     *
     * @param string       $string      The input string.
     * @param array|string $unsafeChars The list of the characters to escape.
     *
     */
    public static function escapeUnsafeChars(string $string, array|string $unsafeChars): string|null
    {
        if (empty($unsafeChars)) {
            return $string;
        }

        if (is_array($unsafeChars)) {
            $unsafeChars = implode($unsafeChars);
        }

        return preg_replace('/([' . preg_quote($unsafeChars, '/') . '])/', '\\\$1', $string);
    }

    /**
     * Encodes data with URL safe base64.
     *
     * @see https://tools.ietf.org/html/rfc4648#section-5
     *
     * @param mixed $data The data to encode.
     *
     * @return string The encoded data, as a string.
     *
     * @internal
     */
    public static function base64UrlEncode(mixed $data): string
    {
        return strtr(base64_encode($data), '+/', '-_');
    }

    /**
     * Wrapper around parse_str, returns query parameters.
     *
     * @param ?string $query The query string.
     *
     * @return array Query parameters.
     *
     * @see parse_str
     */
    public static function parseQueryString(?string $query): array
    {
        $params = [];
        if (! empty($query)) {
            parse_str($query, $params);
        }

        return $params;
    }
}
