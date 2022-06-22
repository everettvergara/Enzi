<?php

namespace Database\Factories;

use App\Models\tb_sys_mf_access_type;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccessTypeFactory extends Factory
{
    protected $model = tb_sys_mf_access_type::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->lexify('?????'),
            'name' => $this->faker->word(),
            'is_active' => 1 
        ];
    }
}
