<?php

namespace App\Exports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CoursesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    public function __construct(private array $filters = [])
    {
    }

    public function collection()
    {
        return Course::withCount('students')
            ->when($this->filters['search'] ?? null, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->when($this->filters['department'] ?? null, fn ($q, $d) => $q->where('department', $d))
            ->orderBy('name')
            ->get();
    }

    public function headings(): array
    {
        return ['#', 'Code', 'Course Name', 'Department', 'Duration', 'Students Enrolled'];
    }

    public function map($course): array
    {
        static $i = 0;
        $i++;

        return [
            $i,
            $course->code,
            $course->name,
            $course->department ?? '—',
            $course->duration ?? '—',
            $course->students_count,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                  'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4F46E5']]],
        ];
    }

    public function title(): string
    {
        return 'Courses';
    }
}
