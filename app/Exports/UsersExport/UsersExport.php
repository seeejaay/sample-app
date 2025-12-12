<?php

namespace App\Exports\UsersExport;

use App\Models\User;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class UsersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }
    public function collection()
    {
        return User::all();
    }

    /**
     * @var User $user
     */
    public function map($user): array
    {
        return [
            $user->id,
            $user->firstname,
            $user->middlename,
            $user->lastname,
            $user->email,
            $user->role->name,
            $user->position->name,
            $user->schedules->pluck('shift_name')->join(', '),
            $user->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'First Name',
            'Middle Name',
            'Last Name',
            'Email',
            'Role',
            'Position',
            'Schedules',
            'Created At',
        ];
    }

   public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Make row 1 (headings) bold
        ];
    }
}