<?php
/*
 * Copyright (c) 2022. Tom Wilford <hello@jollyblueman.com>
 * All rights reserved.
 *
 * This source code is licensed under the BSD-style license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace TomWilf\LogRanger\Search\Paths;

class Validator
{
    public function validator(Paths $paths)
    {
        return $this->validateFilePathsExist($paths);
    }

    private function validateFilePathsExist(Paths $paths)
    {
        foreach ($paths->getPaths() as $path) {
            if (!is_file($path) || !is_dir($path)) {
                $errors = $paths->getErrors();
                $paths->setErrors(array_push($errors,  $path . " is not a valid file or folder."));
            }
        }

        return $paths;
    }
}