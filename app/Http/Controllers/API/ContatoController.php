<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Contato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContatoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contatos = Contato::all();

        return response()->json($contatos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:6|max:255',
            'email' => 'required|email|unique:contatos'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->json($errors, 400);
        }

        //passou pela validação
        $contato = Contato::create($request->all());

        return response()->json($contato, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contato  $contato
     * @return \Illuminate\Http\Response
     */
    public function show(Contato $contato)
    {
        return response()->json($contato);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contato  $contato
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contato $contato)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:6|max:255',
            'email' => 'required|email|unique:contatos,' . $contato->id,
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->json($errors, 400);
        }

        //pussed validation
        $contato->update($request->all());

        return response()->json($contato);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contato  $contato
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contato $contato)
    {
        $contato->delete();

        return response()->json('Contato deletado com sucesso!', 200);
    }
}
