<?php

namespace Database\Factories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Area>
 */
class AreaFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $lat1 = $this->faker->randomFloat(6, 10.331693, 10.665219);
        $lat2 = $this->faker->randomFloat(6, 10.331693, 10.665219);
        $lng1 = $this->faker->randomFloat(6, 43.6516, 43.873329);
        $lng2 = $this->faker->randomFloat(6, 43.6516, 43.873329);

        return [
            'name' => $this->faker->name(),
            'excerpt' => $this->faker->paragraph(),
            'description' => $this->faker->paragraphs(3, true),
            'identifier' => $this->faker->unique()->word(),
            'osm_id' => $this->faker->unique()->randomNumber(),
            'feature_image' => $this->faker->imageUrl(),
            'geometry' => DB::raw("(ST_Multi(ST_MakeEnvelope($lng1, $lat1, $lng2, $lat2, 4326)))"),
            'import_method' => $this->faker->text(10),
            'source_id' => $this->faker->randomNumber(),
            'admin_level' => $this->faker->randomNumber(),
        ];
    }
}
