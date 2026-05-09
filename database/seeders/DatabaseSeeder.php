<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            FieldSeeder::class,
            CitySeeder::class,
            CompanySeeder::class,
            StudentSeeder::class,
            InternshipSeeder::class,
            MessageSeeder::class,
            ApplicationSeeder::class,
        ]);

        $password = bcrypt('password');
        \App\Models\Student::factory()->create()
            ->user()
            ->save(User::create([
                'name' => 'Ala Baganne',
                'email' => 'student@example.com',
                'password' => $password,
				'phone_number' => '50101959',
                'is_admin' => false
            ]));

        $company = \App\Models\Company::factory()->create();
        $company->user()->save(User::create([
            'name' => 'Realinflo',
            'email' => 'company@example.com',
            'password' => $password,
			'phone_number' => '22652543',
            'is_admin' => false
        ]));
        $company->internships()->saveMany(
            \App\Models\Internship::factory(5)->create([
				'city_id' => $company->city_id,
			])
        );

        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Platform Admin',
                'password' => $password,
                'phone_number' => '00000000',
                'is_admin' => true,
                'userable_id' => null,
                'userable_type' => null,
            ]
        );
    }
}
