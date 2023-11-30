<?php
class Task {
    private $taskName;
    private $completed;

    public function __construct($taskName, $completed = false) {
        $this->taskName = $taskName;
        $this->completed = $completed;
    }

    public function getTaskName() {
        return $this->taskName;
    }

    public function isCompleted() {
        return $this->completed;
    }

    public function completeTask() {
        $this->completed = true;
    }

    public function toArray() {
        return [
            'task' => $this->taskName,
            'completed' => $this->completed,
        ];
    }
}
?>
