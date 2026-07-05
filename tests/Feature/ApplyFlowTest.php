<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\Internship;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplyFlowTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_student_can_apply_to_an_internship(): void
    {
        $student = User::where('email', 'student@example.com')->firstOrFail();

        // An internship the demo student has not applied to yet.
        $internship = Internship::whereDoesntHave('applications', function ($query) use ($student) {
            $query->where('student_id', $student->userable->id);
        })->firstOrFail();

        $this->actingAs($student)
            ->post("/internship/{$internship->id}/apply", [
                'cover_letter' => str_repeat('I care about this role and can contribute from week one. ', 5),
                'message' => str_repeat('Available to start immediately and happy to talk. ', 3),
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('applications', [
            'student_id' => $student->userable->id,
            'internship_id' => $internship->id,
            'status' => 'submitted',
        ]);
    }

    public function test_company_can_advance_an_application_to_offer(): void
    {
        $application = Application::where('status', 'submitted')->firstOrFail();
        $companyUser = $application->company->user;

        $this->actingAs($companyUser)
            ->post("/applications/{$application->id}", ['status' => 'offer'])
            ->assertRedirect();

        $this->assertSame('offer', $application->fresh()->status);
    }

    public function test_student_can_withdraw_a_pending_application(): void
    {
        $student = User::where('email', 'student@example.com')->firstOrFail();
        $application = Application::where('student_id', $student->userable->id)
            ->where('status', 'submitted')
            ->firstOrFail();

        $this->actingAs($student)
            ->delete("/applications/{$application->id}")
            ->assertRedirect();

        $this->assertDatabaseMissing('applications', ['id' => $application->id]);
    }
}
