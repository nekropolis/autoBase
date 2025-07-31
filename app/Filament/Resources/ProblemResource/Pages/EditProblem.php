<?php

namespace App\Filament\Resources\ProblemResource\Pages;

use App\Filament\Resources\ProblemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProblem extends EditRecord
{
    protected static string $resource = ProblemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        unset($data['modification_ids']);

        return $data;
    }

    protected function afterSave(): void
    {
        $this->record->modifications()->sync($this->form->getRawState()['modification_ids'] ?? []);
    }
}
