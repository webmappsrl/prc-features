<?php

namespace App\Console\Commands;

use App\Models\Area;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PrcFeaturesImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prc-features:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Areas from geohub1';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if (User::all()->count() === 0) {
            $this->info('Creating admin user...');
            User::factory()->create(
                [
                    'name' => 'Webmapp',
                    'email' => 'team@webmapp.it',
                    'password' => bcrypt('webmapp'),
                    'roles' => UserRole::Admin,
                ]
            );
        }

        $taxonomyIds = json_decode(file_get_contents('https://geohub.webmapp.it/api/export/taxonomy/wheres'), true);
        $count = 0;
        foreach ($taxonomyIds as $taxonomy => $value) {
            $count++;
            $this->info('Importing taxonomy ' . $taxonomy . ' (' . $count . '/' . count($taxonomyIds) . ')');

            if (Area::where('osm_id', $taxonomy)->exists()) {
                $this->info('Taxonomy ' . $taxonomy . ' already exists');
                continue;
            }
            try {
                $element = json_decode(file_get_contents('https://geohub.webmapp.it/api/taxonomy/where/geojson/' . $taxonomy), true);
            } catch (\Exception $e) {
                $this->info('Taxonomy ' . $taxonomy . ' not found');
                continue;
            }
            $element = json_decode(file_get_contents('https://geohub.webmapp.it/api/taxonomy/where/geojson/' . $taxonomy), true);
            $elementProperties = $element['properties'] ?? null;
            $elementName = isset($elementProperties['name']) ? $elementProperties['name']['it'] ?? $elementProperties['name']['de'] : null;
            $elementExcerpt = isset($elementProperties['excerpt']) ? $elementProperties['excerpt']['it'] ?? $elementProperties['excerpt']['de'] : null;
            $elementDescription = isset($elementProperties['description']) ? $elementProperties['description']['it'] ?? $elementProperties['description']['de'] : null;
            $elementFeatureImage = isset($elementProperties['feature_image']) ? $elementProperties['feature_image'] : null;
            $geojson_content = json_encode($element['geometry']);
            $sql = "SELECT ST_AsText(ST_Force2D(ST_CollectionExtract(ST_Polygonize(ST_GeomFromGeoJSON('" . $geojson_content . "')), 3))) As wkt";
            $elementGeometry = DB::select($sql)[0]->wkt;


            Area::updateOrCreate(
                [
                    'identifier' => $elementProperties['identifier'],
                ],
                [
                    'name' => $elementName,
                    'excerpt' => $elementExcerpt,
                    'description' => $elementDescription,
                    'import_method' => $elementProperties['import_method'],
                    'source_id' => $elementProperties['source_id'],
                    'admin_level' => $elementProperties['admin_level'],
                    'feature_image' => $elementFeatureImage,
                    'osm_id' => $elementProperties['id'],
                    'geometry' => $elementGeometry,
                ]
            );
        }

        $this->info('Taxonomies imported correctly');
    }
}
