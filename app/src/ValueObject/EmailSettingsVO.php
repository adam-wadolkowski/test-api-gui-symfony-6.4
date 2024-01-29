<?php

declare(strict_types=1);

namespace App\ValueObject;

use Symfony\Component\Mime\Address;

final readonly class EmailSettingsVO
{
    public function __construct(
        public Address $from,
        public string $to,
        public string $subject,
        public string $text,
        public string $html
    ) {
    }
}
