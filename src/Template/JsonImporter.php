<?php

namespace silverorange\DevTest\Template;

use silverorange\DevTest\Context;

class JsonImporter extends Layout
{

    protected function renderPage(Context $context): string
    {
        return <<<HTML
            <p>{$context->content} </p>
            HTML;
    }
}
