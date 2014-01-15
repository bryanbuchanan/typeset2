<?
include "../include.php";
include "$site_root/$admin_folder/pages/includes/security.php";

// Get posted data
$data = [];
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

	$urn = $typset->urn($data->title, $data->type, 0);

	if (isset($data->new)):
		date_default_timezone_set('America/Los_Angeles');
		$date = date("Y-m-d h:i:s", time());
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
			"date" => $date,
			"image" => $data->image,
			"text" => $data->text,
			"tag" => $data->tag
		);	
	else:
		$query = "UPDATE $data->type SET
			title=:title,
			urn=:urn,
			image=:image,
			text=:text
			WHERE id=:id";
		$query_data = array(
			"title" => $data->title,
			"urn" => $urn,
			"image" => $data->image,
			"text" => $data->text,
			"id" => $data->id
		);	
	endif;
	
elseif ($data->type === "banner"):

/* Banner */

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
	$typset->respond(array(
		"status" => "error",
		"message" => "Error updating database"
	));
else:
	$typset->respond(array(
		"status" => "success",
		"message" => "Updates saved to database"
	));
endif;

?>