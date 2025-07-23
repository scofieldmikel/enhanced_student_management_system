<?php

namespace App\Console\Commands;

use App\Models\StudentGrade;
use App\Mail\LowGradeWarning;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class GradeWarningNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grade-warning';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Warn parents of students with low grades';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $grades = StudentGrade::where('score', '<', '50')->with(['subject', 'student']);
        $bar = $this->output->createProgressBar($grades->count());
        $grades->lazy()->each(function (StudentGrade $grade) use ($bar) {
            // Check if the grade was created today
            if($grade->created_at->startOfDay() != now()->startOfDay()) {
                return;
            }
            // Check if the student has a parent and the parent has a user
            if (!$grade->student->parent || !$grade->student->parent->user) {
                $bar->advance();
                return;
            }
            // Send email notification to the parent
            Mail::to($grade->student->parent->user->email)->queue(new LowGradeWarning($grade));

            $bar->advance();
        });

        $bar->finish();
        $this->info('Grade warning notifications sent successfully.');

    }
}
