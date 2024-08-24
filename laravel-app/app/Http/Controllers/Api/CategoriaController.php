<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriaRequest;
use App\Models\Categoria;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    public function index(): JsonResponse
    {
        $categorias = Categoria::orderBy('id', 'DESC')->paginate(10);

        return response()->json([
            'status' => true,
            'categorias' => $categorias,
        ], 200);
    }
    public function show(Categoria $categoria): JsonResponse
    {
        return response()->json([
            'status' => true,
            'categoria' => $categoria,
        ], 200);
    }

    public function store(CategoriaRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $categoria = Categoria::create([
                'nome' => $request->nome
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'categoria' => $categoria,
                'message' => "Categoria cadastrada com sucesso!",
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => "Categoria não cadastrada!",
            ], 400);
        }
    }
    public function update(CategoriaRequest $request, Categoria $categoria): JsonResponse
    {
        DB::beginTransaction();
        try {
            $categoria->update([
                'nome' => $request->nome
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'categoria' => $categoria,
                'message' => "Categoria editada com sucesso!",
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => "Categoria não editada!",
            ], 400);
        }
    }
    public function destroy(Categoria $categoria): JsonResponse
    {
        try {
            $categoria->delete();
            return response()->json([
                'status' => true,
                'categoria' => $categoria,
                'message' => "Categoria apagada com sucesso!",
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Categoria não apagada!",
            ], 400);
        }
    }
}
