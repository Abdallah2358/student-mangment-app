<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Enums\RolesEnum;
use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (Auth::user()->role === RolesEnum::ADMIN) {
            $data['teacher_id'] = $data['teacher_id'] ?? null;
        } else {
            $data['teacher_id'] = Auth::user()->teacher->id;
        }

        return $data;
    }
}
