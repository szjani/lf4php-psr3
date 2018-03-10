<?php
declare(strict_types=1);

namespace lf4php\impl;

use Exception;

class Psr3ParamHolder
{
    private $message;
    private $context;

    private function __construct(string $message, array $context = array())
    {
        $this->message = $message;
        $this->context = $context;
    }

    /**
     * @param $lf4phpFormat
     * @param array $lf4phpParams
     * @param Exception $exception
     * @return Psr3ParamHolder
     */
    public static function create($lf4phpFormat, array $lf4phpParams = array(), Exception $exception = null) : Psr3ParamHolder
    {
        $counter = -1;
        $message = preg_replace_callback(
            '#{}#',
            function () use (&$counter) {
                $counter++;
                return "{{$counter}}";
            },
            $lf4phpFormat
        );
        $context = $lf4phpParams;
        if ($exception !== null) {
            $context['exception'] = $exception;
        }
        return new Psr3ParamHolder($message, $context);
    }

    /**
     * @return string
     */
    public function getMessage() : string
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function getContext() : array
    {
        return $this->context;
    }
}
