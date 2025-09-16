<?php

namespace silverorange\DevTest\Controller;

use silverorange\DevTest\Context;
use silverorange\DevTest\Template;
use silverorange\DevTest\Model\Post;

class JsonImporter extends Controller
{
    protected \PDO $db;
    private $postModel;

    /**
     * @var array<string>
     */
    protected array $params = [];

    /**
     * @param \PDO  $db
     * @param array<string> $params
     */
    public function __construct(\PDO $db, array $params)
    {
        $this->setDatabase($db);
        $this->postModel = new Post($this->db);
    }

    public function setDatabase(\PDO $db): self
    {
        $this->db = $db;
        return $this;
    }

    public function getContext(): Context
    {
        $context = new Context();
        $context->title = 'JSON Importer';
        $context->content = 'Imported data from JSON files.';
        return $context;
    }

    public function getTemplate(): Template\Template
    {
        return new Template\JsonImporter();
    }

    public function importJsonFiles($directory = __DIR__) {
        $files = glob($directory . "../../data/*.json");
        $imported = 0;
        $skipped = 0;

        foreach ($files as $file) {
            $jsonData = file_get_contents($file);
            $data = json_decode($jsonData, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                echo "Invalid JSON in $file\n";
                continue;
            }

            // For single record JSON files
            if (isset($data['id'])) {
                $data = [$data];
            }

            if (is_array($data)) {
                foreach ($data as $row) {
                    if (is_array($row)) {
                        // either insert or skip duplicate
                        if ($this->postModel->insert($row)) {
                            $imported++;
                        } else {
                            $skipped++;
                        }
                    }
                }
            }
        }
        return ['imported' => $imported, 'skipped' => $skipped];
    }
}
