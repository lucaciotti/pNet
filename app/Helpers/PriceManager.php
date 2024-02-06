<?php
namespace App\Helpers;

use App\Models\parideModels\Client;
use App\Models\parideModels\MatricePrezzi;
use App\Models\parideModels\Product;
use App\Models\parideModels\wPriceManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class PriceManager
{

    public static function getPrice($id_cli_for, $id_art, $qta, $date=null){
        if($id_art==0){
            return 0;
        }
        $price = -1;
        $client = Client::find($id_cli_for);
        $art = Product::find($id_art);
        if($date==null){
            $date=Carbon::now();
        }
        $id_tipo_cl = $client->id_tipo_cli;
        $id_fam = $art->id_fam;
        $id_mar = $art->id_mar;
        $dfl_listino_cli = 1;
        $dfl_listino_prd = 1;
        $dfl_sconto = 0;

        #Check 0 - MatricePrezzi
        $matricePrezzi = MatricePrezzi::where('da_data', '<=', $date)->where('a_data', '>=', $date)
            ->where(function ($query) use ($id_tipo_cl, $id_cli_for) {
                $query->where('id_cli_for', $id_cli_for);
                $query->orWhere('id_tipo_cl', $id_tipo_cl);
            })
            ->where(function ($query) use ($id_art, $id_fam, $id_mar) {
                $query->where('id_art', $id_art);
                $query->orWhere('id_fam', $id_fam);
                if(!empty($id_mar)) {
                    $query->orWhere('id_mar', $id_mar);
                }
            })
            ->orderBy('id_lis', 'DESC')->get();
        if (count($matricePrezzi) > 0) {
            $dfl_listino_cli = $matricePrezzi->first()->id_lis;
            $dfl_sconto = $matricePrezzi->first()->sconto;
        } else {
            #Check 1 - PriceManager
            $priceRule = wPriceManager::where('id_fam', $id_fam)
                ->where('start_date', '<=', $date)->where('end_date', '>=', $date)
                ->where(function ($query) use ($id_tipo_cl, $id_cli_for) {
                    $query->where('id_cli_for', $id_cli_for);
                    $query->orWhere('id_tipo_cl', $id_tipo_cl);
                })
                ->orderBy('listino', 'DESC')->get();
            if (count($priceRule) > 0) {
                $dfl_listino_cli = $priceRule->first()->listino;
                $dfl_sconto = $priceRule->first()->extrasconto;
            }
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
                $price = $art->prezzo_1;
                break;
            case 2:
                $price = $art->prezzo_2;
                if($price==0) $price = $art->prezzo_1;
                break;
            case 3:
                $price = $art->prezzo_3;
                if ($price == 0) $price = $art->prezzo_2;
                if ($price == 0) $price = $art->prezzo_1;
                break;
            case 4:
                $price = $art->prezzo_4;
                if ($price == 0) $price = $art->prezzo_3;
                if ($price == 0) $price = $art->prezzo_2;
                if ($price == 0) $price = $art->prezzo_1;
                break;
            default:
                break;
        }
        $price = $price  * (1 - ($dfl_sconto / 100));

        return $price;
    }

    public static function getInfo($id_cli_for, $id_art, $qta, $date = null)
    {
        if ($id_art == 0) {
            return 0;
        }
        $price = -1;
        $client = Client::find($id_cli_for);
        $art = Product::find($id_art);
        if ($date == null) {
            $date = Carbon::now();
        }
        $id_tipo_cl = $client->id_tipo_cli;
        $id_fam = $art->id_fam;
        $id_mar = $art->id_mar;
        $dfl_listino_cli = 1;
        $dfl_listino_prd = 1;
        $dfl_sconto = 0;

        #Check 0 - MatricePrezzi
        $matricePrezzi = MatricePrezzi::where('da_data', '<=', $date)->where('a_data', '>=', $date)
        ->where(function ($query) use ($id_tipo_cl, $id_cli_for) {
            $query->where('id_cli_for', $id_cli_for);
            $query->orWhere('id_tipo_cl', $id_tipo_cl);
        })
            ->where(function ($query) use ($id_art, $id_fam, $id_mar) {
                $query->where('id_art', $id_art);
                $query->orWhere('id_fam', $id_fam);
                if (!empty($id_mar)) {
                    $query->orWhere('id_mar', $id_mar);
                }
            })
            ->orderBy('id_lis', 'DESC')->get();
        if (count($matricePrezzi) > 0) {
            $dfl_listino_cli = $matricePrezzi->first()->id_lis;
            $dfl_sconto = $matricePrezzi->first()->sconto;
        } else {
            #Check 1 - PriceManager
            $priceRule = wPriceManager::where('id_fam', $id_fam)
                ->where('start_date', '<=', $date)->where('end_date', '>=', $date)
                ->where(function ($query) use ($id_tipo_cl, $id_cli_for) {
                    $query->where('id_cli_for', $id_cli_for);
                    $query->orWhere('id_tipo_cl', $id_tipo_cl);
                })
                ->orderBy('listino', 'DESC')->get();
            if (count($priceRule) > 0) {
                $dfl_listino_cli = $priceRule->first()->listino;
                $dfl_sconto = $priceRule->first()->extrasconto;
            }
        }
        #Check2 - qtaConf
        $qta_conf = $art->pz_x_conf;
        if (empty($qta_conf)) {
            $dfl_listino_prd = 1;
        } else {
            if ($qta < $qta_conf / 2) {
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
                $price = $art->prezzo_1;
                break;
            case 2:
                $price = $art->prezzo_2;
                if ($price == 0) {
                    $price = $art->prezzo_1;
                    $listino = 1;
                }
                break;
            case 3:
                $price = $art->prezzo_3;
                if ($price == 0) {
                    $price = $art->prezzo_2;
                    $listino = 2;
                }
                if ($price == 0) {
                    $price = $art->prezzo_1;
                    $listino = 1;
                }
                break;
            case 4:
                $price = $art->prezzo_4;
                if ($price == 0) {
                    $price = $art->prezzo_3;
                    $listino = 3;
                }
                if ($price == 0) {
                    $price = $art->prezzo_2;
                    $listino = 2;
                }
                if ($price == 0) {
                    $price = $art->prezzo_1;
                    $listino = 1;
                }
                break;
            default:
                break;
        }
        $list_price = $price;
        $price = $price  * (1 - ($dfl_sconto / 100));
        
        $data = [
            'id_cli_for' => $id_cli_for,
            'id_art' => $id_art,
            'id_fam' => $id_fam,
            'id_tipo_cl' => $id_tipo_cl,
            'qta_conf' => $qta_conf,
            'qta' => $qta,
            'price' => $price,
            'listino' => $listino,
            'list_price' => $list_price,
            'extrasconto' => $dfl_sconto,
            ];

        return $data;
    }

}