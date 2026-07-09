<?php

namespace App\Enums;

enum Module: string
{
    case USERS = 'USERS';
    case PRODUCTS = 'PRODUCTS';
    case PROFILES = 'PROFILES';
    case SECTIONS = 'SECTIONS';
    case AUDIT_LOGS = 'AUDIT_LOGS';
    case AUTH = 'AUTH';
}
