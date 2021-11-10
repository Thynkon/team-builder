<?php

require_once("app/models/Member.php");
require_once(".env.php");

use ByJG\DbMigration\Exception\DatabaseDoesNotRegistered;
use ByJG\DbMigration\Exception\DatabaseIsIncompleteException;
use ByJG\DbMigration\Exception\DatabaseNotVersionedException;
use ByJG\DbMigration\Exception\InvalidMigrationFile;
use ByJG\DbMigration\Exception\OldVersionSchemaException;
use ByJG\DbMigration\Migration;
use ByJG\Util\Uri;
use PHPUnit\Framework\TestCase;

class MemberTest extends TestCase
{
    private Migration $migration;

    /**
     * @throws InvalidMigrationFile
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $connectionUri = new Uri(sprintf('mysql://%s:%s@localhost/teambuilder', USERNAME, PASSWORD));

        // Create the Migration instance
        $this->migration = new Migration($connectionUri, '.');

        // Register the Database or Databases can handle that URI:
        $this->migration->registerDatabase('mysql', \ByJG\DbMigration\Database\MySqlDatabase::class);
        $this->migration->registerDatabase('maria', \ByJG\DbMigration\Database\MySqlDatabase::class);

        // Add a callback progress function to receive info from the execution
        $this->migration->addCallbackProgress(function ($action, $currentVersion, $fileInfo) {
            echo "$action, $currentVersion, ${fileInfo['description']}\n";
        });
    }

    /**
     * @throws DatabaseDoesNotRegistered
     * @throws DatabaseNotVersionedException
     * @throws InvalidMigrationFile
     * @throws DatabaseIsIncompleteException
     * @throws OldVersionSchemaException
     */
    public function setUp(): void
    {
        $this->migration->reset();
        $this->migration->up(1);
    }

    /**
     * @covers Member::all()
     */
    public function testAll()
    {
        $this->assertEquals(51, count(Member::all()));
    }

    /**
     * @covers Member::find(id)
     */
    public function testFind()
    {
        $this->assertInstanceOf(Member::class, Member::find(1));
        $this->assertNull(Member::find(1000));
    }

    /**
     * @covers Member::where(criteria)
     */
    public function testWhere()
    {
        $this->assertEquals(5, count(Member::where("role_id", 2)));
        $this->assertEquals(0, count(Member::where("role_id", 222)));
    }

    /**
     * @covers  $member->create()
     * @depends testAll
     */
    public function testCreate()
    {
        $member = Member::make(["name" => "XXX", "password" => 'XXXPa$$w0rd', "role_id" => 1]);
        $this->assertTrue($member->create());
        $this->assertFalse($member->create());
    }

    /**
     * @covers $member->save()
     */
    public function testSave()
    {
        $member = Member::find(1);
        $savename = $member->name;
        $member->name = "newname";
        $this->assertTrue($member->save());
        $this->assertEquals("newname", Member::find(1)->name);
        $member->name = $savename;
        $member->save();
    }

    /**
     * @covers $member->save() doesn't allow duplicates
     */
    public function testSaveRejectsDuplicates()
    {
        $member = Member::find(1);
        $member->name = Member::find(2)->name;
        $this->assertFalse($member->save());
    }

    /**
     * @covers $member->delete()
     */
    public function testDelete()
    {
        $member = Member::find(1);
        $this->assertFalse($member->delete()); // expected to fail because of foreign key
        $member = Member::make(["name" => "dummy", "password" => "dummy", "role_id" => 1]);
        $member->create(); // to get an id from the db
        $id = $member->id;
        $this->assertTrue($member->delete()); // expected to succeed
        $this->assertNull(Member::find($id)); // we should not find it back
    }

    /**
     * @covers Member::destroy(id)
     */
    public function testDestroy()
    {
        $this->assertFalse(Member::destroy(1)); // expected to fail because of foreign key
        $member = Member::make(["name" => "dummy", "password" => "dummy", "role_id" => 1]);
        $member->create(); // to get an id from the db
        $id = $member->id;
        $this->assertTrue(Member::destroy($id)); // expected to succeed
        $this->assertNull(Member::find($id)); // we should not find it back
    }

    /**
     * @covers $member->teams()
     */
    public function testTeams()
    {
        // member => mario
        $member = Member::find(6);
        $this->assertCount(2, $member->teams());

        $member = Member::find(1);
        $this->assertNotCount(3, $member->teams());
    }

    /**
     * @covers $member::moderators()
     */
    public function testModerators()
    {
        $this->assertCount(5, Member::moderators());
        // should fail
        $this->assertNotCount(3, Member::moderators());
    }

    /**
     * @covers Member->isCaptain(id)
     */
    public function testIsCaptain()
    {
        $member = Member::find(1);

        $this->assertTrue($member->isCaptain(2));
        // should fail
        $this->assertFalse($member->isCaptain(1));
    }

    /**
     * @covers Member::belongsToTeam(id)
     */
    public function testBelongsToTeam()
    {
        $member = Member::find(USER_ID);
        $this->assertTrue($member->belongsToTeam(3));

        $this->assertFalse($member->belongsToTeam(2));
    }

    public function testRequestInvitation()
    {
        $member = Member::find(USER_ID);
        $team = Team::find(2);
        $this->assertTrue($member->requestInvitation($team->id));
        $team = Team::find(3);
        $this->assertFalse($member->requestInvitation($team->id));
    }

    public function testNumberOfTeams()
    {
        $member = Member::find(USER_ID);
        $this->assertEquals(1, $member->numberOfTeams());
        $member = Member::find(2);
        $this->assertNotEquals(5, $member->numberOfTeams());
    }
}
