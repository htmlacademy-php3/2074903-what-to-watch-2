<?php

declare(strict_types=1);

namespace App\Factories\Dto;

class UserDto extends Dto
{
    public function __construct(
        readonly array $params,
        readonly ?int $fileId = null
    )
    {
        parent::__construct(
            params: $params
        );
    }
}