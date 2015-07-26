<?php namespace App\Http\Controllers;

use App\Capitulo;
use App\Disciplina;
use App\Tema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

session_start();

/**
 * Created by PhpStorm.
 * User: Yola
 * Date: 7/10/2015
 * Time: 8:00 AM
 */
class CapituloController extends Controller
{

    public function showCapitulo()
    {
        return view("capitulo");
    }

    public function inicializaCapitulo()
    {
        $disciplinas = Disciplina::lists('nome', 'id');
        return view('capitulo')->with(array('disciplinas' => $disciplinas));
    }

    public function createCapitulo(Request $request)
    {
        $capitulo = new Capitulo();
        $capitulo->nome = $request->input('nome');
        $disciplinas = Disciplina::find($request->input('disciplinas'));
        $capitulo = $disciplinas->capitulos()->save($capitulo);
        Session::flash('message', 'Dados gravados com sucesso');
        return Redirect('capitulo');
    }

    public function inicializaCapitulo_list()
    {
        $capitulos = Capitulo::all();
        return view('capitulo_list')->with('capitulos', $capitulos);
    }

    public function deleteCapitulo($id)
    {
        Capitulo::find($id)->delete();
        Session::flash('message', 'Dados removidos com sucesso');
        return Redirect('capitulo_list');
    }

    public function editarCapitulo($id)
    {
        $capitulo = Capitulo::find($id);
        $disciplina = Disciplina::lists('nome', 'id');
        return view('capitulo_editar')->with(array('capitulos' => $capitulo, 'disciplinas' => $disciplina));
    }

    public function editar(Request $request)
    {
        $id = $request->input('id');
        $disciplinas = Disciplina::find($request->input('disciplinas'));
        $capitulos = Capitulo::find($id);
        $capitulos->nome = $request->input('nome');
        $capitulos = $disciplinas->capitulos()->save($capitulos);
        Session::flash('message', 'Dados alterados com sucesso');
        return Redirect('capitulo_list');
    }


public function buscarCapituloDisciplina($id){

    $capitulos=Capitulo::where('disciplina_id',$id)->get();


    $capituloJson = "{\"capitulos\":[ ";

    foreach ($capitulos as $capitulo) {
        if (strlen($capituloJson) < 20) {
            $capituloJson .= "{\"nome\":\"$capitulo->nome\"," .
                "\"id\":\"$capitulo->id\"}";

        } else if(strlen($capituloJson)>20) {
            $capituloJson .= ",{\"nome\":\"$capitulo->nome\"," .
                "\"id\":\"$capitulo->id\"}";
        }


    }

    $capituloJson.=" ]}";

    return $capituloJson;

}

    //Devolve a lista de todos os capitulos e todos os temas

public function showCapituloHome($id){

    $disciplina=Disciplina::find($id);
    $_SESSION['disciplina']=$disciplina;
    return redirect('capituloHome');

}

public function showHome(){

    $disciplina=$_SESSION['disciplina'];
    return view('capituloHome')->with(array('disciplina'=>$disciplina));
}


    //Devolve objecto json com todos capitulos e temas
public  function capituloTemaJason() {

    $id_disciplina=$_SESSION['disciplina']->id;
    $capitulos=Capitulo::where('disciplina_id',$id_disciplina)->get();

    $testeJson = "{\"data\":[ ";
    $j=0;
    $nrcapitulos=$capitulos->count();

    foreach ($capitulos as $capitulo) {

        $temas=Tema::where('capitulo_id',$capitulo->id)->get();

        $tem="[";
        $i=0;
        $j++;

        $nrcapitulos--;
        foreach($temas as $tema){
            $i++;
            $tem.="\"$tema->nome\"";

            if($temas->count()-$i!==0){
                $tem.=",";
            }
        }

        $tem.="]";


        if (strlen($testeJson) < 20) {
            $testeJson .= "{\"nome\":\"$capitulo->nome\"," .
                "\"id\":\"$capitulo->id\"" .
                ",\"tema\":$tem" .
                ",\"image\":\"okcomputer.png\"" .
                ",\"url\":\"#\"";

            if($j==1){
                $testeJson .=",\"first\": true";

                if($nrcapitulos==0){

                    $testeJson .=",\"last\": true ";
                }

            }

            if($j%4==0){
                $testeJson .=",\"last\": true ";
                $j=0;
            }
            $testeJson .="}";}


        else if(strlen($testeJson)>20) {
            $testeJson .= ",{\"nome\":\"$capitulo->nome\"," .
                "\"id\":\"$capitulo->id\"" .
                ",\"tema\": $tem" .
                ",\"image\":\"kida.png\"" .
                ",\"url\":\"#\"";

            if($j==1){
                $testeJson .=",\"first\": true ";
                if($nrcapitulos==0){

                    $testeJson .=",\"last\": true ";
                }

            }

            if($j%4==0){
                $testeJson .=",\"last\": true ";
                $j=0;
            }
            else{

                if($nrcapitulos==0){
                    $testeJson .=",\"last\": true ";
                }
            }
            $testeJson .="}";
        }
    }



    $testeJson.=" ]}";



    return $testeJson;

}

}