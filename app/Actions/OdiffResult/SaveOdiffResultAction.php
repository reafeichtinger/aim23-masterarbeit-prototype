<?php

namespace App\Actions\OdiffResult;

use App\DTOs\OdiffResultData;
use App\Models\OdiffResult;

class SaveOdiffResultAction
{
    public static function handle(OdiffResultData $data, ?OdiffResult $odiff = null): OdiffResult
    {
        if (!$odiff) {
            $odiff = new OdiffResult;
        }

        $odiff->testRun()->associate($data->test_run);
        $odiff->editor = $data->editor;
        $odiff->pixels = $data->pixels;
        $odiff->percent = $data->percent;
        $odiff->lines = $data->lines;
        $odiff->save();

        return $odiff;
    }
}
