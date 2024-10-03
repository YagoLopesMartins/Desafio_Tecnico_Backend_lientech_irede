<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProdutoRequest;
use App\Models\Produto;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Produto::query();

        if ($request->has('search')) {
            $query->where('nome', 'LIKE', '%' . $request->search . '%')
                ->orWhere('descricao', 'LIKE', '%' . $request->search . '%');
        }

        $products = $query->paginate(10);

        return response()->json([
            'status' => true,
            'data' => $products,
        ],200);
    }
    public function show(Produto $produto): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => $produto->load('categorias')
        ],200);
    }

    public function store(ProdutoRequest $request): JsonResponse
    {
        if (!$request->hasFile('imagem')) {
            return response()->json(['error' => 'Image upload failed'], 422);
        }
        DB::beginTransaction();
        try {
            $path = $request->file('imagem')->store('product_images', 'public');
            $produto = Produto::create($request->validated() + ['imagem' => $path]);

            DB::commit();

            return response()->json([
                'status' => true,
                'data' => $produto,
                'message' => "Produto cadastrado com sucesso!",
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => "Produto não cadastrado!",
            ], 400);
        }
    }

    public function update(ProdutoRequest $request, Produto $produto) :JsonResponse
    {
        $produto->update($request->validated());

        $produto->imagem = $this->handleImageUpload($request, $produto);

        $produto->save();

        return response()->json([
            'status' => true,
            'data' => $produto,
            'message' => 'Produto atualizado com sucesso!'
        ], 200);
    }
    public function destroy(Produto $produto): JsonResponse
    {
        if ($produto->imagem) {
            Storage::disk('public')->delete($produto->imagem);
        }
        try {
            $produto->delete();
            return response()->json([
                'status' => true,
                'message' => "Produto excluido com sucesso!",
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Produto não excluido!",
            ], 400);
        }
    }
    protected function handleImageUpload(Request $request, ?Produto $produto = null)
    {
        if ($request->hasFile('imagem')) {
            if ($produto && $produto->imagem) {
                Storage::disk('public')->delete($produto->imagem);
            }
            return $request->file('imagem')->store('product_images', 'public');
        }
        return $produto->imagem ?? null;
    }
}
