<?php

namespace silverorange\DevTest\Controller;

use silverorange\DevTest\Context;
use silverorange\DevTest\Model\Post;
use silverorange\DevTest\Template;

class PostIndex extends Controller
{
    /**
     * @var array<Post>
     */
    private array $posts = [];
    private $pdo;
    private $table = "posts";

    public function __construct($db) {
        $this->pdo = $db;
        $this->loadData();
    }

    public function getContext(): Context
    {
        $context = new Context();
        $context->title = 'Posts';
        $context->content = strval(count($this->posts));
        $context->posts = $this->posts;
        return $context;
    }

    public function getTemplate(): Template\Template
    {
        return new Template\PostIndex();
    }

    protected function loadData(): void
    {
        $query = "SELECT posts.*, authors.full_name as author_fullname FROM {$this->table}
                INNER JOIN authors ON posts.author = authors.id
                ORDER BY posts.created_at DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $this->posts = $stmt->fetchAll();
    }
}
