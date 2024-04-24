<?php

namespace App\Enums;

enum ProgramEntityType: string
{
    case USERS  = 'users';
    case CHALLENGES = 'challenges';
    case COMPANIES = 'companies';
}