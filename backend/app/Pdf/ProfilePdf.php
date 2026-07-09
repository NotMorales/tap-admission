<?php

namespace App\Pdf;

use Illuminate\Support\Collection;

class ProfilePdf extends BasePdf
{
    public function __construct(Collection $profiles)
    {
        $this->view = 'exports.profiles-pdf';
        $this->fileName = 'profiles.pdf';
        $this->data = compact('profiles');
    }
}
