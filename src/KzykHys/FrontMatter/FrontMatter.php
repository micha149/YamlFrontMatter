<?php

namespace KzykHys\FrontMatter;

use Symfony\Component\Yaml\Yaml;
use KzykHys\FrontMatter\Exception\ParseException;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class FrontMatter
{

    /**
     * @param $input
     *
     * @return int
     */
    public static function isValid($input)
    {
        return preg_match('/^-{3}\r?\n(.*)\r?\n-{3}\r?\n/s', $input) == 1;
    }

    /**
     * @param $input
     *
     * @return Document
     */
    public static function parse($input)
    {
        // if input is a file, process it
        $file = '';
        if (strpos($input, "\n") === false && is_file($input)) {
            if (false === is_readable($input)) {
                throw new ParseException(sprintf('Unable to parse "%s" as the file is not readable.', $input));
            }
            $file = $input;
            $input = file_get_contents($file);
        }

        if (!preg_match('/^-{3}\r?\n(.*)\r?\n-{3}\r?\n/s', $input, $matches)) {
            return new Document($input);
        }

        return new Document(
            substr($input, strlen($matches[0])),
            Yaml::parse($matches[1])
        );
    }

    /**
     * @param Document $document
     *
     * @return string
     */
    public static function dump(Document $document)
    {
        return sprintf(
            "---\n%s\n---\n%s",
            trim(Yaml::dump($document->getConfig())),
            $document->getContent()
        );
    }

} 