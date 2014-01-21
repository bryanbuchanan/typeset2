<?

$root = __DIR__;
$site_root = realpath(__DIR__ . '/..');

include "$root/_settings.php";
include "$root/database.php";
$db = new DB($typset_settings->database);
$admin_folder = explode("/", $root);
$admin_folder = end($admin_folder);
		
class Typset {

	// Global Variables
	public $page;

	// Initial Setup
	public function __construct() {
		
		global $typset_settings, $admin_folder;
		
		// Load page with variables
		$this->page = str_replace(".php", "", basename($_SERVER['PHP_SELF']));
		
		// Signedin variable
		if (isset($_COOKIE[$typset_settings->cookie])):
			$this->signedin = true;
		endif;
		
	}
	
	// Error Reporting
	public function error($e) {
		echo $e;
	}

/* Common Functions
--------------------------------- */

/* Merge Options */

	private function options_merge($defaults, $options) {
		if (!isset($options)):
			$options = $defaults;
		else:
			foreach ($defaults as $key => $value):
				if (!isset($options[$key])):
					$options[$key] = $value;
				endif;
			endforeach;
		endif;
		return (object) $options;
	}

/* Respond */

	public function thumb($file) {
		$file_info = pathinfo($file);
		$filename = $file_info['filename'];
		if (isset($file_info['extension'])):
			$extension = $file_info['extension'];
			$thumb = "$filename-thumb.$extension";
			return $thumb;
		endif;
	}

/* Respond */

	public function respond($message) {
		$message = json_encode($message);
		header("Content-type: application/json");
		echo $message;
		exit;
	}
	
/* HTML Data Tags */

	public function tags($data) {
		if (isset($this->signedin)):
			if (isset($data->options)):
				// Static content
				$data_string = 'data-type="'.$data->options->type.'"';
				if (isset($data->options->tag)): $data_string .= ' data-tag="'.$data->options->tag.'"'; endif;
				if (isset($data->content->id)): $data_string .= ' data-id="'.$data->content->id.'"'; endif;
				if (isset($data->options->image_width)): $data_string .= ' data-image_width="'.$data->options->image_width.'"'; endif;
				if (isset($data->options->image_height)): $data_string .= ' data-image_height="'.$data->options->image_height.'"'; endif;
				if (isset($data->options->thumb_width)): $data_string .= ' data-thumb_width="'.$data->options->thumb_width.'"'; endif;
				if (isset($data->options->thumb_height)): $data_string .= ' data-thumb_height="'.$data->options->thumb_height.'"'; endif;
			else:
				// Sequencial content
				$data_string = 'data-id="'.$data->id.'"';
			endif;
			return $data_string;
		else:
			return "";
		endif;
	}
	
/* URN Picker */

	public function urn($source, $type=null, $id=0) {
			
		global $db;
		
		// Convert source string into URN
		$urn = strtolower($source);
		$urn = preg_replace("/\&/i", "and", $urn);
		$urn = preg_replace("/\//i", "-", $urn);
		$urn = preg_replace("/[^a-zA-Z0-9\-\s_]/i", "", $urn);
		$urn = preg_replace("/^\-*/i", "", $urn);
		$urn = trim($urn);
		$urn = preg_replace("/\s+/i", "-", $urn);
		$urn = preg_replace("/\-+$/im", "", $urn);
		$urn = preg_replace("/\-+/im", "-", $urn);
		
		// Check database for conflicting URNs
		if (!is_null($type)):
		
			$query = "SELECT id FROM $type WHERE urn=:urn AND id!=:id";
			$query_data = array(
				"urn" => $urn,
				"id" => $id
			);
			$statement = $db->run($query, $query_data);
			$results = $statement->rowCount();
		
			// Add suffix if there's a conflict
			if ($results > 0):
				$random = rand(0, 999);
				$urn .= "-$random";
			endif;
		
		endif;

		return $urn;

	}
	
/* Markdown Formatter */

