<?php

declare(strict_types=1);

namespace model;

/**
 * Get label
 */
trait GetLabel
{
    private function getLabel($file_name, $sections = true)
    {
        return parse_ini_file($file_name, $sections);
    }
}