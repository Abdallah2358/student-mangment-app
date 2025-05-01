<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use App\Filament\Resources\TeacherResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTeacher extends EditRecord
{
    protected static string $resource = TeacherResource::class;
    // in TeacherResource\Pages\EditTeacher.php or CreateTeacher.php

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $user = $this->record->user;
        $user->update([
            'name' => $data['user']['name'],
            'email' => $data['user']['email'],
            'phone' => $data['user']['phone'],
            'address' => $data['user']['address'],
            'password' => ($data['user']['password'] ?? null) ? bcrypt($data['user']['password']) : $user->password,
        ]);

        // Optional: remove user fields before saving teacher
        unset($data['user']);
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
