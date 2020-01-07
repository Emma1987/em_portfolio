<?php

namespace App\CustomInterface;

/**
 * Interface TemplatedMailInterface
 * @package App\AppInterface
 */
interface TemplatedMailInterface
{
    /**
     * Return the mail subject
     *
     * @return string
     */
    public function getSubject(): string;

    /**
     * Return the mail template
     *
     * @return string
     */
    public function getTemplate(): string;

    /**
     * Return the parameters for template
     *
     * @return array
     */
    public function getContext(): array;
}
