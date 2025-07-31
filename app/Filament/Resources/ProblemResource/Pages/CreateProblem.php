<?php

namespace App\Filament\Resources\ProblemResource\Pages;

use App\Filament\Resources\ProblemResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProblem extends CreateRecord
{
    protected static string $resource = ProblemResource::class;

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
