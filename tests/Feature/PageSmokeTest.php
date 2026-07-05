<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\Company;
use App\Models\Internship;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class PageSmokeTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    private function student(): User
    {
        return User::where('email', 'student@example.com')->firstOrFail();
    }

    public function test_public_pages_render(): void
    {
        foreach (['/', '/about', '/contact', '/blog', '/internships', '/login', '/register'] as $uri) {
            $this->get($uri)->assertOk();
        }

        $slug = collect(config('internly_blog'))->first()['slug'];
        $this->get("/blog/{$slug}")->assertOk();

        $internship = Internship::firstOrFail();
        $this->get("/internships/{$internship->id}")
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Internships/Show')
                ->has('internship.title')
                ->has('internship.company.name'));
    }

    public function test_workspace_pages_render_for_students(): void
    {
        $student = $this->student();

        foreach (['/dashboard', '/applications', '/likes', '/messages', '/companies', '/profile', '/settings'] as $uri) {
            $this->actingAs($student)->get($uri)->assertOk();
        }

        $application = Application::where('student_id', $student->userable->id)->firstOrFail();
        $this->actingAs($student)
            ->get("/applications/{$application->id}")
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Applications/Show')
                ->has('application.internship.title')
                ->has('application.company.name'));

        $company = Company::firstOrFail();
        $this->actingAs($student)->get("/companies/{$company->id}")->assertOk();
    }

    public function test_dashboard_receives_real_props(): void
    {
        $this->actingAs($this->student())
            ->get('/dashboard')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Dashboard')
                ->where('internships_count', Internship::count())
                ->has('applications'));
    }

    public function test_internships_index_receives_filters_and_results(): void
    {
        $this->actingAs($this->student())
            ->get('/internships')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Internships/Index')
                ->has('internships.data')
                ->has('fields')
                ->has('cities'));
    }
}
