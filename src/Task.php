<?php
    class Task
    {
        private $description;
        private $id;

        //passing parameters on description and id
        //id is now equal to $id which is null
        function __construct($description, $id = null)
        {
            $this->description = $description;
            $this->id = $id;
        }

        function getId()
        {
            return $this->id;
        }

        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }

        function setDescription($new_description)
        {
            $this->description = (string) $new_description;
        }

        function getDescription()
        {
            return $this->description;
        }


        //statement equals the global database that has changed the values in tasks to add a new description. each description has a new id.
        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO tasks (description) VALUES ('{$this->getDescription()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        //creates array "tasks" out of "returned_tasks" which is everything from the database TABLE tasks (both description and id)
        static function getAll()
        {
            $returned_tasks = $GLOBALS['DB']->query("SELECT * FROM tasks;");
            $tasks = array();
            foreach ($returned_tasks as $task) {
                $description = $task['description'];
                $id = $task['id'];
                $new_task = new Task($description, $id);
                array_push($tasks, $new_task);
            }
            return $tasks;
        }

        //executes DELETE FROM the table tasks all of the tasks.
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM tasks *;");
        }

        //
        static function find($search_id)
        {
            $found_task = null;
            $tasks = Task::getAll();
            foreach($tasks as $task) {
                $task_id = $task->getId();
                if ($task_id == $search_id) {
                    $found_task = $task;
                }
            }

            return $found_task;
        }
    }
?>

function returnCat($cat) {
    return $cat
}
$apples = 'dog'
returnCat($apples)
