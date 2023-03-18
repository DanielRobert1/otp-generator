<?php

namespace DanielRobert\Otp\Contracts;

interface ClearableRepository
{
    /**
     * Clear all of the entries.
     *
     * @return void
     */
    public function clear();
}