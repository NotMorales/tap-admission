<?php

namespace App\Pdf;

use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;

abstract class BasePdf
{
    protected string $view;

    protected string $fileName;

    protected array $data = [];

    public function download(): Response
    {
        return Pdf::loadView($this->view, $this->data)
            ->setPaper('letter', 'portrait')
            ->download($this->fileName);
    }
}
