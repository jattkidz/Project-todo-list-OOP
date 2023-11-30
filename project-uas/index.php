<?php
require_once('Task.php');
require_once('TaskManager.php');

$taskManager = new TaskManager();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['task'])) {
        // Tambah tugas ke daftar
        $taskName = $_POST['task'];
        $taskManager->addTask($taskName);

        // Alihkan kembali ke halaman utama
        header('Location: index.php');
    }

    if (isset($_POST['delete'])) {
        // Proses penghapusan tugas
        $taskIdToDelete = $_POST['delete'];
        $taskManager->removeTask($taskIdToDelete);
        
        // Alihkan kembali ke halaman utama
        header('Location: index.php');
    }

    if (isset($_POST['complete'])) {
        // Proses penandaan tugas sebagai selesai
        $taskIdToComplete = $_POST['complete'];
        $taskManager->completeTask($taskIdToComplete);
        
        // Alihkan kembali ke halaman utama
        header('Location: index.php');
    }

    // Hapus tugas yang sudah selesai
    if (isset($_POST['deleteCompleted'])) {
        $taskManager->removeCompletedTasks();
        header('Location: index.php');
    }
}

// Ambil ulang daftar tugas setelah pemrosesan formulir
$tasks = $taskManager->getTasks();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>List Tugas - Project OOP</title>
</head>
<body>
    <div class="container">
        <h1>List Tugas</h1>
        <form method="post">
            <label for="task">Tambah Tugas:</label>
            <input type="text" id="task" name="task" required>
            <button type="submit">Tambah</button>
        </form>
        
        <?php
        echo '<h2>Belum Selesai</h2>';
        echo '<ul id="task-list">';
        foreach ($tasks as $taskId => $task) {
            if (!$task->isCompleted()) {
                echo '<li id="task-' . $taskId . '" class="' . ($task->isCompleted() ? 'completed' : '') . '">';
                echo '<span class="task-title">' . $task->getTaskName() . '</span>';
                echo '<div class="button-div">';
                echo '<form method="post" style="display:inline;">';
                echo '<input type="hidden" name="complete" value="' . $taskId . '">';
                echo '<button type="submit" class="complete-btn" data-task-id="' . $taskId . '">Complete</button>';
                echo '</form>';
                echo '<form method="post" style="display:inline;">';
                echo '<input type="hidden" name="delete" value="' . $taskId . '">';
                echo '<button type="submit" class="delete-btn">Delete</button>';
                echo '</form>';
                echo '</div>';
                echo '</li>';
            }
        }
        echo '</ul>';
        
        echo '<h2>Sudah Selesai</h2>';
        echo '<ul id="completed-task-list" class="completed-task-list">';
        foreach ($tasks as $taskId => $task) {
            if ($task->isCompleted()) {
                echo '<li id="task-' . $taskId . '" class="task-item completed">';
                echo '<span class="task-title">' . $task->getTaskName() . '</span>';
                echo '<form method="post" style="display:inline;">';
                echo '<input type="hidden" name="delete" value="' . $taskId . '">';
                echo '<button type="submit" class="delete-btn task-btn">Delete</button>';
                echo '</form>';
                echo '</li>';
            }
        }
        echo '</ul>';
        ?>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
