<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Seeder;
use OpenAI\Laravel\Facades\OpenAI;

/**
 * Seed program using GPT API
 */
class ProgramSeeder extends Seeder
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
                    'content' => 'Generate a JSON file with a key \'programs\' containing 10 fake programs. Populate it with fictional attributes such as title, description, start_date (date), and end_date (date).'],
            ],
        ]);

        $result = json_decode($query->choices[0]->message->content, true);

        $programs = $result['programs'];

        foreach ($programs as $program) {
            $newProgram = Program::make($program);
            $newProgram->user()->associate(User::factory()->create());
            $newProgram->save();
        }
    }
}