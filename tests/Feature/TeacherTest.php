<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeacherTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testAdministratorTeacherIndex() {
        factory(\App\User::class, 5)->create(['role' => 'TEACHER'])->each(function($user) {
            factory(\App\Teacher::class, 5)->create(['user_id' => $user->id]);
        });

        $administrator = factory(\App\User::class)->create(['role' => 'ADMINISTRATOR']);
        $this->actingAs($administrator, 'api')
        ->getJson(route('admin.teachers.index'))
        ->assertStatus(200)
        ->assertJsonStructure([[
            'id', 'name', 'user' => ['username', 'role']
        ]]);
    }

    public function testAdministratorTeacherStore() {
        $teacherData = [
            'username' => 'teacherprof',
            'password' => 'teacherprof',
            'password_confirmation' => 'teacherprof',

            'name' => 'teacherprof',
        ];

        $administrator = factory(\App\User::class)->create(['role' => 'ADMINISTRATOR']);
        $this->actingAs($administrator, 'api')
        ->postJson(route('admin.teachers.store', $teacherData))
        ->assertStatus(201)
        ->assertJsonStructure([
            'id', 'name', 'user' => ['username', 'role']
        ]);
    }

    public function testAdministratorTeacherShow() {
        $teacherUser = factory(\App\User::class)->create(['role' => 'TEACHER']);
        $teacher = factory(\App\Teacher::class)->create(['user_id' => $teacherUser->id]);

        $administrator = factory(\App\User::class)->create(['role' => 'ADMINISTRATOR']);
        $this->actingAs($administrator, 'api')
        ->getJson(route('admin.teachers.show', ['teacher' => $teacher->id]))
        ->assertStatus(200)
        ->assertJsonStructure([
            'id', 'name', 'user' => ['username', 'role']
        ]);
    }

    public function testAdministratorTeacherUpdate() {
        $teacherUser = factory(\App\User::class)->create(['role' => 'TEACHER']);
        $teacher = factory(\App\Teacher::class)->create(['user_id' => $teacherUser->id]);

        $teacherData = [
            'teacher' => $teacher->id,
            'username' => 'teacherprof',
            'name' => 'teacherprof',
        ];

        $administrator = factory(\App\User::class)->create(['role' => 'ADMINISTRATOR']);
        $this->actingAs($administrator, 'api')
        ->putJson(route('admin.teachers.update', $teacherData))
        ->assertStatus(200)
        ->assertJsonStructure([
            'id', 'name', 'user' => ['username', 'role']
        ]);
    }

    public function testAdministratorTeacherDestroy() {
        $teacherUser = factory(\App\User::class)->create(['role' => 'TEACHER']);
        $teacher = factory(\App\Teacher::class)->create(['user_id' => $teacherUser->id]);

        $administrator = factory(\App\User::class)->create(['role' => 'ADMINISTRATOR']);
        $this->actingAs($administrator, 'api')
        ->deleteJson(route('admin.teachers.destroy', ['teacher' => $teacher->id]))
        ->assertStatus(200);
    }
}
