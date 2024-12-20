<?php

namespace App\dao;

use App\Models\Frais;
use Illuminate\Database\QueryException;
use App\Exceptions\MonException;
use Illuminate\Support\Facades\DB;

class ServiceFrais
{
    public function getParId($idfrais)
    {
        try {
            $frais=DB::table('frais')
                ->select ('id_frais', 'anneemois','id_visiteur','nbjustificatifs',
                    'datemodification', 'montantvalide','frais.id_etat','lib_etat')
                ->join ('etat','etat.id_etat','=','frais.id_etat')
                ->where ('id_frais',$idfrais)
                ->first();
            return $frais;
        }catch (QueryException $e){
            throw new MonException($e->getMessage(),5);
        }
    }

    public function getbyID($id)
    {
        try {
            $frais=Frais::find($id);

            return $frais;
        }catch (QueryException $e){
            throw new MonException($e->getMessage(),5);
        }
    }


    public function saveFrais(Frais $frais){
        try{
            $frais->save();
        }catch (QueryException $e){
            $erreur=$e->getMessage();
            throw new MonException($erreur,5);
        }
    }



    public function delFrais($id)
    {
        try{
            Frais::destroy($id);
        }catch (QueryException $e) {
            throw new MonException($e->getMessage(), 5);
        }
    }













}
