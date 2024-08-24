<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produto>
 */
class ProdutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Produto::class;
    public function definition(): array
    {
        return [
            'nome' => $this->faker->text(50),
            'descricao' => $this->faker->text(200),
            'preco' => $this->faker->randomFloat(2, 10, 1000),
            'data_validade' => $this->faker->date(),
            'imagem' => $this->faker->imageUrl,
            'categoria_id' => Categoria::factory()
        ];
    }
}
