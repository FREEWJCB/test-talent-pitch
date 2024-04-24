<?php

namespace Database\Seeders;

use App\Models\Challenge;
use App\Models\User;
use Illuminate\Database\Seeder;
use OpenAI\Laravel\Facades\OpenAI;

/**
 * Seed challenges using GPT API
 */
class ChallengeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $query = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => 'Generate a JSON file with a key \'challenges\' containing 10 fake challenges. Populate it with fictional attributes such as title, description, and difficulty (ranging from 1 to 10).'
                ],
            ],
        ]);

        $result = json_decode($query->choices[0]->message->content, true);

        $challenges = $result['challenges'];

        foreach ($challenges as $challenge) {
            $newChallenge = Challenge::make($challenge);
            $newChallenge->user()->associate(User::factory()->create());
            $newChallenge->save();
        }
    }
}
