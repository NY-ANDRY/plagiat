<x-student-layout>
    <div class="flex min-h-full">

        <div class="b-r min-h-full w-4xl">
            <h2 class="box b-b">recent submissions</h2>
            @foreach ($submissions as $submission)
                <x-submission.submission-card :submission="$submission" />
            @endforeach

            @if ($submissions->isEmpty())
                <p class="box">no submission found.</p>
            @endif
        </div>

        <div class="flex flex-col ss-v w-full">
            <h2 class="box b-b">exams</h2>
            @foreach ($exams as $exam)
                <x-exam.exam-card :exam="$exam" />
            @endforeach

            @if ($exams->isEmpty())
                <p class="box">Aucun examen disponible.</p>
            @endif
        </div>
    </div>
</x-student-layout>