	public function markdown_format($text) {
		global $root;
		require_once("$root/library/markdown/markdown.php");
		$text = preg_replace("#\r\n?#", "\n", $text); // Normalize line breaks
		$text = preg_replace("#([^\n])\n([^\n])#", "$1  \n$2", $text); // Respect line breaks
		$text = preg_replace('#<*([_a-z0-9-\.]+@[_a-z0-9-\.]+\.[a-z]{2,3})>*(\s|$)#i', '<$1>$2', $text); // Detect emails
		$text = Markdown($text);
		return $text;
	}
	
/* Print Content */

	private function render_content($content, $options) {
		
		global $admin_folder;
		
		// Combine for optional formatting
		$data = (object) array(
			"options" => $options,
			"content" => $content
		);	
		
		if ($options->format === "html"):

			/* Markdown formatting */
			if ($options->type === "blurb"):
				$content->text = $this->markdown_format($content->text);
			elseif ($options->type === "blog" and isset($options->mode) and $options->mode === "post"):
				$content->text = $this->markdown_format($content->text);
			elseif ($options->type === "blog"):
				foreach ($content as $key => $value):
					$content[$key]->text = $this->markdown_format($content[$key]->text);
				endforeach;
			endif;
			
			if (isset($options->template)):
				$template_file = "$admin_folder/templates/$options->template.php";
			else:
				$template_file = "$admin_folder/templates/$options->type.php";
			endif;
			if (file_exists($template_file)):
				include $template_file;
			else:
				$this->error("Missing html template: $template_file");
			endif;
		elseif ($options->format === "json"):
			$data = json_encode($data);
			echo $data;
		else:
			print_r($data);
		endif;
		
	}
	
/* Truncate */

	private function truncate($content, $truncate) {
		if (strlen($content) > $truncate and $truncate != 0):
			$content = substr($content, 0, $truncate);
			$content = substr($content, 0, strrpos($content, ' '));
			$content .= "&hellip;";
		endif;
		return $content;
	}

/* Image Resizing */

	public function resize_image($options=array()) {

		global $root, $typset_settings;
		
		// Normalize data
		$options["width"] = $options["width"] * 1;
		$options["height"] = $options["height"] * 1;

		// Get image data
		$image = $options["original"];
		$path_info = pathinfo($image);
		$extension = strtolower($path_info['extension']);
		$image_stats = GetImageSize($image); 
		$original_width = $image_stats[0]; 
		$original_height = $image_stats[1];
		if (!$original_width or !$original_height):
			$original_width = 500;
			$original_height = 500;
		endif;
	
		// Calculate missing dimensions
		if ($original_width >= $original_height):
			$ratio = $options["width"] / $original_width;
			$options["height"] = round($original_height * $ratio);
		else:
			$ratio = $options["height"] / $original_height;
			$options["width"] = round($original_width * $ratio);
		endif;
	
		// Create source image
		if ($extension === "jpg"):
			$source_image = imagecreatefromjpeg($image);
		elseif ($extension === "gif"):
			$source_image = imagecreatefromgif($image);
		elseif ($extension === "png"):
			$source_image = imagecreatefrompng($image);
		endif;

		// Scale image
		$destination_image = imagecreatetruecolor($options["width"], $options["height"]); 
		imagecopyresampled($destination_image, $source_image, 0, 0, 0, 0, $options["width"], $options["height"], imagesx($source_image), imagesy($source_image)); 

		// Save image
		if ($extension === "jpg"):
			imagejpeg($destination_image, $options["destination"], $typset_settings->image_quality);
		elseif ($extension === "gif"):
			imagegif($destination_image, $options["destination"]);
		elseif ($extension === "png"):
			imagepng($destination_image, $options["destination"]);
		endif;

		// Clear memory
		imagedestroy($destination_image); 
		imagedestroy($source_image);
				
	}
	
/* Get Post Title */

