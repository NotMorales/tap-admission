<?php

namespace App\Pdf;

use Illuminate\Support\Collection;

class UserPdf extends BasePdf
{
    public function __construct(Collection $users)
    {
        $this->view = 'exports.users-pdf';
        $this->fileName = 'users.pdf';
        $this->data = compact('users');
    }
}
