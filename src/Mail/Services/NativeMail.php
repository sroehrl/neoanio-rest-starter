<?php

namespace App\Mail\Services;

use App\Mail\Interfaces\MailAdapter;

class NativeMail implements MailAdapter
{
    private array $recipients = [];

    private array $from = [];

    private array $headers = [];

    public function __invoke(): static
    {
        return $this;
    }

    public function __construct(array $setup = [])
    {
    }

    public function addRecipient(string $email, string $name, $variables = []): static
    {
        $this->recipients[] = ['email' => $email, 'name' => $name, 'variables' => $variables, 'type' => 'recipient'];
        return $this;
    }

    public function addCC(string $email, string $name, $variables = []): static
    {
        $this->recipients[] = ['email' => $email, 'name' => $name, 'variables' => $variables, 'type' => 'cc'];
        return $this;
    }

    public function addBCC(string $email, string $name, $variables = []): static
    {
        $this->recipients[] = ['email' => $email, 'name' => $name, 'variables' => $variables, 'type' => 'bcc'];
        return $this;
    }

    public function setFrom(string $email, string $name): static
    {
        $this->from = ['email' => $email, 'name' => $name];
        return $this;
    }

    public function setSubject(string $subject): static
    {
        // TODO: Implement setSubject() method.
    }

    public function setTemplate(int|string $template): static
    {
        // TODO: Implement setTemplate() method.
    }

    public function setVariables(array $variables): static
    {
        // TODO: Implement setVariables() method.
    }

    public function setVariable(int|string $key, $value): static
    {
        // TODO: Implement setVariable() method.
    }

    public function addAttachment(string $path, ?string $filename = null): static
    {
        // TODO: Implement addAttachment() method.
    }

    public function htmlBody(string $html): static
    {
        // TODO: Implement htmlBody() method.
    }

    public function textBody(string $plainText): static
    {
        // TODO: Implement textBody() method.
    }

    public function send(?array $options = null)
    {
        // TODO: Implement send() method.
    }
}