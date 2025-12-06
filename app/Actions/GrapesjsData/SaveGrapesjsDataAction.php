<?php

namespace App\Actions\GrapesjsData;

use App\DTOs\GrapesjsDataData;
use App\Models\GrapesjsData;

class SaveGrapesjsDataAction
{
    public static function handle(GrapesjsDataData $data, ?GrapesjsData $grapesJs = null): GrapesjsData
    {
        if (!$grapesJs) {
            $grapesJs = new GrapesjsData;
        }

        $grapesJs->task()->associate($data->task);
        $grapesJs->html = $data->html;
        $grapesJs->css = $data->css;
        $grapesJs->save();

        return $grapesJs;
    }
}
