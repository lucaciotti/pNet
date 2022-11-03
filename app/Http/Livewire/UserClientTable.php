<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;

class UserClientTable extends DataTableComponent
{
    protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Nome", "name")
                ->sortable(),
            // Column::make("Nickname", "nickname")
            //     ->sortable(),
            Column::make("Email", "email")
                ->sortable(),
            // Column::make("Ditta", "ditta")
            //     ->sortable(),
            Column::make("Cod. Agente", "codag")
                ->sortable(),
            Column::make("Cod. Cliente", "codcli")
                ->sortable(),
            // Column::make("Codfor", "codfor")
            //     ->sortable(),
            // Column::make("Avatar", "avatar")
            //     ->sortable(),
            // Column::make("Lang", "lang")
            //     ->sortable(),
            // Column::make("Invitato email", "invitato_email")
            //     ->sortable(),
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
        ];
    }
}
