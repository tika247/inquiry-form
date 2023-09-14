<?php

declare(strict_types=1);

namespace model;

/**
 * Remove Control Code
 * @param  string
 */
trait RemoveControlCode
{
    private function removeControlCode(string $string)
    {
        return preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]/', '', $string);
    }
}