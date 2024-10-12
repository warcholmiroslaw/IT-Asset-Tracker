<?php

require_once __DIR__ . '/../repository/EquipmentRepository.php';
require_once __DIR__ . '/../repository/OwnershipRepository.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../../Database.php';

class AppController {
    protected $requestMethod;
    public $equipmentRepository;
    public $ownershipRepository;
    public $userRepository;

    public function __construct() {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->equipmentRepository = new EquipmentRepository();
        $this->ownershipRepository = new OwnershipRepository();
        $this->userRepository = new UserRepository();
    }

    protected function isGet(): bool {
        return $this->requestMethod === 'GET';
    }

    protected function isPost(): bool {
        return $this->requestMethod === 'POST';
    }

    public function render(string $template = null, array $variables = []) {
        $templatePath = 'public/views/'. $template . '.php';
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
