<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_opening_a_notification_marks_it_read_and_follows_its_action(): void
    {
        $student = User::where('email', 'student@example.com')->first();
        $notification = $student->notifications()->whereNull('read_at')->first();

        $this->actingAs($student)
            ->post(route('notifications.store', $notification->id))
            ->assertRedirect($notification->data['action']);

        $this->assertNotNull($notification->fresh()->read_at);
    }

    public function test_users_cannot_touch_someone_elses_notifications(): void
    {
        $student = User::where('email', 'student@example.com')->first();
        $company = User::where('email', 'company@example.com')->first();
        $notification = $student->notifications()->whereNull('read_at')->first();

        $this->actingAs($company)
            ->post(route('notifications.store', $notification->id))
            ->assertForbidden();

        $this->assertNull($notification->fresh()->read_at);
    }

    public function test_clear_deletes_only_the_current_users_notifications(): void
    {
        $student = User::where('email', 'student@example.com')->first();
        $company = User::where('email', 'company@example.com')->first();

        $this->actingAs($student)->get(route('notifications.clear'))->assertRedirect();

        $this->assertSame(0, $student->notifications()->count());
        $this->assertGreaterThan(0, $company->notifications()->count());
    }
}
