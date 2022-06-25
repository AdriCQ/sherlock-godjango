<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Create
     * @param Request request
     * @return Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string']
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        $model = new Category($validator);
        return $model->save()
            ? $this->sendResponse($model, 'Categoria creada', 201)
            : $this->sendResponse($model->errors, 'Error al crear categoria', 502);
    }

    /**
     * list
     * @return Illuminate\Http\JsonResponse
     */
    public function list()
    {
        return $this->sendResponse(Category::all());
    }

    /**
     * remove
     * @param int $id
     * @return Illuminate\Http\JsonResponse
     */
    public function remove(int $id)
    {
        $cat = Category::find($id);
        return $cat && $cat->delete()
            ? $this->sendResponse()
            : $this->sendResponse(null, 'No se pudo eliminar', 400);
    }

    /**
     * update
     * @param Request request
     * @return Illuminate\Http\JsonResponse
     */
    public function update(int $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string']
        ]);
        if ($validator->fails()) {
            return $this->sendResponse($validator->errors(), 'Verifique los datos enviados', 400);
        }
        $validator = $validator->validate();
        return Category::query()->where('id', $id)->update($validator)
            ? $this->sendResponse(Category::query()->where('id', $id)->first())
            : $this->sendResponse(null, 'No se pudo actualizar', 400);
    }
}
