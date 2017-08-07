<?php
/**
 * @Author Jan Sondre Sikveland: jan.s.sikveland@gmail.com
 */
namespace Blog;

class DatabaseHelper {
	private $servername;
	private $dbusername;
	private $dbpassword;
	private $dbname;
	/**
	 * Standard constructor
	 * 
	 * @param $servername address to connect to
	 * @param $dbusername database username
	 * @param $dbpassword database password
	 * @param $dbname database name
	 */
	public function __construct($servername, $dbusername, $dbpassword, $dbname) {
		$this->servername = $servername;
		$this->dbusername = $dbusername;
		$this->dbpassword = $dbpassword;
		$this->dbname = $dbname;
	}

	/**
	 * Constructor using .ini file
	 * 
	 * @param $filepath path to file
	 * @param $access level of access
	 */
	public static function fromIni($filepath, $access) {
		$credentials = parse_ini_file($filepath . $access . 'credentials.ini');
		return new DatabaseHelper($credentials['servername'], $credentials['dbusername'], $credentials['dbpassword'], $credentials['dbname']);
	}

	/**
	 * Connects to the database
	 * 
	 * @return the connection if possible
	 */
	public function connect() {
		$conn = new \mysqli($this->servername, $this->dbusername, $this->dbpassword, $this->dbname);
		if($conn->connect_errno) {
			return false;
		}
		return $conn;
	}

	/**
	 * Selects a blog post from the database by id
	 * 
	 * @param $id id of the blog post to be selected
	 * 
	 * @return the result of the query
	 */
	public function select($id) {
		$conn = $this->connect();

		if($conn === false) {
			return false;
		}

		$query = 'SELECT * FROM blog_post WHERE id = ?';
		$stmt = $conn->prepare($query);

		if($stmt === false) {
			$result = false;
		} else {
			$stmt->bind_param('s', $id);
			$stmt->execute();

			$result = $stmt->get_result();
		}
		$conn->close();
		return $result;
	}

	/**
	 * Selects all the blog posts from the database
	 * 
	 * @return the result of the query
	 */
	public function selectAll() {
		$conn = $this->connect();

		if($conn === false) {
			return false;
		}

		$query = 'SELECT * FROM blog_post';
		$stmt = $conn->prepare($query);

		if($stmt === false) {
			$result = false;
		} else {
			$stmt->execute();

			$result = $stmt->get_result();
		}
		$conn->close();
		return $result;
	}

	/**
	 * Updates a blog post in the database by id
	 * 
	 * @param $id id of the blog post to be updated
	 * @param $newtitle the new title of the blog post
	 * @param $newcontent the new content of the blog post
	 * 
	 * @return the result of the query
	 */
	public function update($id, $newtitle, $newcontent) {
		$conn = $this->connect();

		if($conn === false) {
			return false;
		}

		$query = 'UPDATE blog_post SET title = ?, content = ? WHERE id = ?';
		$stmt = $conn->prepare($query);

		if($stmt === false) {
			$result = false;
		} else {
			$stmt->bind_param('sss', $newtitle, $newcontent, $id);
			$result = $stmt->execute();
		}
		$conn->close();
		return $result;
	}

	/**
	 * Creates a new blog post in the database
	 * 
	 * @param $title the title of the blog post
	 * @param $content the content of the blog post
	 * 
	 * @return the result of the query
	 */
	public function insert($title, $content) {
		$conn = $this->connect();

		if($conn === false) {
			return false;
		}

		$query = 'INSERT INTO blog_post (title, content) VALUES (?, ?)';
		$stmt = $conn->prepare($query);

		if($stmt === false) {
			$result = false;
		} else {
			$stmt->bind_param('ss', $title, $content);
			$stmt->execute(); 
			$result = $conn->insert_id;
		}
		$conn->close();
		return $result;
	}

	/**
	 * Deletes a blog post from the database by id
	 * 
	 * @param $id id of the blog post to be deleted
	 * 
	 * @return the result of the query
	 */
	public function delete($id) {
		$conn = $this->connect();

		if($conn === false) {
			return false;
		}

		$query = 'DELETE FROM blog_post WHERE id = ?';
		$stmt = $conn->prepare($query);

		if($stmt === false) {
			$result = false;
		} else {
			$stmt->bind_param('s', $id);
			$result = $stmt->execute();
		}
		$conn->close();
		return $result;
	}
}