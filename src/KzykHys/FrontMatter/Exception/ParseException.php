<?php

namespace KzykHys\FrontMatter\Exception;

use Symfony\Component\Yaml\Exception\ParseException as BaseParseException;

/**
 * Exception class thrown when an error occurs during parsing.
 *
 * @author Michael van Engelshoven <michael@van-engelshoven.de>
 */
class ParseException extends BaseParseException
{

}