<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    public function __construct(private array $filters = [])
    {
    }

    public function collection()
    {
        return Attendance::with('student')
            ->when($this->filters['month'] ?? null, fn ($q, $m) => $q->forMonth($m))
            ->when($this->filters['status'] ?? null, fn ($q, $s) => $q->where('status', $s))
            ->when($this->filters['from'] ?? null, fn ($q, $from) => $q->whereDate('date', '>=', $from))
            ->when($this->filters['to'] ?? null, fn ($q, $to) => $q->whereDate('date', '<=', $to))
            ->when($this->filters['student_id'] ?? null, fn ($q, $id) => $q->where('student_id', $id))
            ->latest('date')
            ->get();
    }

    public function headings(): array
    {
        return ['#', 'Date', 'Student', 'Course', 'Status'];
    }

    public function map($record): array
    {
        static $i = 0;
        $i++;

        return [
            $i,
            $record->date->format('Y-m-d'),
            $record->student->fullname ?? 'Unknown',
            $record->student->course ?? '—',
            ucfirst($record->status),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                  'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D97706']]],
        ];
    }

    public function title(): string
    {
        return 'Attendance';
    }
}
