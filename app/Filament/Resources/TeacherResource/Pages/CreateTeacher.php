<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use App\Enums\RolesEnum;
use App\Filament\Resources\TeacherResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTeacher extends CreateRecord
{
    protected static string $resource = TeacherResource::class;

    // app/Filament/Resources/TeacherResource/Pages/CreateTeacher.php

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $userData = $data['user'];

        // Create the user
        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'phone' => $userData['phone'] ?? null,
            'address' => $userData['address'] ?? null,
            'password' => bcrypt($userData['password'] ?? null), // Or generate/send/reset later
            'role' => RolesEnum::TEACHER,
        ]);

        // Assign user_id to the teacher data
        $data['user_id'] = $user->id;

        unset($data['user']);

        return $data;
    }
}
