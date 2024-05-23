<?php

class AppController {
    protected $requestMethod;

    public function __construct() {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
    }

    protected function isGet(): bool {
        return $this->requestMethod === 'GET';
    }

    protected function isPost(): bool {
        return $this->requestMethod === 'POST';
    }

    public function render(string $template = null, array $variables = []) {
        $templatePath = 'public/views/'. $template . '.html';
        $output = 'File not found';
    
        if(file_exists($templatePath)){
            extract($variables);
            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        }
        print $output;
    }
}
