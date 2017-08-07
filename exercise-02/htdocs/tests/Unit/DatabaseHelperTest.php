<?php
/**
 * @Author Jan Sondre Sikveland: jan.s.sikveland@gmail.com
 */
namespace Tests\Unit;

header('Content-Type: text/html; charset=ISO-8859-1');

use Tests\TestCase;
use Blog\DatabaseHelper;

class DatabaseHelperTest extends TestCase
{
    private $_normaluser;
    private $_adminuser;
    protected function setUp() {
        $filepath = parse_ini_file('filepath.ini');
        //These tests running successfully also means DatabaseHelper::fromIni works properly
        $this->_normaluser = DatabaseHelper::fromIni($filepath['filepath'] . 'private/', 'normal');
        $this->_adminuser = DatabaseHelper::fromIni($filepath['filepath'] . '/private/', 'admin');
    }

    public function test_database_connect() {
        $conn = $this->_normaluser->connect(); //Will give an error if unsuccessful
        $conn = $this->_adminuser->connect();

        $this->assertTrue(true);

        $conn->close();
    }

    public function test_database_insert() {
        $result = $this->_adminuser->insert('test title', 'this should work as the admin user has the right privileges');
        $this->assertEquals($result, 1);

        $result = $this->_normaluser->insert('test title2', 'this should not work as the normal user does not have the right privileges');
        $this->assertFalse($result);
    }

    public function test_database_select() {
        $result = $this->_adminuser->select(1);
        $this->assertFalse($result === false);
        $fetch = mysqli_fetch_assoc($result);
        $this->assertEquals('test title', $fetch['title']);
        $this->assertEquals('this should work as the admin user has the right privileges', $fetch['content']);

        $result = $this->_normaluser->select(1);
        $this->assertFalse($result === false);
        $fetch = mysqli_fetch_assoc($result);
        $this->assertEquals('test title', $fetch['title']);
        $this->assertEquals('this should work as the admin user has the right privileges', $fetch['content']);
    }

    public function test_database_update() {
        $result = $this->_adminuser->update(1, 'test title', 'this should work as the admin user has the right privileges');
        $this->assertTrue($result);

        $result = $this->_normaluser->update(1, 'test title2', 'this should not work as the normal user does not have the right privileges');
        $this->assertFalse($result);
    }

    public function test_database_select_all() {
        $this->_adminuser->insert('test title1', 'sample text');
        $this->_adminuser->insert('test title2', 'sample text222');
        $this->_adminuser->insert('test title3', 'sample text 33333333');

        $result = $this->_adminuser->selectAll();
        $this->assertEquals(mysqli_num_rows($result), 4);

        $result = $this->_normaluser->selectAll();
        $this->assertEquals(mysqli_num_rows($result), 4);
    }

    public function test_database_delete() {
        $result = $this->_normaluser->delete(1);
        $this->assertFalse($result);

        $result = $this->_adminuser->delete(1);
        $this->assertTrue($result);
        $result = $this->_adminuser->selectAll();
        $this->assertEquals(mysqli_num_rows($result), 3);

        $result = $this->_adminuser->delete(2);
        $this->assertTrue($result);
        $result = $this->_adminuser->selectAll();
        $this->assertEquals(mysqli_num_rows($result), 2);

        $result = $this->_adminuser->delete(3);
        $this->assertTrue($result);
        $result = $this->_adminuser->selectAll();
        $this->assertEquals(mysqli_num_rows($result), 1);

        $result = $this->_adminuser->delete(4);
        $this->assertTrue($result);
        $result = $this->_adminuser->selectAll();
        $this->assertEquals(mysqli_num_rows($result), 0);
    }
}
