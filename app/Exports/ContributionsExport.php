<?php

namespace App\Exports;

use App\Models\Contribution;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ContributionsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Contribution::with('member')->latest()->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Member Name',
            'Member ID',
            'Amount (KES)',
            'Type',
            'Payment Method',
            'Status',
            'Reference',
            'Date',
        ];
    }

    public function map($contribution): array
    {
        return [
            $contribution->id,
            $contribution->member->full_name ?? 'N/A',
            $contribution->member->member_number ?? 'N/A',
            number_format($contribution->amount, 2),
            ucfirst($contribution->contribution_type),
            ucfirst($contribution->payment_method),
            ucfirst($contribution->status),
            $contribution->reference_number,
            $contribution->payment_date->format('Y-m-d'),
        ];
    }
}
