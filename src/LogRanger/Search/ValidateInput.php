<?php
/*
 * Copyright (c) 2022. Tom Wilford <hello@jollyblueman.com>
 * All rights reserved.
 *
 * This source code is licensed under the BSD-style license found in the
 * LICENSE file in the root directory of this source tree.
 */

namespace TomWilf\LogRanger\Search;

class ValidateInput
{
    public static function path($input)
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