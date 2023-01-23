<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\parideModels\Docs\wDocNotes;

class NoteDocList extends Component
{
    public $notes = [];

    protected $listeners = ['closedModalDocNoteForm' => '$refresh', 'refreshComponent' => '$refresh'];

    public function mount(){
    }

    public function render()
    {
        $this->notes = wDocNotes::all();
        return view('livewire.note-doc-list');
    }

    public function delete($id_note){
        // dd($id_cli_for);
        wDocNotes::where('id', $id_note)->delete();
        $this->emit('refreshComponent');
    }
}
