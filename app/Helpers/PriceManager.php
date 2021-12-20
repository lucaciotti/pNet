<?php
namespace knet\Helpers;

use App\Models\parideModels\Client;
use App\Models\parideModels\PPM\Listini;
use App\Models\parideModels\Product;

class PriceManager
{
    public static function getListino($id_cli_for, $id_art, $qta, $data_rif) {
        $listinoPersonalizzato = self::getListinoPers($id_cli_for, $id_art, $data_rif);
        $listinoConf = self::getListinoConf($id_art, $qta);

        return max($listinoPersonalizzato, $listinoConf);
    }

    public static function getListinoPers($id_cli_for, $id_art, $data_rif) {
        //Prima di tutto cerco: Tipologia del Cliente + Famiglia Prodotto
        $customer = Client::select('id_tipo_cl')->find($id_cli_for);
        $articolo = Product::select('id_fam')->find($id_art);

        //REGOLA 1.a --> Listino Cliente vince su Listino TipoCliente
        $listinoCli = Listini::where('id_cli_for', $id_cli_for)
                        ->where('id_fam', $articolo->id_fam)
                        ->where('datainizio'>=$data_rif)
                        ->where('datafine'<=$data_rif)
                        ->get();

        //REGOLA 1.b --> Listino Cliente vince su Listino TipoCliente
        if(!$listinoCli){
            $listinoCli = Listini::where('id_cli_for', $id_cli_for)
                ->where('id_fam', $articolo->master_grp)
                ->where('datainizio' >= $data_rif)
                ->where('datafine' <= $data_rif)
                ->get();
        }

        //REGOLA 2.a --> Listino TipoCliente
        if (!$listinoCli) {
            $listinoCli = Listini::where('id_tipo_cl', $customer->id_tipo_cl)
            ->where('id_fam', $articolo->id_fam)
            ->where('datainizio' >= $data_rif)
            ->where('datafine' <= $data_rif)
            ->get();
        }

        //REGOLA 2.b --> Listino TipoCliente
        if (!$listinoCli) {
        $listinoCli = Listini::where('id_tipo_cl', $customer->id_tipo_cl)
        ->where('id_fam', $articolo->master_grp)
        ->where('datainizio' >= $data_rif)
        ->where('datafine' <= $data_rif)
            ->get();
        }

        return (!$listinoCli) ? 0 : $listinoCli->listino;
    }

    public static function getListinoConf($id_art, $qta) {
        //Prima di tutto analizzo lo sconto 
        $articolo = Product::select('pz_x_conf')->where('id_art', $id_art)->first();
        $listinoRif = 0;
        if($qta<=($articolo->pz_x_conf/2)){
            $listinoRif = 1;
        }
        if ($qta > ($articolo->pz_x_conf / 2) && $qta <= ($articolo->pz_x_conf)) {
            $listinoRif = 2;
        }
        if ($qta > ($articolo->pz_x_conf)) {
            $listinoRif = 3;
        }
        return $listinoRif;
    }

}