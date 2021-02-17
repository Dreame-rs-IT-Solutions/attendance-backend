<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testTeacherSectionStudentIndex() {
        $teacherUser = factory(\App\User::class)->create(['role' => 'TEACHER']);
        $teacher = factory(\App\Teacher::class)->create(['user_id' => $teacherUser->id]);
        $section = factory(\App\Section::class)->create(['teacher_id' => $teacher->id]);
        $student = factory(\App\Student::class)->create(['section_id' => $section->id]);
        factory(\App\Attendance::class, 5)->create(['student_id' => $student->id, 'status' => 'PRESENT']);

        $this->actingAs($teacherUser, 'api')
        ->getJson(route('teacher.students.attendances.index', ['student' => $student->id]))
        ->assertStatus(200)
        ->assertJsonStructure([[
            'id', 'date', 'status'
        ]]);
    }

    public function testTeacherSectionStudentStore() {
        $teacherUser = factory(\App\User::class)->create(['role' => 'TEACHER']);
        $teacher = factory(\App\Teacher::class)->create(['user_id' => $teacherUser->id]);
        $section = factory(\App\Section::class)->create(['teacher_id' => $teacher->id]);
        $student = factory(\App\Student::class)->create(['section_id' => $section->id]);

        $studentData = [
            'student' => $student->id,
            'date' => '2021-12-12',
            'status' => 'PRESENT'
        ];

        $this->actingAs($teacherUser, 'api')
        ->postJson(route('teacher.students.attendances.store', $studentData))
        ->assertStatus(201)
        ->assertJsonStructure([
            'id', 'date', 'status'
        ]);
    }

    public function testTeacherSectionStudentShow() {
        $teacherUser = factory(\App\User::class)->create(['role' => 'TEACHER']);
        $teacher = factory(\App\Teacher::class)->create(['user_id' => $teacherUser->id]);
        $section = factory(\App\Section::class)->create(['teacher_id' => $teacher->id]);
        $student = factory(\App\Student::class)->create(['section_id' => $section->id]);
        $attendance = factory(\App\Attendance::class)->create(['student_id' => $student->id, 'status' => 'PRESENT']);

        $this->actingAs($teacherUser, 'api')
        ->getJson(route('teacher.students.attendances.show', ['student' => $student->id, 'attendance' => $attendance->id]))
        ->assertStatus(200)
        ->assertJsonStructure([
            'id', 'date', 'status'
        ]);
    }

    public function testTeacherSectionStudentUpdate() {
        $teacherUser = factory(\App\User::class)->create(['role' => 'TEACHER']);
        $teacher = factory(\App\Teacher::class)->create(['user_id' => $teacherUser->id]);
        $section = factory(\App\Section::class)->create(['teacher_id' => $teacher->id]);
        $student = factory(\App\Student::class)->create(['section_id' => $section->id]);
        $attendance = factory(\App\Attendance::class)->create(['student_id' => $student->id, 'status' => 'PRESENT']);

        $attendanceData = [
            'student' => $student->id,
            'attendance' => $attendance->id,
            'date' => '2021-12-12',
            'status' => 'ABSENT'
        ];

        $this->actingAs($teacherUser, 'api')
        ->putJson(route('teacher.students.attendances.update', $attendanceData))
        ->assertStatus(200)
        ->assertJsonStructure([
            'id', 'date', 'status'
        ]);
    }

    public function testTeacherSectionStudentDestroy() {
        $teacherUser = factory(\App\User::class)->create(['role' => 'TEACHER']);
        $teacher = factory(\App\Teacher::class)->create(['user_id' => $teacherUser->id]);
        $section = factory(\App\Section::class)->create(['teacher_id' => $teacher->id]);
        $student = factory(\App\Student::class)->create(['section_id' => $section->id]);
        $attendance = factory(\App\Attendance::class)->create(['student_id' => $student->id, 'status' => 'PRESENT']);

        $this->actingAs($teacherUser, 'api')
        ->delete(route('teacher.students.attendances.destroy', ['student' => $student->id, 'attendance' => $attendance->id]))
        ->assertStatus(200);
    }
}
