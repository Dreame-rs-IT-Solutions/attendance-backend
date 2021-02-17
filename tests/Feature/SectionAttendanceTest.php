<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SectionAttendanceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testTeacherSectionAttendanceIndex() {
        $teacherUser = factory(\App\User::class)->create(['role' => 'TEACHER']);
        $teacher = factory(\App\Teacher::class)->create(['user_id' => $teacherUser->id]);
        $section = factory(\App\Section::class)->create(['teacher_id' => $teacher->id]);
        $student = factory(\App\Student::class)->create(['section_id' => $section->id]);

        $attendanceDate = '2021-12-12';
        factory(\App\Attendance::class, 5)->create(['student_id' => $student->id, 'date' => $attendanceDate, 'status' => 'PRESENT']);

        $this->actingAs($teacherUser, 'api')
        ->getJson(route('teacher.sections.attendances.index', ['section' => $section]) . '?date=' . $attendanceDate )
        ->assertStatus(200)
        ->assertJsonStructure([[
            'id', 'date', 'status'
        ]]);
    }
}
