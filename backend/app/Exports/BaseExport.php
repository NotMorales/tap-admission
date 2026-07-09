<?php

namespace App\Exports;

use Symfony\Component\HttpFoundation\StreamedResponse;

abstract class BaseExport
{
    abstract protected function headers(): array;

    abstract protected function rows(): array;

    abstract protected function filename(): string;

    public function downloadCsv(): StreamedResponse
    {
        return response()->streamDownload(function () {

            $file = fopen('php://output', 'w');

            // UTF-8 BOM
            fwrite($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, $this->headers());

            foreach ($this->rows() as $row) {
                fputcsv($file, $row);
            }

            fclose($file);

        }, $this->filename().'.csv');
    }
}