	public function post_title($type) {
		global $db;
		$topic = $_GET['topic'];
		$query = "SELECT title FROM $type WHERE urn=:urn LIMIT 1";
		$query_data = array("urn" => $topic);
		$response = $db->run($query, $query_data);
		return $response->fetch()->title;
	}	
	
/* Blurb
--------------------------------- */

	public function blurb($options=null) {

		global $db, $typset_settings;

		// Define defaults
		$defaults = array(
			"type" => "blurb",
			"id" => "",
			"tag" => "",
			"image_width" => 1000,
			"image_height" => 1000,
			"format" => "html"
		);

		// Process options
		$options = $this->options_merge($defaults, $options);
		
		// Get content from database
		$query = "SELECT title,text,id,image FROM $options->type WHERE tag=:tag LIMIT 1";
		$query_data = array("tag" => $options->tag);
		$statement = $db->run($query, $query_data);
		$results = $statement->rowCount();
		$response = $statement->fetch();
		
		if ($results > 0):
								
			// Build response
			if (!is_null($response->image)):
				$image = "/$typset_settings->content_folder/$response->image";
			else:
				$image = $response->image;
			endif;
			$content = (object) array(
				"title" => $response->title,
				"text" => $response->text,
				"id" => $response->id,
				"image" => $image
			);
		
		else:
		
			// Dummy content
			$content = (object) array(
				"title" => "Nothing Here Yet",
				"text" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
			);
			
		endif;
	
		// Render content
		$this->render_content($content, $options);
								
	}
	
/* HTML
--------------------------------- */

	public function html($options=null) {

		global $db;

		// Define defaults
		$defaults = array(
			"type" => "html",
			"id" => "",
			"tag" => "",
			"format" => "html"
		);

		// Process options
		$options = $this->options_merge($defaults, $options);
		
		// Get content from database
		$query = "SELECT text,id FROM $options->type WHERE tag=:tag LIMIT 1";
		$query_data = array("tag" => $options->tag);
		$statement = $db->run($query, $query_data);
		$results = $statement->rowCount();
		$response = $statement->fetch();
		
		if ($results > 0):
								
			// Build response
			$content = (object) array(
				"text" => $response->text,
				"id" => $response->id
			);
		
		else:
		
			// Dummy content
			$content = (object) array(
				"text" => "HTML code goes here"
			);
			
		endif;
	
		// Render content
		$this->render_content($content, $options);
								
	}	
	
/* Blog
--------------------------------- */	
	
	public function blog($options=null) {
	
		global $db, $typset_settings;
		
		// Define defaults
		$defaults = array(
			"type" => "blog",
			"title" => "Latest News",
			"id" => "",
			"tag" => "",
			"truncate" => 0,
			"format" => "html",
			"items" => 10,
			"sort" => "date",
			"order" => "DESC",
			"scope" => "past",
			"image_width" => 1000,
			"image_height" => 1000,
			"thumb_width" => 200,
			"thumb_height" => 200,
			"page" => "post"
		);
		
		// Process options
		$options = $this->options_merge($defaults, $options);
				
		// Paging
		$paging_name = (!empty($options->id) ? $options->id."_page" : "page");
		if (isset($_GET[$paging_name])):
			$$paging_name = $_GET[$paging_name];
		else:
			$$paging_name = 1;
		endif;
		$options->offset = $$paging_name * $options->items - $options->items;
		$options->paging_name = $paging_name;
	
		// Scope
		$today = date("Y-m-d");
		if ($options->scope === "past"):
			if (isset($this->signedin)):
				$scope = "date>=:today OR date>='0000-00-00'";
			else:
				$scope = "date<=:today";			
			endif;
		elseif ($options->scope === "future"):
			$scope = "date>=:today";
		elseif ($options->scope === "all"):
			$scope = "date>=:today OR date>='0000-00-00'";
		endif;
			
		// Get content from database
		$query = "SELECT title,date,text,id,urn,image FROM $options->type WHERE tag=:tag AND $scope ORDER BY $options->sort $options->order LIMIT $options->offset, $options->items";
		$query_data = array(
			"tag" => $options->tag,
			"today" => $today
		);
		$response = $db->run($query, $query_data);
		$options->total = $response->rowCount();
		$content = (array) $response->fetchAll();

		// Get info for paging from database
		$query = "SELECT id FROM $options->type WHERE tag=:tag AND date<=:today";
		$query_data = array(
			"tag" => $options->tag,
			"today" => $today
		);
		$response = $db->run($query, $query_data);
		$total_items = $response->rowCount();
	
		if ($total_items > $options->offset + $options->items):
			$next_page = $$paging_name + 1;
			$options->next_page = "?$options->paging_name=$next_page";
		endif;
		if ($options->offset > 0):
			$prev_page = $$paging_name - 1;
			$options->prev_page = "?$options->paging_name=$prev_page";
		endif;

		// Build response
		foreach ($content as $post):
	
			// Image paths
			if (!is_null($post->image)):
				$post->image = "/$typset_settings->content_folder/$post->image";
				$post->thumb = "/$typset_settings->content_folder/" . $this->thumb($post->image);
			else:
				$image = $post->image;
			endif;
	
			// Truncate
			$post->text = $this->truncate($post->text, $options->truncate);

		endforeach;
		
		// Render content
		$this->render_content($content, $options);
		
	}
	
/* Blog Post
--------------------------------- */	
	
