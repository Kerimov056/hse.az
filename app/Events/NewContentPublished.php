<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class NewContentPublished
{
    use Dispatchable;

    public function __construct(
        public string $type,     // course/service/topic/vacancy/resource
        public string $title,
        public string $url,
        public ?string $excerpt = null
    ) {}
}
