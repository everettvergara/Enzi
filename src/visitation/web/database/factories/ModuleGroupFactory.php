<?php

namespace Database\Factories;

use App\Models\tb_sys_mf_mod_group;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModuleGroupFactory extends Factory
{
    protected $model = tb_sys_mf_mod_group::class;
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
            'menu' => $this->faker->word(),
            'ref_mod_id' => null,
            'seq' => null,
            'is_active' => 1,
        ];
    }
}