	public function blogpost($options=null) {
	
		global $db, $typset_settings;
		
		// Define defaults
		$defaults = array(
			"type" => "blog",
			"mode" => "post",
			"title" => "",
			"id" => "",
			"tag" => "",
			"format" => "html",
			"image_width" => 1000,
			"image_height" => 1000,
			"thumb_width" => 200,
			"thumb_height" => 200,
			"template" => "blogpost"
		);
		
		// Process options
		$options = $this->options_merge($defaults, $options);
		
		// No topic
		if (!isset($_GET['topic'])):
			echo "No topic found";
			return false;
		endif;
		
		$topic = $_GET['topic'];
			
		// Get content from database
		$query = "SELECT title,date,text,id,urn,image FROM $options->type WHERE tag=:tag AND urn=:urn LIMIT 1";
		$query_data = array(
			"tag" => $options->tag,
			"urn" => $topic
		);
		$response = $db->run($query, $query_data);
		$options->total = $response->rowCount();
		$post = $response->fetch();
		
		// No matches
		if ($options->total < 1):
			echo "Article not found";
			return false;
		endif;		
				
		// Image paths
		if (!is_null($post->image)):
			$post->image = "/$typset_settings->content_folder/$post->image";
			$post->thumb = "/$typset_settings->content_folder/" . $this->thumb($post->image);
		else:
			$image = $post->image;
		endif;
						
		// Render content
		$this->render_content($post, $options);
		
	}	
	
/* Banner
--------------------------------- */	
	
	public function banner($options=null) {
	
		global $db, $typset_settings;
		
		// Define defaults
		$defaults = array(
			"type" => "banner",
			"title" => "Banners",
			"id" => "",
			"tag" => "",
			"format" => "html",
			"items" => 50,
			"sort" => "id",
			"order" => "DESC",
			"image_width" => 1000,
			"image_height" => 1000
		);
		
		// Process options
		$options = $this->options_merge($defaults, $options);
	
		// Get content from database
		$query = "SELECT id,image,title,text,url FROM $options->type WHERE tag=:tag ORDER BY $options->sort $options->order LIMIT $options->items";
		$query_data = array("tag" => $options->tag);
		$response = $db->run($query, $query_data);
		$options->total = $response->rowCount();
		$content = (array) $response->fetchAll();

		// Build response
		foreach ($content as $post):
		
			// Image paths
			if (!is_null($post->image)):
				$post->image = "/$typset_settings->content_folder/$post->image";
			else:
				$image = $post->image;
			endif;

		endforeach;
		
		// Render content
		$this->render_content($content, $options);
		
	}	
	
}

// Page Setup
$typset = new Typset();
	
?>