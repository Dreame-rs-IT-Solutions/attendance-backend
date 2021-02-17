<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SectionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testTeacherSectionIndex() {
        $teacherUser = factory(\App\User::class)->create(['role' => 'TEACHER']);
        $teacher = factory(\App\Teacher::class)->create(['user_id' => $teacherUser->id]);
        factory(\App\Section::class, 5)->create(['teacher_id' => $teacher->id]);

        $this->actingAs($teacherUser, 'api')
        ->getJson(route('teacher.sections.index'))
        ->assertStatus(200)
        ->assertJsonStructure([[
            'id', 'name'
        ]]);
    }

    public function testTeacherSectionStore() {
        $teacherUser = factory(\App\User::class)->create(['role' => 'TEACHER']);
        $teacher = factory(\App\Teacher::class)->create(['user_id' => $teacherUser->id]);

        $sectionData = [
            'name' => 'teachersection',
        ];

        $this->actingAs($teacherUser, 'api')
        ->postJson(route('teacher.sections.store', $sectionData))
        ->assertStatus(201)
        ->assertJsonStructure([
            'id', 'name'
        ]);
    }

    public function testTeacherSectionShow() {
        $teacherUser = factory(\App\User::class)->create(['role' => 'TEACHER']);
        $teacher = factory(\App\Teacher::class)->create(['user_id' => $teacherUser->id]);
        $section = factory(\App\Section::class)->create(['teacher_id' => $teacher->id]);

        $this->actingAs($teacherUser, 'api')
        ->getJson(route('teacher.sections.show', ['section' => $section->id]))
        ->assertStatus(200)
        ->assertJsonStructure([
            'id', 'name',
        ]);
    }

    public function testTeacherSectionUpdate() {
        $teacherUser = factory(\App\User::class)->create(['role' => 'TEACHER']);
        $teacher = factory(\App\Teacher::class)->create(['user_id' => $teacherUser->id]);
        $section = factory(\App\Section::class)->create(['teacher_id' => $teacher->id]);

        $sectionData = [
            'section' => $section->id,
            'name' => 'teachersection',
        ];

        $this->actingAs($teacherUser, 'api')
        ->putJson(route('teacher.sections.update', $sectionData))
        ->assertStatus(200)
        ->assertJsonStructure([
            'id', 'name',
        ]);
    }

    public function testTeacherSectionDestroy() {
        $teacherUser = factory(\App\User::class)->create(['role' => 'TEACHER']);
        $teacher = factory(\App\Teacher::class)->create(['user_id' => $teacherUser->id]);
        $section = factory(\App\Section::class)->create(['teacher_id' => $teacher->id]);

        $this->actingAs($teacherUser, 'api')
        ->delete(route('teacher.sections.destroy', ['section' => $section->id]))
        ->assertStatus(200);
    }
}
