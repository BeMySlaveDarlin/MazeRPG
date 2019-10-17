<?php

namespace Nubs\RandomNameGenerator;

abstract class AbstractGenerator implements Generator
{
    /**
     * Alias for getName so that the generator can be directly stringified.
     *
     * Note that this will return a different name everytime it is cast to a
     * string.
     *
     * @return string A random name.
     * @api
     */
    public function __toString()
    {
        return $this->getName();
    }
}
