<?php

namespace App\Enum;

enum Status: string
{
    case AVAILABLE = 'Available';
    case LOANED = 'Loaned';
    case RESERVED = 'Reserved';
    case DAMAGED = 'Damaged';
}