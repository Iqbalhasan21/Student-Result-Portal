<?php

namespace Tests\Feature;

use App\Models\Result;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class StudentResultPortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_and_result_schema_and_relationships_are_defined(): void
    {
        $this->assertTrue(Schema::hasColumns('students', ['name', 'roll', 'department', 'email']));
        $this->assertTrue(Schema::hasColumns('results', ['student_id', 'course_code', 'marks', 'grade']));

        $student = Student::create([
            'name' => 'Amina Rahman',
            'roll' => 'CSE-101',
            'department' => 'CSE',
            'email' => 'amina@example.com',
        ]);

        $result = $student->results()->create(['course_code' => 'CSE-3208', 'marks' => 85]);

        $this->assertInstanceOf(Result::class, $student->results()->first());
        $this->assertSame($student->id, $result->student->id);
        $this->assertSame('A+', $result->grade);
    }

    public function test_guests_can_view_students_but_student_mutations_require_authentication(): void
    {
        $student = $this->makeStudent();

        $this->get(route('students.index'))->assertOk()->assertSee('Student Result Portal');
        $this->get(route('students.show', $student))->assertOk();
        $this->get(route('students.create'))->assertRedirect(route('login'));
        $this->get(route('students.edit', $student))->assertRedirect(route('login'));
        $this->post(route('students.store'), [])->assertRedirect(route('login'));
        $this->put(route('students.update', $student), [])->assertRedirect(route('login'));
        $this->delete(route('students.destroy', $student))->assertRedirect(route('login'));

        $result = $student->results()->create(['course_code' => 'CSE-3208', 'marks' => 85]);
        $this->post(route('results.store', $student), ['course_code' => 'CSE-3209', 'marks' => 70])
            ->assertRedirect(route('login'));
        $this->delete(route('results.destroy', $result))->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_create_update_and_delete_students(): void
    {
        $this->actingAs(User::factory()->create());

        $payload = [
            'name' => 'Amina Rahman',
            'roll' => 'CSE-101',
            'department' => 'CSE',
            'email' => 'amina@example.com',
        ];

        $this->post(route('students.store'), $payload)->assertRedirect(route('students.index'));
        $student = Student::where('roll', 'CSE-101')->firstOrFail();
        $this->assertDatabaseHas('students', $payload);

        $updated = [...$payload, 'name' => 'Amina Rahman Updated', 'email' => 'amina.updated@example.com'];
        $this->put(route('students.update', $student), $updated)->assertRedirect(route('students.show', $student));
        $this->assertDatabaseHas('students', ['id' => $student->id, 'name' => 'Amina Rahman Updated']);

        $this->delete(route('students.destroy', $student))->assertRedirect(route('students.index'));
        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }

    public function test_student_and_result_validation_errors_are_returned_to_the_blade_form(): void
    {
        $this->actingAs(User::factory()->create());
        $student = $this->makeStudent();

        $this->from(route('students.create'))
            ->followingRedirects()
            ->post(route('students.store'), ['name' => '', 'roll' => '', 'department' => '', 'email' => 'bad'])
            ->assertOk()
            ->assertSee('The name field is required.')
            ->assertSee('The roll field is required.');

        $this->from(route('students.show', $student))
            ->followingRedirects()
            ->post(route('results.store', $student), ['course_code' => '', 'marks' => 101])
            ->assertOk()
            ->assertSee('The course code field is required.')
            ->assertSee('The marks field must be between 0 and 100.');

        $this->assertDatabaseCount('results', 0);
    }

    public function test_authenticated_result_management_calculates_grade_and_shows_it_on_student_page(): void
    {
        $this->actingAs(User::factory()->create());
        $student = $this->makeStudent();

        $this->from(route('students.show', $student))
            ->post(route('results.store', $student), ['course_code' => 'CSE-3208', 'marks' => 72])
            ->assertRedirect(route('students.show', $student));

        $result = $student->results()->firstOrFail();
        $this->assertSame('A', $result->grade);
        $this->get(route('students.show', $student))->assertOk()->assertSee('CSE-3208')->assertSee('A');

        $this->from(route('students.show', $student))
            ->delete(route('results.destroy', $result))
            ->assertRedirect(route('students.show', $student));
        $this->assertDatabaseMissing('results', ['id' => $result->id]);
    }

    private function makeStudent(): Student
    {
        return Student::create([
            'name' => 'Amina Rahman',
            'roll' => 'CSE-101',
            'department' => 'CSE',
            'email' => 'amina@example.com',
        ]);
    }
}
