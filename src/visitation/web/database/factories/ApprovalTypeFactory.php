<?php

namespace Database\Factories;

use App\Models\tb_sys_mf_approval_hierarchy_type;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApprovalTypeFactory extends Factory
{

    protected $model = tb_sys_mf_approval_hierarchy_type::class;
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
            'description' => $this->faker->sentence(2),
            'is_active' => 1 
        ];
    }
}
