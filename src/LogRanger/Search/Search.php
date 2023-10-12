<?php
/*
 * Copyright (c) 2022. Tom Wilford <hello@jollyblueman.com>
 * All rights reserved.
 *
 * This source code is licensed under the BSD-style license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace TomWilf\LogRanger\Search;

use TomWilf\LogRanger\Search\Paths\Paths;

class Search
{
    private $paths;
    private $startDate;
    private $endDate;
    private $output;

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
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate): void
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
    public function setEndDate($endDate): void
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
    public function setOutput($output): void
    {
        $this->output = $output;
    }
}