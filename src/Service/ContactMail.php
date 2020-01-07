<?php

namespace App\Service;

use App\CustomInterface\TemplatedMailInterface;

class ContactMail implements TemplatedMailInterface
{
    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $template;

    /**
     * @var array
     */
    private $context;

    /**
     * ContactMail constructor.
     * @param string $subject
     * @param string $template
     * @param array  $context
     */
    public function __construct(string $subject, string $template, array $context)
    {
        $this->setSubject($subject);
        $this->setTemplate($template);
        $this->setContext($context);
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @param mixed $template
     */
    public function setTemplate(string $template): void
    {
        $this->template = $template;
    }

    /**
     * @return array
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * @param array $context
     */
    public function setContext(array $context): void
    {
        $this->context = $context;
    }
}