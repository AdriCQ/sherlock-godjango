<?php

namespace App\Http\Controllers;

use App\Models\AgentGroup;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use TCG\Voyager\Models\Role;

class ClientController extends Controller
{

    /**
     * destroy
     * @param int $id
     * @return Illuminate\Http\JsonResponse
     */
    public function destroy(int $id){
        if($id===1) return $this->sendResponse(null, 'No se puede eliminar', 401);
        $client = Client::find($id);
        if($client){
            if($client->events()->count() && !$client->events()->delete())
                return $this->sendResponse($client->events, 'Error eliminando eventos', 502);
            if($client->assignments()->count() && !$client->assignments()->delete())
                return $this->sendResponse($client->assignments, 'Error eliminando Asignaciones', 502);
            if($client->agentGroups()->count() && !$client->agentGroups()->delete())
                return $this->sendResponse($client->agentGroups, 'Error eliminando Grupo de agentes', 502);
            if($client->users()->count() && !$client->users()->delete())
                return $this->sendResponse($client->users, 'Error eliminando Usuarios', 502);
            if(!$client->delete())
                return $this->sendResponse($client, 'Error eliminando Cliente', 502);
            return $this->sendResponse();
        }
        return $this->sendResponse(null, 'No se encontro el cliente', 400);
    }

    /**
     * index
     * @return Illuminate\Http\JsonResponse
     */
    public function index(){
        return $this->sendResponse(Client::query()->with('users')->orderBy('id')->get());
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
            'description'=> ['nullable', 'string'],
            'user' => ['required', 'array'],
            'user.name' => ['required', 'string'],
            'user.email' => ['required', 'email'],
            'user.phone' => ['nullable', 'string'],
            'user.password' => ['required', 'string', 'confirmed'],
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toArray(), 400, [], JSON_NUMERIC_CHECK);
        }
        $validator = $validator->validate();
        if(User::query()->where('email', $validator['user']['email'])->first())
            return $this->sendResponse(null, 'Ya existe el usuario', 400);
        $model = new Client($validator);
        if($model->save()){
            $agentGroup = new AgentGroup([
                'client_id'=>$model->id,
                'name'=>'Default',
                'description'=> $model->name.' default'
            ]);
            $agentGroup->save();

            $validator['user']['password'] = bcrypt($validator['user']['password']);
            $validator['user']['role_id'] = Role::query()->where('name', 'manager')->first()->id;
            $validator['user']['client_id'] = $model->id;
            $user = new User($validator['user']);
            return $user->save()
                ? $this->sendResponse($model)
                : $this->sendResponse(null, 'No se pudo guardar', 502);
        } else
            $this->sendResponse(null, 'No se pudo guardar', 502);
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
        if($id===1) return $this->sendResponse(null, 'No se puede editar', 400);
        $validator = $validator->validate();
        $model = Client::find($id);
        return $model && $model->update($validator)
            ? $this->sendResponse($model)
            : $this->sendResponse(null, 'No se pudo guardar', 502);
    }
}
