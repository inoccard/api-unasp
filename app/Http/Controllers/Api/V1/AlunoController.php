<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Aluno;

class AlunoController extends Controller
{
    private $aluno;
    private $totalPage = 5;

    public function __construct(Aluno $aluno)
    {
        $this->aluno = $aluno;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alunos = $this->aluno->paginate($this->totalPage);
        return response()->json(['data' => $alunos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validate = validator($data, $this->aluno->rules());
        if ($validate->fails()):
            $messages = $validate->messages();
            return response()->json(['validate.error',$messages],422);
        endif;

        if(!$insert = $this->aluno->create($data)):
            return response()->json(['error' => 'Erro ao enviar'],500);
        endif;
        
        return response()->json(['data'=>$insert],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!$aluno = $this->aluno->find($id)):
            return response()->json(['error'=>'Aluno não encontrado'],404);
        endif;
        return response()->json(['data'=>$aluno]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validate = validator($data, $this->aluno->rules($id));

        if ($validate->fails()){
            $messages = $validate->messages();
            return response()->json(['validate.error',$messages], 422);
        }

        if(!$aluno = $this->aluno->find($id))
            return response()->json(['error'=>'Aluno não encontrado'],401);
        //Verify if data in table Aluno already was updated
        if(!$update = $aluno->update($data))
            return response()->json(['error' => 'Dados do Aluno não foram atualizado, tente novamente'], 500);
        
        return response()->json(['response' => $update]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!$aluno = $this->aluno->find($id))
            return response()->json(['error'=>'Aluno não encontrado'],404);

        if(!$delete = $aluno->delete())
            return response()->json(['error' => 'Não foi possível apagar dados do aluno, tente novamente'], 500);
        
        return response()->json(['response' => $delete]);
    }

    public function search(Request $request)
    {
        $data = $request->all();

        $validate = validator($data,$this->aluno->rulesSearch());
        if ($validate->fails()){
            $messages = $validate->messages();

            return response()->json(['validate.error',$messages],422);
        }

        $alunos = $this->aluno->search($data,$this->totalPage);

        return response()->json(['data'=>$alunos]);
    }
}
