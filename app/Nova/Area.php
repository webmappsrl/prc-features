<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Http\Requests\NovaRequest;

class Area extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Area>
     */
    public static $model = \App\Models\Area::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'excerpt', 'description', 'identifier', 'osm_id', 'feature_image'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Name', 'name')
                ->rules('required')
                ->nullable(),
            Text::make('Excerpt', 'excerpt')
                ->nullable(),
            Markdown::make('Description', 'description')
                ->nullable()
                ->alwaysShow(),
            Text::make('Identifier', 'identifier')
                ->nullable(),
            Text::make('Osm id', 'osm_id')
                ->nullable()
                ->onlyOnDetail(),
            Text::make('Feature image', 'feature_image')
                ->nullable(),
            Hidden::make('Geometry', 'geometry')
                ->nullable(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}