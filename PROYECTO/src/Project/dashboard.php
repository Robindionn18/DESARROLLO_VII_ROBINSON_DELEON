<?php




// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define the base path for includes
define('BASE_PATH', __DIR__ . '/');

// Include the configuration file
require_once '../../config.php';

// Include necessary files
require_once BASE_PATH . '../Database.php';
require_once 'ProjectManager.php';
require_once 'Project.php';

// Create an instance of ProjectManager
$projectManager = new ProjectManager();

// Get the action from the URL, default to 'list' if not set
$action = $_GET['action'] ?? 'list';

// Handle different actions
switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $projectManager->getAllBooks($_POST['title'], $_POST['description']);
            header('Location: ' . BASE_URL);
            exit;
        }
        require BASE_PATH . 'views/task_form.php';
        break;
    case 'edit':
        exit("TODO");
        break;
    case 'delete':
        $projectManager->deleteTask($_GET['id']);
        header('Location: ' . BASE_URL);
        break;
    default:
        $tasks = $projectManager->getAllTasks();
        require BASE_PATH . 'views/list.php';
        break;
}
