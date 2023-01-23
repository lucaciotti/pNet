<?php

namespace App\Models\parideModels\Docs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wDocNotes extends Model
{
    use HasFactory;
    protected $table = 'w_doc_notes';
    protected $connection = 'pNet_DATA';

    protected $fillable = ['tipo_doc', 'note', 'start_date', 'end_date'];
    
    protected $dates = ['start_date', 'end_date'];


    public function getTipologiaAttribute()
    {
        switch ($this->attributes['tipo_doc']) {
            case 'XC':
                return 'Preventivo';
                break;
            case 'OC':
                return 'Ordine';
                break;
            case 'BO':
                return 'DDT';
                break;
            case 'FT':
                return 'Fattura Accompagnatoria';
                break;
            case 'FD':
                return 'Fattura Differita';
                break;
            case 'FP':
                return 'Fattura Proforma';
                break;
            case 'NC':
                return 'Nota di Credito';
                break;
                
            default:
                return '';
        }
        
    }
}
