<?php

namespace KnpU\Tests\DataFixtures;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Table;
use KnpU\Domain\Model\Project;
use KnpU\Domain\Model\User;
use KnpU\Infrastructure\Security\Token\ApiTokenRepository;
use Silex\Application;
use Symfony\Component\Filesystem\Filesystem;

class FixturesManager
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function resetDatabase()
    {
        // 1) check DB permissions
        $dbPath = $this->app['sqlite_path'];
        $dbDir = \dirname($dbPath);

        // make sure the directory is available and writeable
        $filesystem = new Filesystem();
        $filesystem->mkdir($dbDir);
        $filesystem->chmod($dbDir, 0777, 0000, true);

        if (!\is_writable($dbDir)) {
            throw new \Exception('Unable to write to '.$dbPath);
        }

        // 2) Add some tables bro!
        $schemaManager = $this->getConnection()->getSchemaManager();

        $userTable = new Table('user');
        $userTable->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $userTable->setPrimaryKey(['id']);
        $userTable->addColumn('email', 'string', ['length' => 255]);
        $userTable->addUniqueIndex(['email']);
        $userTable->addColumn('username', 'string', ['length' => 50]);
        $userTable->addUniqueIndex(['username']);
        $userTable->addColumn('password', 'string', ['length' => 255]);
        $schemaManager->dropAndCreateTable($userTable);

        $tokenTable = new Table(ApiTokenRepository::TABLE_NAME);
        $tokenTable->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $tokenTable->setPrimaryKey(['id']);
        $tokenTable->addColumn('token', 'string', ['length' => 32]);
        $tokenTable->addColumn('userId', 'integer');
        $tokenTable->addColumn('notes', 'string', ['length' => 255]);
        $tokenTable->addColumn('createdAt', 'datetime');
        $tokenTable->addUniqueIndex(['token'], 'token_idx');
        $tokenTable->addForeignKeyConstraint($userTable, ['userId'], ['id']);
        $schemaManager->dropAndCreateTable($tokenTable);

        $programmerTable = new Table('programmer');
        $programmerTable->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $programmerTable->setPrimaryKey(['id']);
        $programmerTable->addColumn('nickname', 'string', ['length' => 255]);
        $programmerTable->addUniqueIndex(['nickname']);
        $programmerTable->addColumn('avatarNumber', 'integer');
        $programmerTable->addColumn('tagLine', 'integer', ['notnull' => false]);
        $programmerTable->addColumn('userId', 'integer');
        $programmerTable->addColumn('powerLevel', 'integer');
        $programmerTable->addForeignKeyConstraint($userTable, ['userId'], ['id']);
        $schemaManager->dropAndCreateTable($programmerTable);

        $projectTable = new Table('project');
        $projectTable->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $projectTable->setPrimaryKey(['id']);
        $projectTable->addColumn('name', 'string', ['length' => 255]);
        $projectTable->addColumn('difficultyLevel', 'integer');
        $schemaManager->dropAndCreateTable($projectTable);

        $battleTable = new Table('battle');
        $battleTable->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $battleTable->setPrimaryKey(['id']);
        $battleTable->addColumn('programmerId', 'integer');
        $battleTable->addColumn('projectId', 'integer');
        $battleTable->addColumn('didProgrammerWin', 'integer');
        $battleTable->addColumn('foughtAt', 'datetime');
        $battleTable->addColumn('notes', 'text');
        $battleTable->addForeignKeyConstraint($programmerTable, ['programmerId'], ['id']);
        $battleTable->addForeignKeyConstraint($projectTable, ['projectId'], ['id']);
        $schemaManager->dropAndCreateTable($battleTable);
    }

    public function clearTables()
    {
        $schemaManager = $this->getConnection()->getSchemaManager();

        $dbPlatform = $this->getConnection()->getDatabasePlatform();
        $this->getConnection()->beginTransaction();
        foreach ($schemaManager->listTables() as $tbl) {
            $q = $dbPlatform->getTruncateTableSql($tbl->getName());
            $this->getConnection()->executeUpdate($q);
        }
        $this->getConnection()->commit();
    }

    public function populateData()
    {
        $user = new User();
        $user->username = 'weaverryan';
        $user->email = 'ryan@knplabs.com';
        $user->setPlainPassword('foo');
        $userRepo = $this->app['repository.user'];
        $userRepo->save($user);

        $project1 = new Project();
        $project1->name = 'BurningBot';
        $project1->difficultyLevel = \rand(1, 10);
        $projectRepo = $this->app['repository.project'];
        $projectRepo->save($project1);

        $project2 = new Project();
        $project2->name = 'InstaFaceTweet';
        $project2->difficultyLevel = \rand(1, 10);
        $projectRepo = $this->app['repository.project'];
        $projectRepo->save($project2);

        $project3 = new Project();
        $project3->name = 'MountBox';
        $project3->difficultyLevel = \rand(1, 10);
        $projectRepo = $this->app['repository.project'];
        $projectRepo->save($project3);

        $project4 = new Project();
        $project4->name = 'Video Game';
        $project4->difficultyLevel = \rand(1, 10);
        $projectRepo = $this->app['repository.project'];
        $projectRepo->save($project4);

        $project5 = new Project();
        $project5->name = 'Bike Shop Project';
        $project5->difficultyLevel = \rand(1, 10);
        $projectRepo = $this->app['repository.project'];
        $projectRepo->save($project5);
    }

    /**
     * @return Connection
     */
    private function getConnection()
    {
        return $this->app['db'];
    }
}
