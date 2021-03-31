<?php

namespace Database\Factories;

use App\Models\Prospect;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProspectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Prospect::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    /*
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text(20),
            'format' => $this->faker->randomElement(['pdf','doc','xls']),
            'version' => '1',
            'file' => '01',
        ];
    }
    */
    public function definition()
    {
        return [
            //
        ];
    }
}
