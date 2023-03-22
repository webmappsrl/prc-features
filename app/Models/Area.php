<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Area extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'excerpt',
        'description',
        'identifier',
        'osm_id',
        'feature_image',
        'geometry',
        'import_method',
        'source_id',
        'admin_level',
        'geohub_id'

    ];

    /**
     * Translatable attributes.
     *
     * @var array<int, string>
     */

    public $translatable = [
        'name',
        'excerpt',
        'description',
    ];
}
