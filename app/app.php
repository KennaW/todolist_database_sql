<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Task.php";
    require_once __DIR__."/../src/Category.php";

     $app = new Silex\Application();

     $DB = new PDO('pgsql:host=localhost;dbname=to_do');

     $app->register(new Silex\Provider\TwigServiceProvider(), array(
         'twig.path' => __DIR__.'/../views'
     ));

     $app->get("/", function() use ($app) {
        return $app['twig']->render('index.twig');
     });

     $app->get("/tasks", function() use ($app) {
         return $app['twig']->render('tasks.twig', array('tasks' => Task::getAll()));
     });

     $app->get("/categories", function() use ($app) {
         return $app['twig']->render('categories.twig', array('categories' => Category::getAll()));
     });

     //add to get all
     //$GLOBALS['DB']->query("SELECT * FROM tasks WHERE description = {'$description'};");

     //CHANGINGEGINGING WE CHAGNED THIS FOR SEARCHING BUT IT DIDN'T AND WE DON'T KNOW WHY
    //  $app->post("/tasks", function() use ($app){
    //      $task = new Task($_POST['description']);
    //      $task->save();
    //      $vardump = var_dump($task);
    //      $task1 = Task::find(21);
     //
    //      return $app['twig']->render('tasks.twig', array('task1' => $task1, 'vardump' => $vardump));
    //  });

    $app->post("/tasks", function() use ($app) {
        $description = $_POST['description'];
        $task = new Task($description);
        $task->save();
        return $app['twig']->render('tasks.twig', array('tasks' => Task::getAll()));
     });
     $app->post("/delete_tasks", function() use ($app) {
         Task::deleteAll();
         return $app['twig']->render('index.twig');
     });


     $app->post("/categories", function() use ($app) {
         $category = new Category($_POST['name']);
         $category->save();
         return $app['twig']->render('categories.twig', array('categories' => Category::getAll()));
     });

     $app->post("/delete_categories", function() use ($app){
         Category::deleteAll();
         return $app['twig']->render('index.twig');
     });

     $app->get("/search", function() use ($app){
         $task1 = Task::find($_GET['search_id']);
         return $app['twig']->render('search.twig', array('task1' => $task1));
     });
     return $app;
?>
