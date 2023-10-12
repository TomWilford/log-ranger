<?php
/*
 * Copyright (c) 2022. Tom Wilford <hello@jollyblueman.com>
 * All rights reserved.
 *
 * This source code is licensed under the BSD-style license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace TomWilf\LogRanger\Input;

class Validator
{
    private $paths;
    private $startDate;
    private $endDate;
    private $output;
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
    private function setPaths($paths): void
    {
        $this->paths = $paths;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    private function setStartDate($startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param mixed $endDate
     */
    private function setEndDate($endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return mixed
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @param mixed $output
     */
    private function setOutput($output): void
    {
        $this->output = $output;
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
    private function setErrors($errors): void
    {
        $this->errors = $errors;
    }

    public function execute($inputArray)
    {
        
        foreach ($inputArray as $key => $value) {
            switch ($key) {
                case 'path':
                    $this->setPaths($value);
                    break;
                default:
                    break;
            }
        }

        return $this;
    }
}