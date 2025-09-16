<?php

namespace silverorange\DevTest\Template;

use silverorange\DevTest\Context;

class PostIndex extends Layout
{
    protected function renderPage(Context $context): string
    {

        $posts = '';
        foreach ($context->posts as $post) {
            $posts .= <<<HTML
                <li class="posts_list_li">
                    <a href="/posts/{$post['id']}" class="posts_list_url">{$post['title']}</a>
                    <span class="posts_list_author">by {$post['author_fullname']}</span>
                </li>
            HTML;
        }

        return <<<HTML
            <h1>Posts</h1>
            <div>Click on post title to view a post</div>
            <ul class="posts_list">
                {$posts}
            </ul>
            HTML;
    }
}
