<?php

namespace silverorange\DevTest\Template;

use silverorange\DevTest\Context;
use Michelf\Markdown;

class PostDetails extends Layout
{
    protected function renderPage(Context $context): string
    {

        // use composer package to convert markdown
        $convertBody = Markdown::defaultTransform($context->body);

        return <<<HTML
            <h1 class="postdetails_title">{$context->title}</h1>
            <div class="postdetails_author">Author: {$context->author_fullname}</div>
            <div class="postdetails_body">{$convertBody}</div>
            HTML;
    }
}
