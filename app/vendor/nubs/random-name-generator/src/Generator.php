<?php

namespace Nubs\RandomNameGenerator;

/**
 * Defines the standard interface for all the random name generators.
 */
interface Generator
{
    /**
     * Gets a randomly generated name.
     *
     * @return string A random name.
     * @api
     */
    public function getName();
}
