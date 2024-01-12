<?php

namespace Acme;


use Exception;
use Illuminate\Database\MySqlConnection;

//Solid - 3 prinsiples - B.Liskov substitution

//it's a binding contract
interface LessonRepositoryInterface {
    public function getAll();
}

class FileLessonRepository implements LessonRepositoryInterface {

    public function getAll()
    {
        // TODO: Implement getAll() method.
        return [];
    }
}

class DbLessonRepository implements LessonRepositoryInterface {

    public function getAll()
    {
        // TODO: Implement getAll() method.
        return Lesson::all(); //violates the LSP
    }
}

function foo(LessonRepositoryInterface $lesson) {
    $lessons = $lesson->getAll();
}


/*
 * SOLID - 4 principles - I - interface segreg. system
 */

interface ManagableInterface {
    public function beManaged();
}

interface WorkableInterface {
    public function work();
}

interface SleepableInterface {
    public function sleep();
}

class HumanWorker implements WorkableInterface, SleepableInterface, ManagableInterface {
    public function work() {

    }

    public function sleep()
    {
        // TODO: Implement sleep() method.
    }

    public function beManaged()
    {
        $this->work();
        $this->sleep();
    }
}

class AndroidWorker implements WorkableInterface, ManagableInterface {

    public function work()
    {
        // TODO: Implement work() method.
    }

    public function beManaged()
    {
        // TODO: Implement beManaged() method.
        $this->work();
    }
}


class Captain {
    public function manage(ManagableInterface $worker)
    {
        $worker->beManaged();
    }
}


/*
 * SOLID - 5principles - D-dependency inversion
 */

interface ConnectionInterface {
    public function connect();
}

class DbConnection implements ConnectionInterface {
    public function connect() {

    }
}

class PasswordReminder {
    /*
     * @var Mysql connection
     */
    private $dbConnection;

    public function __construct(ConnectionInterface $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }


}




