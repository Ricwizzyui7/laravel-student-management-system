<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    public function __construct(private array $filters = [])
    {
    }

    public function collection()
    {
        return Student::with('course')
            ->when($this->filters['search'] ?? null, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('fullname', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($this->filters['course_id'] ?? null, fn ($q, $id) => $q->where('course_id', $id))
            ->when($this->filters['gender'] ?? null, fn ($q, $g) => $q->where('gender', $g))
            ->orderBy('fullname')
            ->get();
    }

    public function headings(): array
    {
        return ['#', 'Full Name', 'Course', 'Department', 'Gender', 'Email', 'Phone', 'Enrolled'];
    }

    public function map($student): array
    {
        static $i = 0;
        $i++;

        return [
            $i,
            $student->fullname,
            $student->course ?? '—',
            $student->department_name ?? '—',
            ucfirst($student->gender),
            $student->email ?? '—',
            $student->phone ?? '—',
            optional($student->created_at)->format('Y-m-d') ?? '—',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                  'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '1D4ED8']]],
        ];
    }

    public function title(): string
    {
        return 'Students';
    }
}
