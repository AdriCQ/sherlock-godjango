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
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        $validator['status'] = 'onprogress';
        $validator['user_id'] = auth()->id();
        $model = new Event($validator);
        $model->save();
        return $this->sendResponse($model, 'Evento creada', 201);
    }

    /**
     * Find
     * @param int $id
     * @return Illuminate\Http\JsonResponse
     */
    public function find(int $id)
    {
        return $this->sendResponse(Event::query()->where('id', $id)->with('user')->first());
    }

    /**
     * list
     * @return Illuminate\Http\JsonResponse
     */
    public function list()
    {
        return $this->sendResponse(Event::all());
    }

    /**
     * remove
     * @param int $id
     * @return Illuminate\Http\JsonResponse
     */
    public function remove(int $id)
    {
        $model = Event::find($id);
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
        $qry = Event::query();
        if (isset($validator['created_at'])) {
            $qry = $qry->whereDate('created_at', '>', $validator['created_at']);
            unset($validator['created_at']);
        }
        if (
            isset($validator['status']) || isset($validator['type'])
        ) {
            $qry = $qry->where($validator);
        }
        return $this->sendResponse($qry->get());
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
        return Event::find($id)->update($validator)
            ? $this->sendResponse(Event::query()->find($id))
            : $this->sendResponse(null, 'No se pudo actualizar', 400);
    }
}
