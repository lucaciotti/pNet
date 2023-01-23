<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Validation\Validator;
use Carbon\Carbon;

use App\Models\parideModels\Docs\wDocNotes;

class NoteDocForm extends Component
{   
    public $id_note;
    public $tipo_doc;
    public $start_date;
    public $end_date;
    public $note;
    
    public $readyToLoad = false;

    protected $rules = [
        // 'sku_code' => 'required|unique:pNet_DATA.w_sku_custom',
        'tipo_doc' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
        'note' => 'required',
    ];

    protected $messages = [
        'start_date.required' => 'E\' obbligatorio inserire una data di inizio validità!',
        'end_date.required' => 'E\' obbligatorio inserire una data di fine validità!',
        'note.required' => 'E\' obbligatorio inserire le Note Personalizzate!',
    ];

    protected $validationAttributes = [
        'start_date' => 'Data Inizio Validità',
        'end_date' => 'Data Fine Validità',
        'tipo_doc' => 'Tipologia Documento',
        'note' => 'Note Personalizzate',
    ];

    public function mount($idNote)
    {
        $this->id_note == $idNote;
    }

    public function render()
    {
        return view('livewire.note-doc-form');
    }

    public function readyToLoad() {
        if($this->id_note!=0 && $this->readyToLoad==false){
            $note = wDocNotes::find($this->id_note);
            $this->tipo_doc=$note->tipo_doc;
            $this->start_date=$note->start_date;
            $this->end_date=$note->end_date;
            $this->note=$note->note;
        }
        $this->readyToLoad=true;
    }

    public function updatedStartDate(){
        $this->start_date = Carbon::parse($this->start_date)->timezone('Europe/Rome');
        if(!empty($this->end_date)){
            if($this->end_date<=$this->start_date){
                $this->addError('end_date', 'La Data di fine validità non può essere antecedente alla Data di Inizio Validità');
            }
        }
        // dd($this->start_date);
    }

    public function updatedEndDate(){
        $this->end_date = Carbon::parse($this->end_date)->timezone('Europe/Rome');
        if(!empty($this->start_date)){
            if($this->end_date<=$this->start_date){
                $this->addError('end_date', 'La Data di fine validità non può essere antecedente alla Data di Inizio Validità');
            }
        }
    }

    // public function updated($propertyName)
    // {
    //     $this->validateOnly($propertyName);
    // }

    public function submit()
    {
        $validatedData = $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                if(!empty($this->end_date)){
                    if($this->end_date<=$this->start_date){
                        $validator->errors()->add('end_date', 'La Data di fine validità non può essere antecedente alla Data di Inizio Validità');
                    }
                }
                // dd($this->start_date);
                try {
                    $e_notes=wDocNotes::where('tipo_doc', $this->tipo_doc)
                        ->where('end_date', '>=', $this->start_date)
                        ->where('start_date', '<=', $this->end_date)->get();

                    if($e_notes->count()>0){
                        $validator->errors()->add('note', 'Esiste già una Nota Personalizzata valida nel periodo selezionato ('.$e_notes->first()->start_date->format('d/m/Y').' - '.$e_notes->first()->end_date->format('d/m/Y').')!');
                    }
                } catch (\Throwable $th) {
                    $validator->errors()->add('start_date', 'Errore di riconoscimento data!');
                }
            });
        })->validate();
        
        // dd($validatedData);
        if($this->id_note==0){
        $this->dispatchBrowserEvent('closeModalDocNoteForm_0');
            $note=wDocNotes::create($validatedData);
        } else {
        $this->dispatchBrowserEvent('closeModalDocNoteForm_'+$this->id_note);
            $note=wDocNotes::where('id', $this->id_note)->update($validatedData);
        }
        $this->emit('closedModalDocNoteForm');
    }
}
