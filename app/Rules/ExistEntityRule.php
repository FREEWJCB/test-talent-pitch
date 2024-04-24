<?php

namespace App\Rules\Rules;

// use App\Enums\ProgramEntityType;

use App\Enums\ProgramEntityType;
use App\Models\Challenge;
use App\Models\Company;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;

class ExistEntityRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $entities, Closure $fail): void
    {
        $userIds = [];
        $challengeIds = [];
        $companyIds = [];
        // users
        //filter the users
        $users = array_filter($entities, function($k) {
            return $k['type'] === ProgramEntityType::USERS;
        });
        if(count($users) > 0) {
            foreach ($users as $user) {
                // push ids
                array_push($userIds, $user['id']);
            }
            $usersCount = User::newQuery()->whereIn('id', $userIds)->count();
            Log::error("usersCount', $usersCount");
        }
        //challenges
        //filter the challenges
        $challenges = array_filter($entities, function($k) {
            return $k['type'] === ProgramEntityType::CHALLENGES;
        });
        if(count($challenges) > 0) {
            foreach ($challenges as $challenge) {
                // push ids
                array_push($challengeIds, $challenge['id']);
            }
            $challengesCount = Challenge::newQuery()->whereIn('id', $challengeIds)->count();
        }
        //companies
        //filter the companies
        $companies = array_filter($entities, function($k) {
            return $k['type'] === ProgramEntityType::COMPANIES;
        });
        if(count($companies) > 0) {
            foreach ($companies as $company) {
                // push ids
                array_push($companyIds, $company['id']);
            }
            $companiesCount = Company::newQuery()->whereIn('id', $challengeIds)->count();
        }

        if($usersCount != count($users) || $challengesCount != count($challenges) || $companiesCount != count($companies))
        $fail();
    }
}