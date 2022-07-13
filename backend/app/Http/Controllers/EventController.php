<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{

    /**
     * Create
     * @param Request request
     * @return Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => ['required', 'in:' . implode(',', Event::$TYPES)],
            'details' => ['required', 'string'],
            'agent_id' => ['required', 'integer'],
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        // Check Client
        $validator['client_id'] = auth()->user()->client->id;
        $validator['status'] = 'onprogress';
        $model = new Event($validator);
        return $model->save()
            ? $this->sendResponse($model, 'Evento creada', 201)
            : $this->sendResponse($model->errors, 'Error en el Evento', 502);
    }

    /**
     * Find
     * @param int $id
     * @return Illuminate\Http\JsonResponse
     */
    public function find(int $id)
    {
        return $this->sendResponse(Event::query()->where([
                ['id', $id],
                ['client_id', auth()->user()->client->id]
            ])->with('agent')->first());
    }

    /**
     * list
     * @return Illuminate\Http\JsonResponse
     */
    public function list()
    {
        return $this->sendResponse(Event::query()
            ->where(['client_id', auth()->user()->client->id])
            ->with('agent')
            ->orderBy('updated_at', 'desc')
            ->get()
        );
    }
    /**
     * MyEvents
     * @return Illuminate\Http\JsonResponse
     */
    public function mine(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => ['nullable', 'in:' . implode(',', Event::$STATUS)],
            'type' => ['nullable', 'in:' . implode(',', Event::$TYPES)],
            'created_at' => ['nullable', 'string']
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        $qry = Event::query()->where('agent_id', auth()->user()->agent->id);
        if (isset($validator['created_at'])) {
            $qry = $qry->whereDate('created_at', '>', $validator['created_at']);
            unset($validator['created_at']);
        }
        if (
            isset($validator['status']) || isset($validator['type'])
        ) {
            $qry = $qry->where($validator);
        }
        return $this->sendResponse($qry->with('agent')->orderBy('updated_at', 'desc')->take(24)->get());
    }
    /**
     * remove
     * @param int $id
     * @return Illuminate\Http\JsonResponse
     */
    public function remove(int $id)
    {
        $model = Event::find($id);
        // TODO: Check if belongs to same Client
        return $model && $model->delete()
            ? $this->sendResponse()
            : $this->sendResponse(null, 'No se pudo eliminar', 400);
    }

    /**
     * search
     * @param Request request
     * @return Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => ['nullable', 'in:' . implode(',', Event::$STATUS)],
            'type' => ['nullable', 'in:' . implode(',', Event::$TYPES)],
            'created_at' => ['nullable', 'string']
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        $qry = Event::query()->where('client_id', auth()->user()->client->id);
        if (isset($validator['created_at'])) {
            $qry = $qry->whereDate('created_at', '>', $validator['created_at']);
            unset($validator['created_at']);
        }
        if (
            isset($validator['status']) || isset($validator['type'])
        ) {
            $qry = $qry->where($validator);
        }
        return $this->sendResponse($qry->with('agent')->orderBy('updated_at', 'desc')->take(24)->get());
    }

    /**
     * update
     * @param Request request
     * @return Illuminate\Http\JsonResponse
     */
    public function update(int $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => ['nullable', 'in:' . implode(',', Event::$STATUS)],
            // 'type' => ['nullable', 'in:' . implode(',', Event::$TYPES)],
            'details' => ['nullable', 'string'],
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        return Event::query()->where([['id', $id], ['client_id', auth()->user()->client->id]])->update($validator)
            ? $this->sendResponse(Event::query()->find($id))
            : $this->sendResponse(null, 'No se pudo actualizar', 400);
    }
}
