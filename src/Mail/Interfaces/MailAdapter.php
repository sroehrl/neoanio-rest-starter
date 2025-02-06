<?php

namespace App\Mail\Interfaces;

use Neoan\Routing\Interfaces\Routable;

interface MailAdapter extends Routable
{
    public function __construct(array $setup = []);
    public function addRecipient(string $email, string $name, $variables = []): static;
    public function addCC(string $email, string $name, $variables = []): static;
    public function addBCC(string $email, string $name, $variables = []): static;
    public function setFrom(string $email, string $name): static;
    public function setSubject(string $subject): static;
    public function setTemplate(string|int $template): static;
    public function setVariables(array $variables): static;
    public function setVariable(string|int $key, $value): static;
    public function addAttachment(string $path, ?string $filename = null): static;
    public function htmlBody(string $html): static;
    public function textBody(string $plainText): static;
    public function send(?array $options = null);
}