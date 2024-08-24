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
            'products' => $products,
        ],200);
    }
    public function show(Produto $produto): JsonResponse
    {
        return response()->json([
            'status' => true,
            'produto' => $produto->load('categorias')
        ],200);
    }

    public function store(ProdutoRequest $request): JsonResponse
    {
        DB::beginTransaction();

        if ($request->hasFile('imagem')) {
            $path = $request->file('imagem')->store('product_images', 'public');
        } else {
            $path = null;
            return response()->json(['error' => 'Image upload failed'], 422);
        }
        try {
            $produto = Produto::create([
                'nome' => $request->nome,
                'descricao' => $request->descricao,
                'preco' => $request->preco,
                'data_validade' => $request->data_validade,
                'imagem' => $path,
                'categoria_id' => $request->categoria_id
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'produto' => $produto,
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

    public function update(Request $request, $id)
    {
        // Validação dos dados
        $request->validate([
            'nome' => 'required|max:50',
            'descricao' => 'required|max:200',
            'preco' => 'required|numeric|min:0',
            'data_validade' => 'required|date|after_or_equal:today',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        // Encontra o produto pelo ID
        $product = Produto::findOrFail($id);

        // Verifique se o arquivo de imagem foi enviado
        if ($request->hasFile('imagem')) {
            // Armazena a nova imagem e substitui a antiga
            $path = $request->file('imagem')->store('product_images', 'public');
            $product->imagem = $path;
        }

        // Atualiza os demais campos
        $product->nome = $request->input('nome');
        $product->descricao = $request->input('descricao');
        $product->preco = $request->input('preco');
        $product->data_validade = $request->input('data_validade');
        $product->categoria_id = $request->input('categoria_id');

        // Salva as alterações
        $product->save();

        // Retorna a resposta
        return response()->json($product, 200);
    }
    public function destroy($id): JsonResponse
    {
        $product = Produto::findOrFail($id);
        if ($product->imagem) {
            Storage::disk('public')->delete($product->imagem);
        }
        try {
            $product->delete();
            return response()->json([
                'status' => true,
                'produto' => $product,
                'message' => "Produto apagado com sucesso!",
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Produto não apagado!",
            ], 400);
        }
    }
}
