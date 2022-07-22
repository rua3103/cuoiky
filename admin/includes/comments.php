<?php  
class comment{

	//DB Stuff
	private $conn;
	private $table = "blog_comment";

	//Blog Comment Properties
	public $n_blog_comment_id;
	public $n_blog_comment_parent_id;
	public $n_blog_post_id;
	public $v_comment_author;
	public $v_comment_author_email;
	public $v_comment;
	public $d_date_created;
	public $d_time_created;
			
	//Constructor with DB
	public function __construct($db){
		$this->conn = $db;
	}

	//Read multi records
	public function read(){
		$sql = "SELECT * FROM $this->table";

		$stmt = $this->conn->prepare($sql);
		$stmt->execute();

		return $stmt;
	}

	//Read multi records have n_blog_post_id
	public function read_single_blog_post(){
		$sql = "SELECT * FROM $this->table 
				WHERE n_blog_post_id = :get_id AND n_blog_comment_parent_id = 0";

		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':get_id',$this->n_blog_post_id);
		$stmt->execute();

		return $stmt;
	}

	//Read multi records have n_blog_post_id
	public function read_single_blog_post_reply(){
		$sql = "SELECT * FROM $this->table 
				WHERE n_blog_comment_parent_id = :get_blog_comment_id";

		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':get_blog_comment_id',$this->n_blog_comment_id);
		$stmt->execute();

		return $stmt;
	}

	//Read one record
	public function read_single(){
		$sql = "SELECT * FROM $this->table 
				WHERE n_blog_comment_id = :get_id";

		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':get_id',$this->n_blog_comment_id);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		//Set Properties
		$this->n_blog_comment_id = $row['n_blog_comment_id'];
		$this->n_blog_comment_parent_id = $row['n_blog_comment_parent_id'];
		$this->n_blog_post_id = $row['n_blog_post_id'];
		$this->v_comment_author = $row['v_comment_author'];
		$this->v_comment_author_email = $row['v_comment_author_email'];
		$this->v_comment = $row['v_comment'];
		$this->d_date_created = $row['d_date_created'];
		$this->d_time_created = $row['d_time_created'];	
	}

	//Create Comment
	public function create(){
		//Create query
		$query = "INSERT INTO $this->table
		          SET n_blog_comment_parent_id = :blog_comment_parent_id,
		          	  n_blog_post_id = :blog_post_id,
		          	  v_comment_author = :comment_author,
		          	  v_comment_author_email = :comment_author_email,
		          	  v_comment = :comment,
		          	  d_date_created = :date_create,
		          	  d_time_created = :time_create";
		          	  
		//Prepare statement
		$stmt = $this->conn->prepare($query);

		//Clean data
		$this->v_comment_author = htmlspecialchars(strip_tags($this->v_comment_author));
		$this->v_comment_author_email = htmlspecialchars(strip_tags($this->v_comment_author_email));
		$this->v_comment = htmlspecialchars(strip_tags($this->v_comment));
		
		//Bind data
		$stmt->bindParam(':blog_comment_parent_id',$this->n_blog_comment_parent_id);
		$stmt->bindParam(':blog_post_id',$this->n_blog_post_id);
		$stmt->bindParam(':comment_author',$this->v_comment_author);
		$stmt->bindParam(':comment_author_email',$this->v_comment_author_email);
		$stmt->bindParam(':comment',$this->v_comment);
		$stmt->bindParam(':date_create',$this->d_date_created);
		$stmt->bindParam(':time_create',$this->d_time_created);
		
		//Execute query
		if($stmt->execute()){
			return true;
		}
		//Print error if something goes wrong
		printf("Error: %s. \n", $stmt->error);
		return false;
	}

	//Delete comment
	public function delete(){

		//Create query
		$query = "DELETE FROM $this->table
		          WHERE n_blog_comment_id = :get_id";
		
		//Prepare statement
		$stmt = $this->conn->prepare($query);

		//Clean data
		$this->n_blog_comment_id = htmlspecialchars(strip_tags($this->n_blog_comment_id));

		//Bind data
		$stmt->bindParam(':get_id',$this->n_blog_comment_id);

		//Execute query
		if($stmt->execute()){
			return true;
		}

		//Print error if something goes wrong
		printf("Error: %s. \n", $stmt->error);
		return false;

	}
}
?>

