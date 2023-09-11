<?php

namespace App\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Basic;

class ContentPolicy extends Basic
{
    public function configure(): void
    {
        parent::configure();
        $this->addDirective(Directive::DEFAULT, 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/');
        $this->addDirective(Directive::DEFAULT, 'https://localhost:8000/inventory/css/style.min.css');
        $this->addDirective(Directive::DEFAULT, 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js');
        $this->addDirective(Directive::DEFAULT, 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js');
        $this->addDirective(Directive::DEFAULT, config('app.url'));
    }
}
