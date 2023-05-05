<?php
namespace App\Helpers;

use App\Models\parideModels\Client;
use App\Models\parideModels\Product;
use App\Models\parideModels\wPriceManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class PriceManager
{

    public static function getPrice($id_cli_for, $id_art, $qta, $date=null){
        $client = Client::find($id_cli_for);
        $art = Product::find($id_art);
        if($date==null){
            $date=Carbon::now();
        }
        $id_tipo_cl = $client->id_tipo_cli;
        $id_fam = $art->id_fam;
        $dfl_listino_cli = 1;
        $dfl_listino_prd = 1;
        
        #Check 1 - PriceManager
        $priceRule = wPriceManager::where('id_fam', $id_fam)
            ->where('start_date', '<=', $date)->where('end_date', '>=', $date)
            ->where(function ($query) use ($id_tipo_cl, $id_cli_for) {
                $query->where('id_cli_for', $id_cli_for);
                $query->orWhere('id_tipo_cl', $id_tipo_cl);
            })
            ->orderBy('listino', 'DESC')->get();
        if(count($priceRule)>0){
            $dfl_listino_cli = $priceRule->first()->listino;
        }
        #Check2 - qtaConf
        $qta_conf = $art->pz_x_conf;
        if(empty($qta_conf)){
            $dfl_listino_prd = 1;
        } else {
            if($qta<$qta_conf/2){
                $dfl_listino_prd = 1;
            } else {
                if ($qta >= $qta_conf / 2 && $qta < $qta_conf) {
                    $dfl_listino_prd = 2;
                } else {
                    $dfl_listino_prd = 3;
                }
            }
        }

        $listino = max($dfl_listino_cli, $dfl_listino_prd);
        switch ($listino) {
            case 1:
                return $art->prezzo_1;
                break;
            case 2:
                return $art->prezzo_2;
                break;
            case 3:
                return $art->prezzo_3;
                break;
            case 4:
                return $art->prezzo_4;
                break;
            default:
                break;
        }

        return -1;
    }

}