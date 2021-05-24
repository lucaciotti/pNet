<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $nickname NickName Unique for Login
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $codag Codice Agente Associato
 * @property string|null $codcli Codice Cliente Associato
 * @property string|null $codfor Codice Fornitore Associato
 * @property string $ditta Ditta visibile all'utente
 * @property string $avatar Profile's Image
 * @property string $lang Language per User: it, en, es
 * @property bool|null $isActive User is Active?
 * @property-read mixed $role_name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User orWherePermissionIs($permission = '')
 * @method static \Illuminate\Database\Eloquent\Builder|User orWhereRoleIs($role = '', $team = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCodag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCodcli($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCodfor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDitta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDoesntHavePermission()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDoesntHaveRole()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePermissionIs($permission = '', $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleIs($role = '', $team = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Soved\Laravel\Gdpr\Contracts\Portable {}
}

namespace App\Models\parideModels\Docs{
/**
 * App\Models\parideModels\Docs\QuoteCli
 *
 * @property int $id_ord_tes
 * @property string $num
 * @property string $rif_num
 * @property \Illuminate\Support\Carbon|null $data
 * @property \Illuminate\Support\Carbon|null $data_eva
 * @property string $id_cli_for
 * @property bool $id_dest
 * @property string $id_cf_dest
 * @property bool $esente_iva
 * @property string $id_pag
 * @property string $id_ban
 * @property string $note
 * @property string $stato
 * @property bool $stampato
 * @property string $note2
 * @property string $id_tra
 * @property bool $id_por
 * @property bool $id_cor
 * @property string $tipo
 * @property string $tot_imp
 * @property string $tot_iva
 * @property string $nome1
 * @property string $nome2
 * @property string $nome3
 * @property string $nome4
 * @property bool $listino
 * @property bool $ord_elaborato
 * @property bool $id_mag
 * @property bool $scorp_iva
 * @property string $sconto
 * @property bool $arrotond
 * @property string $id_age
 * @property bool $lingua
 * @property string $id_iva_c
 * @property int $colli
 * @property-read mixed $descr_tipodoc
 * @property-read mixed $id_doc
 * @property-read mixed $tipo_doc
 * @property-read mixed $tipomodulo
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\parideModels\Docs\RowOrd[] $rows
 * @property-read int|null $rows_count
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereArrotond($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereColli($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereDataEva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereEsenteIva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereIdAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereIdBan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereIdCfDest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereIdCliFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereIdCor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereIdDest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereIdIvaC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereIdMag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereIdOrdTes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereIdPag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereIdPor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereIdTra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereLingua($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereListino($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereNome1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereNome2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereNome3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereNome4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereNote2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereOrdElaborato($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereRifNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereSconto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereScorpIva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereStampato($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereStato($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereTotImp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuoteCli whereTotIva($value)
 */
	class QuoteCli extends \Eloquent {}
}

namespace App\Models\parideModels\Docs{
/**
 * App\Models\parideModels\Docs\RowDoc
 *
 * @property int $id_doc_rig
 * @property int $id_doc_tes
 * @property int $id_mov
 * @property int $id_art
 * @property string $descr
 * @property string $qta
 * @property string $prezzo
 * @property string $sc1
 * @property string $sc2
 * @property string $iva
 * @property string $um
 * @property bool $tipo_off
 * @property bool $dist_base
 * @property bool $omaggio
 * @property bool $elaborato
 * @property string|null $data_reg
 * @property string $val_riga
 * @property string $id_iva
 * @property string $libero
 * @property bool $listino
 * @property bool $omaggiot
 * @property string $descr2
 * @property string $lottof
 * @property string $rifamm
 * @property string $tot_ivar
 * @property string $ddt_num
 * @property \Illuminate\Support\Carbon|null $ddt_data
 * @property-read mixed $qtares
 * @property-read mixed $qtarow
 * @property-read \App\Models\parideModels\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc query()
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc whereDataReg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc whereDdtData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc whereDdtNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc whereDescr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc whereDescr2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc whereDistBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc whereElaborato($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc whereIdArt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc whereIdDocRig($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc whereIdDocTes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc whereIdIva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc whereIdMov($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc whereIva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc whereLibero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc whereListino($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc whereLottof($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc whereOmaggio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc whereOmaggiot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc wherePrezzo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc whereQta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc whereRifamm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc whereSc1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc whereSc2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc whereTipoOff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc whereTotIvar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc whereUm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowDoc whereValRiga($value)
 */
	class RowDoc extends \Eloquent {}
}

namespace App\Models\parideModels\Docs{
/**
 * App\Models\parideModels\Docs\RowOrd
 *
 * @property int $id_ord_tes
 * @property int $id_ord_rig
 * @property int $id_art
 * @property \Illuminate\Support\Carbon|null $data_eva
 * @property string $descr
 * @property string $id_iva
 * @property string $qta_ord
 * @property string $qta_eva
 * @property string $prezzo
 * @property string $sc1
 * @property string $sc2
 * @property string $sc3
 * @property string $sc4
 * @property bool $omaggio
 * @property string $um
 * @property string $id_cod_for
 * @property string $iva
 * @property string $val_riga
 * @property string $prezzo_lis
 * @property string $id_cod_b
 * @property int $cartoni
 * @property string $libero
 * @property string $prz_a2v
 * @property bool $omaggiot
 * @property string $descr2
 * @property-read mixed $qtares
 * @property-read mixed $qtarow
 * @property-read \App\Models\parideModels\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd query()
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd whereCartoni($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd whereDataEva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd whereDescr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd whereDescr2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd whereIdArt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd whereIdCodB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd whereIdCodFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd whereIdIva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd whereIdOrdRig($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd whereIdOrdTes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd whereIva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd whereLibero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd whereOmaggio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd whereOmaggiot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd wherePrezzo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd wherePrezzoLis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd wherePrzA2v($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd whereQtaEva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd whereQtaOrd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd whereSc1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd whereSc2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd whereSc3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd whereSc4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd whereUm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RowOrd whereValRiga($value)
 */
	class RowOrd extends \Eloquent {}
}

namespace App\Models\parideModels{
/**
 * App\Models\parideModels\GrpProd
 *
 * @property string $id_fam
 * @property string $descr
 * @method static \Illuminate\Database\Eloquent\Builder|GrpProd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GrpProd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GrpProd query()
 * @method static \Illuminate\Database\Eloquent\Builder|GrpProd whereDescr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GrpProd whereIdFam($value)
 */
	class GrpProd extends \Eloquent {}
}

namespace App\Models\parideModels{
/**
 * App\Models\parideModels\MagGiac
 *
 * @property int $id_mag
 * @property int $id_art
 * @property float|null $scorta_min
 * @property float|null $lotto_rio
 * @property float|null $qta_ini
 * @property float|null $qta_acq
 * @property float|null $qta_ven
 * @property float|null $qta_fine
 * @property float|null $esistenza
 * @property float|null $esi_fine_a
 * @method static \Illuminate\Database\Eloquent\Builder|MagGiac newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MagGiac newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MagGiac query()
 * @method static \Illuminate\Database\Eloquent\Builder|MagGiac whereEsiFineA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagGiac whereEsistenza($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagGiac whereIdArt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagGiac whereIdMag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagGiac whereLottoRio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagGiac whereQtaAcq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagGiac whereQtaFine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagGiac whereQtaIni($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagGiac whereQtaVen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MagGiac whereScortaMin($value)
 */
	class MagGiac extends \Eloquent {}
}

namespace App\Models\parideModels{
/**
 * App\Models\parideModels\Product
 *
 * @property int $id_art
 * @property string $descr
 * @property string $descr_pos
 * @property string $id_tipo
 * @property string $id_fam
 * @property string $id_sta
 * @property string $id_iva
 * @property string $prezzo_a_l
 * @property string $sc1
 * @property string $sc2
 * @property string $sc3
 * @property string $sc4
 * @property string $prezzo_a
 * @property string $ric_1
 * @property string $prezzo_1
 * @property string $ric_2
 * @property string $prezzo_2
 * @property string $ric_3
 * @property string $prezzo_3
 * @property string $ric_4
 * @property string $prezzo_4
 * @property string $um
 * @property int $pz_x_conf
 * @property string $peso_vol
 * @property bool $id_etichet
 * @property string $id_cod_bar
 * @property string $id_cod_for
 * @property string $id_cli_for
 * @property bool $prz_bloc
 * @property bool $t_o
 * @property \Illuminate\Support\Carbon|null $data_reg
 * @property bool $non_attivo
 * @property string $id_cat
 * @property string $loc_art
 * @property bool $marg_fisso
 * @property string $stato_art
 * @property bool $kit
 * @property string $note2
 * @property string $provv_art
 * @property string $descr2
 * @property string $nome_foto
 * @property string $desc_ecom
 * @property string $prz_ecom
 * @property string $nome_foto2
 * @property string $nome_foto3
 * @property string $nome_foto4
 * @property string $nome_foto5
 * @property string $file_tecn
 * @property string $file_sicu
 * @property string $qr_code
 * @property string $note3
 * @property int $uid
 * @property bool $aggiorna
 * @property string $titolo
 * @property int $collegato
 * @property int $min_acq
 * @property string $peso
 * @property int $lunghezza
 * @property int $larghezza
 * @property int $altezza
 * @property bool $spe_gratis
 * @property string $tag
 * @property string $glassa
 * @property string $prezzo_5
 * @property string $ric_5
 * @property string $prezzo_6
 * @property string $ric_6
 * @property-read mixed $master_grup
 * @property-read \App\Models\parideModels\SubGrpProd|null $grpProd
 * @property-read \App\Models\parideModels\MagGiac|null $magGiac
 * @property-read \App\Models\parideModels\GrpProd|null $masterGrpProd
 * @property-read \App\Models\parideModels\Supplier|null $supplier
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereAggiorna($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereAltezza($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCollegato($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDataReg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescEcom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescr2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescrPos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereFileSicu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereFileTecn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereGlassa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIdArt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIdCat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIdCliFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIdCodBar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIdCodFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIdEtichet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIdFam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIdIva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIdSta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIdTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereKit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereLarghezza($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereLocArt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereLunghezza($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMargFisso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMinAcq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereNomeFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereNomeFoto2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereNomeFoto3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereNomeFoto4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereNomeFoto5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereNonAttivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereNote2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereNote3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePeso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePesoVol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrezzo1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrezzo2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrezzo3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrezzo4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrezzo5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrezzo6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrezzoA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrezzoAL($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProvvArt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrzBloc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrzEcom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePzXConf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereQrCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereRic1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereRic2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereRic3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereRic4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereRic5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereRic6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSc1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSc2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSc3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSc4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSpeGratis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStatoArt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTitolo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUm($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models\parideModels{
/**
 * App\Models\parideModels\SubGrpProd
 *
 * @property string $id_fam
 * @property string $descr
 * @method static \Illuminate\Database\Eloquent\Builder|SubGrpProd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubGrpProd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubGrpProd query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubGrpProd whereDescr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubGrpProd whereIdFam($value)
 */
	class SubGrpProd extends \Eloquent {}
}

namespace App\Models\parideModels{
/**
 * App\Models\parideModels\Supplier
 *
 * @property string $id_cli_for
 * @property string $id_cod_bar
 * @property string $rag_soc
 * @property string $rag_soc2
 * @property string|null $data_nasc
 * @property string $indirizzo
 * @property string $citta
 * @property string $cap
 * @property string $provincia
 * @property string $p_i
 * @property string $telefono
 * @property string $fax
 * @property int $id_lis
 * @property string $sconto
 * @property string $nota_sconto
 * @property string $id_ban
 * @property string $id_pag
 * @property string $id_fido
 * @property string $scoperto
 * @property string $fatturato
 * @property string $insoluti
 * @property string $pers_rif1
 * @property string $pers_rif2
 * @property string $note
 * @property bool $id_tipo_cli
 * @property string $sesso
 * @property int $bollini
 * @property int $bollini_evasi
 * @property string $saldo_iniz
 * @property string|null $dt_saldoi
 * @property string $dare
 * @property string $avere
 * @property string $provv_cli
 * @property string $id_zona
 * @property string $id_agente
 * @property string $id_rit
 * @property string|null $data_c
 * @property string|null $data_m
 * @property bool $spese_inc
 * @property string $fatt_prec
 * @property bool $socio
 * @property string $sc1f
 * @property string $sc2f
 * @property string $sc3f
 * @property string $sc4f
 * @property bool $esenzione
 * @property string $id_iva_c
 * @property string $telefono1
 * @property string $cell
 * @property string $e_mail
 * @property string $www
 * @property string $tipo_co
 * @property bool $lingua
 * @property string $c_f
 * @property bool $bloccato
 * @property string $note2
 * @property string|null $data_fid
 * @property bool $tstudio
 * @property bool $profes
 * @property bool $figli
 * @property bool $statoc
 * @property bool $ncomp
 * @property string|null $datafi1
 * @property string|null $datafi2
 * @property string|null $datafi3
 * @property string|null $datafi4
 * @property string|null $datafi5
 * @property bool $frequenz
 * @property bool $h_giard
 * @property bool $h_faida
 * @property bool $h_lett
 * @property bool $h_mus
 * @property bool $h_anim
 * @property bool $h_decou
 * @property bool $h_armob
 * @property bool $h_artes
 * @property bool $h_casa
 * @property string $p_num1
 * @property string $p_num2
 * @property string|null $p_datai1
 * @property string|null $p_dataf1
 * @property string|null $p_datai2
 * @property string|null $p_dataf2
 * @property string $p_emesso1
 * @property string $p_emesso2
 * @property bool $p_tipodoc
 * @property string $iban
 * @property bool $id_caud
 * @property string $mod
 * @property string $clioff
 * @property string $codufficio
 * @property string $codcliest
 * @property string $sconto1
 * @property string $soglia1
 * @property string $nome
 * @property string $cognome
 * @property string $stato
 * @property bool $consenso1
 * @property bool $consenso2
 * @property bool $split
 * @property bool $nopvddt
 * @property string $note3
 * @property bool $fat_email
 * @property string $esigib
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier query()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereAvere($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereBloccato($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereBollini($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereBolliniEvasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereCF($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereCap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereCell($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereCitta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereClioff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereCodcliest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereCodufficio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereCognome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereConsenso1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereConsenso2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereDare($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereDataC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereDataFid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereDataM($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereDataNasc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereDatafi1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereDatafi2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereDatafi3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereDatafi4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereDatafi5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereDtSaldoi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereEMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereEsenzione($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereEsigib($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereFatEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereFattPrec($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereFatturato($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereFigli($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereFrequenz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereHAnim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereHArmob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereHArtes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereHCasa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereHDecou($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereHFaida($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereHGiard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereHLett($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereHMus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereIdAgente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereIdBan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereIdCaud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereIdCliFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereIdCodBar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereIdFido($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereIdIvaC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereIdLis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereIdPag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereIdRit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereIdTipoCli($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereIdZona($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereIndirizzo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereInsoluti($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereLingua($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereMod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereNcomp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereNopvddt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereNotaSconto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereNote2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereNote3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier wherePDataf1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier wherePDataf2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier wherePDatai1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier wherePDatai2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier wherePEmesso1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier wherePEmesso2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier wherePI($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier wherePNum1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier wherePNum2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier wherePTipodoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier wherePersRif1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier wherePersRif2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereProfes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereProvincia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereProvvCli($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereRagSoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereRagSoc2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereSaldoIniz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereSc1f($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereSc2f($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereSc3f($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereSc4f($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereSconto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereSconto1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereScoperto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereSesso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereSocio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereSoglia1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereSpeseInc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereSplit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereStato($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereStatoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereTelefono1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereTipoCo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereTstudio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereWww($value)
 */
	class Supplier extends \Eloquent {}
}

