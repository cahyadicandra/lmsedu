<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentDummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        // Get some active school classes
        $classes = \App\Models\SchoolClass::all();
        if ($classes->isEmpty()) {
            return;
        }

        foreach ($classes as $schoolClass) {
            // Find a teacher
            $teacher = \App\Models\User::where('role', 'Guru')->inRandomOrder()->first();
            if (!$teacher) continue;

            // Find a subject
            $subject = \App\Models\Subject::inRandomOrder()->first();
            if (!$subject) continue;

            // Seed Materials
            for ($i = 1; $i <= 3; $i++) {
                \App\Models\Material::create([
                    'subject_id' => $subject->id,
                    'teacher_id' => $teacher->id,
                    'school_class_id' => $schoolClass->id,
                    'title' => 'Materi ' . $i . ': ' . $faker->sentence(3),
                    'description' => $faker->paragraph(),
                    'published_at' => now()->subDays(rand(1, 10)),
                    'status' => 'Aktif',
                ]);
            }

            // Seed Assignments
            for ($i = 1; $i <= 2; $i++) {
                $assignment = \App\Models\Assignment::create([
                    'subject_id' => $subject->id,
                    'teacher_id' => $teacher->id,
                    'school_class_id' => $schoolClass->id,
                    'title' => 'Tugas ' . $i . ': ' . $faker->sentence(3),
                    'description' => $faker->paragraph(),
                    'due_date' => now()->addDays(rand(1, 7)),
                    'status' => 'Aktif',
                ]);

                // Seed Submissions for students in this class
                $students = \App\Models\User::where('role', 'Siswa')->where('school_class_id', $schoolClass->id)->get();
                foreach ($students as $student) {
                    $statusOptions = ['Belum Dikerjakan', 'Sedang Dikerjakan', 'Sudah Dikumpulkan', 'Sudah Dinilai'];
                    $status = $faker->randomElement($statusOptions);
                    
                    \App\Models\AssignmentSubmission::create([
                        'assignment_id' => $assignment->id,
                        'student_id' => $student->id,
                        'content' => in_array($status, ['Sudah Dikumpulkan', 'Sudah Dinilai']) ? $faker->paragraph() : null,
                        'status' => $status,
                        'grade' => $status === 'Sudah Dinilai' ? rand(60, 100) : null,
                        'feedback' => $status === 'Sudah Dinilai' ? $faker->sentence() : null,
                    ]);
                }
            }
        }
    }
}
