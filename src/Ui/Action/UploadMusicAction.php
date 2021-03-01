<?php

declare(strict_types=1);

namespace App\Ui\Action;

use Symfony\Component\HttpFoundation\Request;

class UploadMusicAction
{
    public function __invoke(Request $request)
    {
        var_dump($request->files->get('file'));
    }
}
