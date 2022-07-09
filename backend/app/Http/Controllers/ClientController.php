<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{

    /**
     * destroy
     * @param int $id
     * @return Illuminate\Http\JsonResponse
     */
    public function destroy(int $id){
        if($id===1) return $this->sendResponse(null, 'No se puede eliminar', 401);
        $model = Client::find($id);
        return $model && $model->delete()
            ? $this->sendResponse()
            : $this->sendResponse(null, 'No se encontro', 400);
    }

    /**
     * index
     * @return Illuminate\Http\JsonResponse
     */
    public function index(){
        return $this->sendResponse(Client::all());
    }
    /**
     * show
     * @param int $id
     * @return Illuminate\Http\JsonResponse
     */
    public function show(int $id){
        $model = Client::find($id);
        return $model ? $this->sendResponse($model): $this->sendResponse(null, 'No se encontro', 400);
    }
    /**
     * store
     * @param Request request
     * @return Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=> ['required', 'string'],
            'description'=> ['nullable', 'string']
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toArray(), 400, [], JSON_NUMERIC_CHECK);
        }
        $validator = $validator->validate();
        $model = new Client($validator);
        return $model->save()
            ? $this->sendResponse($model)
            : $this->sendResponse(null, 'No se pudo guardar', 502);
    }
    /**
     * update
     * @param int $id
     * @param Request request
     * @return Illuminate\Http\JsonResponse
     */
    public function update(int $id, Request $request){
        $validator = Validator::make($request->all(), [
            'name'=> ['required', 'string'],
            'description'=> ['nullable', 'string']
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toArray(), 400, [], JSON_NUMERIC_CHECK);
        }
        if($id===1) return $this->sendResponse(null, 'No se puede editar', 401);
        $validator = $validator->validate();
        $model = Client::find($id);
        return $model && $model->update($validator)
            ? $this->sendResponse($model)
            : $this->sendResponse(null, 'No se pudo guardar', 502);
    }
}
