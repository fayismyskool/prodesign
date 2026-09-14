<?php

namespace Database\Seeders;

use App\Models\ActivityFile;
use App\Models\Course;
use App\Models\CourseChapter;
use App\Models\CourseChapterItem;
use App\Models\CourseChapterLesson;
use App\Models\CourseGrade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Grade7CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = __DIR__ . '/grade7_curriculum.json';
        if (!file_exists($jsonPath)) {
            $this->command->error("Curriculum JSON file not found at: {$jsonPath}");
            return;
        }

        $projects = json_decode(file_get_contents($jsonPath), true);
        if (!$projects) {
            $this->command->error("Failed to parse JSON file at: {$jsonPath}");
            return;
        }

        DB::beginTransaction();
        try {
            // 1. Create or update CourseGrade for Grade 7
            $grade = CourseGrade::updateOrCreate(
                ['title' => 'Grade 7'],
                [
                    'description'   => 'Vocational Education & Skill Labs (Kaushal Bodh) - Aligned with NEP 2020 & NCF-SE 2023',
                    'instructor_id' => 1,
                    'order'         => 7,
                    'status'        => 'active',
                ]
            );

            // 2. Create or update Course for Grade 7
            $courseDescription = <<<HTML
<p><strong>Kaushal Bodh (Grade 7)</strong> is the middle-stage Vocational Education & Skill Labs program developed under the <strong>National Curriculum Framework 2023 (NCF-SE 2023)</strong> and <strong>NEP 2020</strong>.</p>
<p>The curriculum provides experiential, hands-on exposure across three foundational Forms of Work:</p>
<ul>
    <li><strong>Work with Life Forms:</strong> Plant Nursery & School Habitat Garden — raising saplings from cuttings/seeds, shade-net management, local biodiversity habitat gardens, and pollinator corridors.</li>
    <li><strong>Work with Machines and Materials:</strong> Tie and Dye (Bandhani) & AI Assistant — mastering traditional resist dyeing textile crafts, and training machine learning vision/speech classification models.</li>
    <li><strong>Work in Human Services:</strong> Storytime with Puppets & Family Health Handbook — theatrical puppet crafting, scripting & staging, first-aid curation, age-group health audits, and wellness plans.</li>
</ul>
<p>Duration: 30 Hours (approx. 50–55 periods) with modular activity sheets, material checklists, video demonstrations, audio guides, and rubrics.</p>
HTML;

            $course = Course::updateOrCreate(
                ['slug' => 'grade-7'],
                [
                    'title'               => 'Grade 7: Vocational Education (Kaushal Bodh)',
                    'course_code'         => 'GRADE7-KAUSHALBODH',
                    'instructor_id'       => 1,
                    'category_id'         => 2,
                    'type'                => 'course',
                    'duration'            => 30,
                    'thumbnail'           => '/uploads/custom-images/grade-7-kaushal-bodh-cover.png',
                    'description'         => $courseDescription,
                    'capacity'            => null,
                    'price'               => 1000.00,
                    'discount'            => null,
                    'certificate'         => 1,
                    'downloadable'        => 1,
                    'partner_instructor'  => 0,
                    'qna'                 => 1,
                    'message_for_reviewer'=> 'Grade 7 Kaushal Bodh Vocational Education Course loaded from NCERT curriculum.',
                    'status'              => 'active',
                    'is_approved'         => 'approved',
                    'is_online'           => 0,
                ]
            );

            // Link grade to course
            $grade->update(['course_id' => $course->id]);

            // 3. Remove existing chapters and chapter items for this course to ensure clean state
            $existingChapters = CourseChapter::where('course_id', $course->id)->get();
            foreach ($existingChapters as $ch) {
                foreach ($ch->chapterItems as $item) {
                    if ($item->lesson) {
                        ActivityFile::where('lesson_id', $item->lesson->id)->delete();
                        $item->lesson->delete();
                    }
                    $item->delete();
                }
                $ch->delete();
            }

            // 4. Seed Chapters and Activities
            $totalActivities = 0;

            foreach ($projects as $projIndex => $proj) {
                $chapterOrder = $projIndex + 1;
                $chapter = CourseChapter::create([
                    'title'         => $proj['title'],
                    'description'   => $proj['description'],
                    'instructor_id' => 1,
                    'course_id'     => $course->id,
                    'grade_id'      => $grade->id,
                    'order'         => $chapterOrder,
                    'status'        => 'active',
                ]);

                foreach ($proj['activities'] as $actIndex => $act) {
                    $itemOrder = $actIndex + 1;

                    // Create Chapter Item
                    $chapterItem = CourseChapterItem::create([
                        'instructor_id' => 1,
                        'chapter_id'    => $chapter->id,
                        'type'          => 'activity',
                        'order'         => $itemOrder,
                    ]);

                    // Create Chapter Lesson (Activity Record)
                    $lesson = CourseChapterLesson::create([
                        'title'             => $act['title'],
                        'slug'              => Str::slug($act['title']),
                        'topic_category'    => $act['topic'] ?? 'General Project Work',
                        'description'       => $act['description'],
                        'material_required' => $act['material_required'],
                        'age_min'           => 12,
                        'age_max'           => 13,
                        'activity_duration' => $act['duration'],
                        'instructor_id'     => 1,
                        'course_id'         => $course->id,
                        'chapter_id'        => $chapter->id,
                        'chapter_item_id'   => $chapterItem->id,
                        'file_path'         => '/' . ltrim($act['split_pdf'] ?? 'uploads/custom-images/Kaushalbodh_7.pdf', '/'),
                        'video_url'         => $act['video'] ?? 'https://www.youtube.com/embed/gW9b2K2iP0Y',
                        'audio_path'        => '/' . ltrim($act['audio_path'] ?? '', '/'),
                        'storage'           => 'upload',
                        'file_type'         => 'pdf',
                        'downloadable'      => 1,
                        'order'             => $itemOrder,
                        'is_free'           => 1,
                        'status'            => 'active',
                    ]);

                    // Attach 1: Split Activity Worksheet PDF
                    ActivityFile::create([
                        'lesson_id'  => $lesson->id,
                        'file_path'  => '/' . ltrim($act['split_pdf'] ?? 'uploads/custom-images/Kaushalbodh_7.pdf', '/'),
                        'file_name'  => 'Activity ' . $act['number'] . ' - Worksheet & Procedure (PDF)',
                        'file_type'  => 'pdf',
                    ]);

                    // Attach 2: Project Chapter Split PDF
                    if (!empty($proj['project_pdf'])) {
                        ActivityFile::create([
                            'lesson_id'  => $lesson->id,
                            'file_path'  => '/' . ltrim($proj['project_pdf'], '/'),
                            'file_name'  => $proj['title'] . ' - Project Module (PDF)',
                            'file_type'  => 'pdf',
                        ]);
                    }

                    // Attach 3: Audio Guide File
                    if (!empty($act['audio_path'])) {
                        ActivityFile::create([
                            'lesson_id'  => $lesson->id,
                            'file_path'  => '/' . ltrim($act['audio_path'], '/'),
                            'file_name'  => 'Audio Narration & Teacher Guide (Audio)',
                            'file_type'  => 'audio',
                        ]);
                    }

                    $totalActivities++;
                }
            }

            DB::commit();

            echo "Successfully seeded Grade 7 Course!\n";
            echo "Course ID: {$course->id} | Slug: {$course->slug}\n";
            echo "Grade ID: {$grade->id} | Title: {$grade->title}\n";
            echo "Chapters created: " . count($projects) . "\n";
            echo "Activities created: {$totalActivities}\n";

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
