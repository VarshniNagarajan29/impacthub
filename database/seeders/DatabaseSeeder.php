<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $volunteer = User::factory()->create([
            'name' => 'Demo Volunteer',
            'email' => 'volunteer@example.com',
        ]);

        $secondVolunteer = User::factory()->create([
            'name' => 'Second Volunteer',
            'email' => 'second-volunteer@example.com',
        ]);

        $organiser = User::factory()->organiser()->create([
            'name' => 'Demo Organiser',
            'email' => 'organiser@example.com',
        ]);

        User::factory()->administrator()->create([
            'name' => 'Demo Administrator',
            'email' => 'admin@example.com',
        ]);

        $organisation = $organiser->organisations()->create([
            'name' => 'Impact Community Group',
            'description' => 'A community organisation creating practical local volunteering opportunities.',
        ]);

        $categories = collect([
            'Environment',
            'Food Distribution',
            'Community Education',
            'Animal Welfare',
        ])->mapWithKeys(function (string $name): array {
            return [
                $name => Category::factory()->create([
                    'name' => $name,
                ]),
            ];
        });

        $skills = collect([
            'Gardening',
            'First Aid',
            'Cooking',
            'Driving',
            'Event Coordination',
            'Photography',
        ])->mapWithKeys(function (string $name): array {
            return [
                $name => Skill::factory()->create([
                    'name' => $name,
                ]),
            ];
        });

        $eventDefinitions = [
            [
                'category' => 'Environment',
                'title' => 'Community Garden Preparation Day',
                'description' => 'Help prepare garden beds and plant seasonal vegetables for local residents.',
                'location' => 'Southport Community Garden',
                'capacity' => 20,
                'latitude' => -27.9672,
                'longitude' => 153.4000,
                'skills' => ['Gardening', 'Event Coordination'],
            ],
            [
                'category' => 'Food Distribution',
                'title' => 'Weekend Food Relief Drive',
                'description' => 'Help sort, pack, and distribute food parcels to families in the local community.',
                'location' => 'Labrador Community Centre',
                'capacity' => 15,
                'latitude' => -27.9420,
                'longitude' => 153.3990,
                'skills' => ['Cooking', 'Driving'],
            ],
            [
                'category' => 'Community Education',
                'title' => 'Digital Skills Support Session',
                'description' => 'Support community members with basic computer and online service skills.',
                'location' => 'Broadbeach Community Hub',
                'capacity' => 10,
                'latitude' => -28.0278,
                'longitude' => 153.4300,
                'skills' => ['First Aid', 'Photography'],
            ],
        ];

        foreach ($eventDefinitions as $definition) {
            $event = Event::factory()
                ->for($organisation, 'organisation')
                ->for($categories[$definition['category']], 'category')
                ->create([
                    'title' => $definition['title'],
                    'description' => $definition['description'],
                    'location' => $definition['location'],
                    'starts_at' => now()->addDays(10),
                    'capacity' => $definition['capacity'],
                    'latitude' => $definition['latitude'],
                    'longitude' => $definition['longitude'],
                ]);

            $skillIds = collect($definition['skills'])
                ->map(fn (string $skillName): int => $skills[$skillName]->id)
                ->all();

            $event->skills()->sync($skillIds);
        }

        $firstEvent = Event::query()->first();
        $secondEvent = Event::query()->skip(1)->first();

        Registration::factory()
            ->for($firstEvent, 'event')
            ->for($volunteer, 'user')
            ->create();

        Registration::factory()
            ->for($secondEvent, 'event')
            ->for($volunteer, 'user')
            ->create();

        Registration::factory()
            ->for($firstEvent, 'event')
            ->for($secondVolunteer, 'user')
            ->create();
    }
}