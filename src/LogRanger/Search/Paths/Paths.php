<?php
/*
 * Copyright (c) 2022. Tom Wilford <hello@jollyblueman.com>
 * All rights reserved.
 *
 * This source code is licensed under the BSD-style license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace TomWilf\LogRanger\Search\Paths;

class Paths
{
    private $paths;
    private $errors;

    /**
     * @return mixed
     */
    public function getPaths()
    {
        return $this->paths;
    }

    /**
     * @param mixed $paths
     */
    public function setPaths($paths): void
    {
        $this->paths = $paths;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param mixed $errors
     */
    public function setErrors($errors): void
    {
        $this->errors = $errors;
    }

    /**
     * @param $pathArray
     */
    public function __construct($pathInput)
    {
        $this->setPaths($this->parseInput($pathInput));
    }

    private function parseInput($input)
    {
        $output = [];
        if (is_array($input)) {
            $output = filter_var_array(array_filter($input), FILTER_SANITIZE_ADD_SLASHES);
        } else {
            if (!empty($input)) {
                $output[] = filter_var($input, FILTER_SANITIZE_ADD_SLASHES);
            }
        }
        if (empty($output)) {
            return false;
        }
        return $output;
    }
}