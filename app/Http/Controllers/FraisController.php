<?php

namespace App\Http\Controllers;

use App\dao\ServiceFrais;
use App\Models\Frais;
use App\Models\Visiteur;

use Exception;
use Illuminate\Http\Request;

class FraisController extends Controller
{

    public function detail($idFrais)
    {
        //$a=Frais::find($idFrais);
        //return response()->json($a);
        $serviceFrais= new ServiceFrais();
        $frais=$serviceFrais->getParId($idFrais);
        return response()->json($frais);

    }

    public function ajout(Request $request)
    {
        try {
            $frais=new Frais();
            $serviceFrais=new ServiceFrais();

            $frais->anneemois=$request->json('anneemois');
            $frais->id_visiteur=$request->json('id_visiteur');
            $frais->nbjustificatifs=$request->json('nbjustificatifs');
            $frais->id_etat=2;
            $frais->datemodification=now();

        $serviceFrais->saveFrais($frais);
            return response()->json(['message'=>'Insertion réalisée','id_frais'=>$frais->id_frais]);

        }catch (Exception $e) {
            $erreur = $e->getMessage();
            return response()->json(['erreur'=>$erreur]);
        }
    }

    public function modif(Request $request)
    {
        try {
            $servicefrais=new ServiceFrais();
            $id=$request->json('id_frais');
            $frais=$servicefrais->getbyID($id);
            $frais->anneemois=$request->json('anneemois');
            $frais->id_visiteur=$request->json('id_visiteur');
            $frais->nbjustificatifs=$request->json('nbjustificatifs');
            $frais->montantvalide=$request->json('montantvalide');
            $frais->id_etat=$request->json('id_etat');

            $servicefrais->saveFrais($frais);
            return response()->json(['message'=>'Modification réalisée','id_frais'=>$id]);
        }catch(Exception $e){
            $erreur = $e->getMessage();
            return response()->json(['erreur'=>$erreur]);
        }
    }








    public function liste($idClient)
    {
        $a=Visiteur::find($idClient)->frais()->get();
        return response()->json($a);
    }
}
