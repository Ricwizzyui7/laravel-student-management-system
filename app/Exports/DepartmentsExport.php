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

class DepartmentsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    public function collection()
    {
        $courses = Course::withCount('students')->get();

        return $courses->groupBy(fn ($c) => $c->department ?: 'Unassigned')
            ->map(fn ($items, $dept) => (object) [
                'department'   => $dept,
                'courseCount'  => $items->count(),
                'studentCount' => $items->sum('students_count'),
            ])
            ->sortKeys()
            ->values();
    }

    public function headings(): array
    {
        return ['#', 'Department', 'Courses', 'Students Enrolled'];
    }

    public function map($row): array
    {
        static $i = 0;
        $i++;

        return [
            $i,
            $row->department,
            $row->courseCount,
            $row->studentCount,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                  'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '059669']]],
        ];
    }

    public function title(): string
    {
        return 'Departments';
    }
}
