<?php

namespace App\Filament\Resources\InstructionResource\Pages;

use App\Filament\Resources\InstructionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateInstruction extends CreateRecord
{
    protected static string $resource = InstructionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        unset($data['modification_ids']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->modifications()->sync($this->form->getRawState()['modification_ids'] ?? []);
    }
}
