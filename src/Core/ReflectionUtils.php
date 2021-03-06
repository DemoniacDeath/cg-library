<?php

/*
 * Copyright 2011 Johannes M. Schmitt <schmittjoh@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace CG\Core;

use ReflectionClass;
use ReflectionMethod;

abstract class ReflectionUtils
{
    /**
     * @param ReflectionClass $class
     * @param boolean $publicOnly
     * @return array
     */
    public static function getOverrideableMethods(ReflectionClass $class, $publicOnly = false): array
    {
        $filter = ReflectionMethod::IS_PUBLIC;

        if (!$publicOnly) {
            $filter |= ReflectionMethod::IS_PROTECTED;
        }

        return array_filter(
            $class->getMethods($filter),
            static function(ReflectionMethod $method) { return !$method->isFinal() && !$method->isStatic(); }
        );
    }

    /**
     * @param string $docComment
     * @return string
     */
    public static function getUnindentedDocComment($docComment): string
    {
        $docBlock = '';
        $lines = explode("\n", $docComment);
        $c = count($lines);
        foreach ($lines as $i => $iValue) {
            if (0 === $i) {
                $docBlock = $lines[0]."\n";
                continue;
            }

            $docBlock .= ' '.ltrim($iValue);

            if ($i+1 < $c) {
                $docBlock .= "\n";
            }
        }

        return $docBlock;
    }
}
