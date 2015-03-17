<?php

//tells php secret things

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

//loads Task.php
    require_once "src/Task.php";

//assigns database to variable

    $DB = new PDO('pgsql:host=localhost;dbname=to_do_test');


//Class with phpunit test
    class TaskTest extends PHPUnit_Framework_TestCase
    {

        //protected function. function that can only be edited by inhereted ... things
        //called after every tests
        protected function tearDown()
        {
            Task::deleteAll();
        }

        //tests the save for tasks
        //assigns id to null -- can sometimes force a pass test (false positive)
        function test_save()
        {
            //Arrange
            $description = "Wash the dog";
            $id = null;
            $test_task = new Task($description, $id);

            //Act
            $test_task->save();

             //Assert
             $result = Task::getAll();
             $this->assertEquals($test_task, $result[0]);
         }

         //tests get all for tasks
         function test_getAll()
         {
             //Arrange
             $description = "Wash the dog";
             $description2 = "Water the lawn";
             $id = null;
             $test_Task = new Task($description, $id);
             $test_Task->save();
             $test_Task2 = new Task($description2, $id);
             $test_Task2->save();

             //Act
             $result = Task::getAll();
            //  var_dump([$test_Task, $test_Task2]);
             //Assert
             $this->assertEquals([$test_Task, $test_Task2], $result);

         }

         //tests delete all for tasks
         function test_deleteAll()
         {
             //Arrange
             $description = "Wash the dog";
             $description2 = "Water the lawn";
             $id = null;
             $test_Task = new Task($description, $id);
             $test_Task->save();
             $test_Task2 = new Task($description2, $id);
             $test_Task2->save();

             //Act
             Task::deleteAll();

             //Assert
             $result = Task::getAll();
             $this->assertEquals([], $result);

         }


         function test_getId()
         {
             //Arrange
             $description = "Wash the dog";
             $id = 1;
             $test_Task = new Task($description, $id);

             //Act
             $result = $test_Task->getId();

             //Assert
             $this->assertEquals(1, $result);
         }

         function test_setId()
         {
             //Arrange
             $description = "Wash the dog";
             $id = null;
             $test_Task = new Task($description, $id);

             //Act
             $test_Task->setId(2);

             //Assert
             $result = $test_Task->getId();
             $this->assertEquals(2, $result);
         }


            function test_find()
            {
                //Arrange
                $description = "Wash the dog";
                $id = null;
                $description2 = "Water the lawn";
                $test_Task = new Task($description, $id);
                $test_Task->save();
                $test_Task2 = new Task($description2, $id);
                $test_Task2->save();

                //Act
                $result = Task::find($test_Task->getId());

                //Assert
                $this->assertEquals($test_Task, $result);
            }

    }
?>
