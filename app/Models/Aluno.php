<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $fillable = ['nome','endereco','bairro','cidade',
        'celular','email'];

    public function rules($id = '')
    {
    	return [
            'email'        => "required|min:3|max:100|unique:alunos,email,{$id},id",
    	];
    }

    public function rulesSearch()
    {
    	return [
    		'key-search' => 'required',
    	]; 
    }

    public function search($data,$totalPage)
    {
    	return $this->where('nome',$data['key-search'])->orWhere('email','LIKE',"%{$data['key-search']}%")->paginate($totalPage);
    }
}
