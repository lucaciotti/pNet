<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;

class UserTable extends DataTableComponent
{
    // protected $model = User::class;
    
    protected string $tableName = 'users';
    public array $users = [];

    public function builder(): Builder
    {
        $clients = User::with(['roles', 'client'])
            ->whereHas('roles', function ($q) {
                $q->whereIn('name', ['client']);
            })
            ->where('active', true)
            ->orderBy('id')->get();
        return $clients;
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Name", "name")
                ->sortable(),
            Column::make("Nickname", "nickname")
                ->sortable(),
            Column::make("Email", "email")
                ->sortable(),
            Column::make("Ditta", "ditta")
                ->sortable(),
            Column::make("Codag", "codag")
                ->sortable(),
            Column::make("Codcli", "codcli")
                ->sortable(),
            Column::make("Codfor", "codfor")
                ->sortable(),
            Column::make("Avatar", "avatar")
                ->sortable(),
            Column::make("Lang", "lang")
                ->sortable(),
            Column::make("Invitato email", "invitato_email")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
