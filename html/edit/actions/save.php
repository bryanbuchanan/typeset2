<?
include "../include.php";
include "$site_root/$admin_folder/pages/includes/security.php";

// Get posted data
$data = array();
foreach ($_POST as $key => $value):
	$data[$key] = $value;
endforeach;
$data = (object) $data;

if ($data->type === "blurb"):

/* Blurb */

	if (isset($data->new)):
		$query = "INSERT INTO $data->type SET
			title=:title,
			image=:image,
			text=:text,
			tag=:tag";
		$query_data = array(
			"title" => $data->title,
			"image" => $data->image,
			"text" => $data->text,
			"tag" => $data->tag
		);	
	else:
		$query = "UPDATE $data->type SET
			title=:title,
			image=:image,
			text=:text
			WHERE id=:id";
		$query_data = array(
			"title" => $data->title,
			"image" => $data->image,
			"text" => $data->text,
			"id" => $data->id
		);	
	endif;
elseif ($data->type === "html"):

/* HTML */

	if (isset($data->new)):
		$query = "INSERT INTO $data->type SET
			text=:text,
			tag=:tag";
		$query_data = array(
			"text" => $data->text,
			"tag" => $data->tag
		);	
	else:
		$query = "UPDATE $data->type SET
			text=:text
			WHERE id=:id";
		$query_data = array(
			"text" => $data->text,
			"id" => $data->id
		);	
	endif;
elseif ($data->type === "blog"):

/* Blog */

	if (isset($data->new)):
	
		// Set post time
		date_default_timezone_set($typeset_settings->timezone);
		$time = date("h:i:s", time());
		$data->date .= " $time";

		// URN
		$urn = $typeset->urn($data->title, $data->type);

		$query = "INSERT INTO $data->type SET
			title=:title,
			urn=:urn,
			date=:date,
			image=:image,
			text=:text,
			tag=:tag";
		$query_data = array(
			"title" => $data->title,
			"urn" => $urn,
			"date" => $data->date,
			"image" => $data->image,
			"text" => $data->text,
			"tag" => $data->tag
		);
		
	else:
	
		// Set post time
		$data->date .= " $data->time";

		// URN
		$urn = $typeset->urn($data->title, $data->type, $data->original_title, $data->urn, $data->id);
		
		$query = "UPDATE $data->type SET
			title=:title,
			urn=:urn,
			date=:date,
			image=:image,
			text=:text
			WHERE id=:id";
		$query_data = array(
			"title" => $data->title,
			"urn" => $urn,
			"date" => $data->date,
			"image" => $data->image,
			"text" => $data->text,
			"id" => $data->id
		);
		
	endif;
	
elseif ($data->type === "banner"):

/* Banner */

	if (!preg_match('/^http/i', $data->url)
	and !preg_match('/^mailto:/i', $data->url)
	and !preg_match('/^javascript:/i', $data->url)
	and !preg_match('/^\//i', $data->url)
	and !empty($data->url)):
		$data->url = "http://" . $data->url;
	endif;

	if (isset($data->new)):
		$query = "INSERT INTO $data->type SET
			title=:title,
			url=:url,
			image=:image,
			text=:text,
			tag=:tag";
		$query_data = array(
			"title" => $data->title,
			"url" => $data->url,
			"image" => $data->image,
			"text" => $data->text,
			"tag" => $data->tag
		);	
	else:
		$query = "UPDATE $data->type SET
			title=:title,
			url=:url,
			image=:image,
			text=:text
			WHERE id=:id";
		$query_data = array(
			"title" => $data->title,
			"url" => $data->url,
			"image" => $data->image,
			"text" => $data->text,
			"id" => $data->id
		);	
	endif;		
	
endif;

if (!$db->run($query, $query_data)):
	$typeset->respond(array(
		"status" => "error",
		"message" => "Error updating database"
	));
else:
	$typeset->respond(array(
		"status" => "success",
		"message" => "Updates saved to database"
	));
endif;

?>