<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StudentTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testTeacherSectionStudentIndex() {
        $teacherUser = factory(\App\User::class)->create(['role' => 'TEACHER']);
        $teacher = factory(\App\Teacher::class)->create(['user_id' => $teacherUser->id]);
        $section = factory(\App\Section::class)->create(['teacher_id' => $teacher->id]);
        factory(\App\Student::class, 5)->create(['section_id' => $section->id]);

        $this->actingAs($teacherUser, 'api')
        ->getJson(route('teacher.sections.students.index', ['section' => $section->id]))
        ->assertStatus(200)
        ->assertJsonStructure([[
            'id', 'name'
        ]]);
    }

    public function testTeacherSectionStudentStore() {
        $teacherUser = factory(\App\User::class)->create(['role' => 'TEACHER']);
        $teacher = factory(\App\Teacher::class)->create(['user_id' => $teacherUser->id]);
        $section = factory(\App\Section::class)->create(['teacher_id' => $teacher->id]);

        $studentData = [
            'section' => $section->id,
            'name' => 'teachersection',
        ];

        $this->actingAs($teacherUser, 'api')
        ->postJson(route('teacher.sections.students.store', $studentData))
        ->assertStatus(201)
        ->assertJsonStructure([
            'id', 'name'
        ]);
    }

    public function testTeacherSectionStudentShow() {
        $teacherUser = factory(\App\User::class)->create(['role' => 'TEACHER']);
        $teacher = factory(\App\Teacher::class)->create(['user_id' => $teacherUser->id]);
        $section = factory(\App\Section::class)->create(['teacher_id' => $teacher->id]);
        $student = factory(\App\Student::class)->create(['section_id' => $section->id]);

        $this->actingAs($teacherUser, 'api')
        ->getJson(route('teacher.sections.students.show', ['section' => $section->id, 'student' => $student->id]))
        ->assertStatus(200)
        ->assertJsonStructure([
            'id', 'name',
        ]);
    }

    public function testTeacherSectionStudentUpdate() {
        $teacherUser = factory(\App\User::class)->create(['role' => 'TEACHER']);
        $teacher = factory(\App\Teacher::class)->create(['user_id' => $teacherUser->id]);
        $section = factory(\App\Section::class)->create(['teacher_id' => $teacher->id]);
        $student = factory(\App\Student::class)->create(['section_id' => $section->id]);

        $studentData = [
            'section' => $section->id,
            'student' => $student->id,
            'name' => 'teachersection',
        ];

        $this->actingAs($teacherUser, 'api')
        ->putJson(route('teacher.sections.students.update', $studentData))
        ->assertStatus(200)
        ->assertJsonStructure([
            'id', 'name',
        ]);
    }

    public function testTeacherSectionStudentDestroy() {
        $teacherUser = factory(\App\User::class)->create(['role' => 'TEACHER']);
        $teacher = factory(\App\Teacher::class)->create(['user_id' => $teacherUser->id]);
        $section = factory(\App\Section::class)->create(['teacher_id' => $teacher->id]);
        $student = factory(\App\Student::class)->create(['section_id' => $section->id]);

        $this->actingAs($teacherUser, 'api')
        ->delete(route('teacher.sections.students.destroy', ['section' => $section->id, 'student' => $student->id]))
        ->assertStatus(200);
    }
}
