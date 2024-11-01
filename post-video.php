<div class="wrap">

	<?php include 'dd.php'; ?>

	<div id="icon-plugins" class="icon32"></div>
	<h2>YouTube Poster &raquo; Post Video</h2>

	<?php
	
	function slug ($str)
	{
		$str = strtolower(trim($str));
		$str = preg_replace('/[^a-z0-9-]/', '-', $str);
		$str = preg_replace('/-+/', "-", $str);

		return $str;
	}

	if (isset($_POST['url']))
	{
		if (!ctype_digit($_POST['cat']))
		{
			echo '<div class="error"><p>You must select a post category.</p></div>';
		}
		else
		{	
			// get youtube video id		
			$url = trim($_POST['url']);
			parse_str( parse_url( $url, PHP_URL_QUERY ) );
			// video id = $v
			
			if (!empty($v))
			{
				// get the video info via rss and dom
				$url = "http://gdata.youtube.com/feeds/api/videos/". $v;
				$doc = new DOMDocument;
				$doc->load($url);
				
				// set the variables for the video info
				$title = $doc->getElementsByTagName("title")->item(0)->nodeValue;
				$desc = '[dd_ytp v="'.$v.'"]<br /><br />'.$doc->getElementsByTagName("description")->item(0)->nodeValue;
				$tags = strtolower($doc->getElementsByTagName("keywords")->item(0)->nodeValue);
				$thumb = "http://img.youtube.com/vi/$v/0.jpg";
				$thumb_ext = end(explode(".", $thumb));
				$cat = $_POST['cat'];
				
				// create post object
				$my_post = array(
					'post_title' => $title,
					'post_content' => $desc,
					'post_status' => 'publish',
					'post_category' => array($cat),
					'tags_input' => $tags,
					'post_author' => 1
				);

				// insert the post into the database
				$post_id = wp_insert_post($my_post);
				
				// copy the thumbnail to our server
				$upload_dir = wp_upload_dir();
				$thumb_name = slug($title) . '-' . time() . '.' . $thumb_ext;
				$thumb_file = $upload_dir['path'] . '/' . $thumb_name;
				copy($thumb, $thumb_file);
				
				// insert the attachment into the db
				$wp_filetype = wp_check_filetype(basename($thumb_file), null);
				$attachment = array(
					'post_mime_type' => $wp_filetype['type'],
					'post_title' => $thumb_name,
					'post_content' => '',
					'post_status' => 'inherit'
				);
				$attach_id = wp_insert_attachment($attachment, $thumb_file, $post_id);
				
				// add post meta for the thumbnail id
				add_post_meta($post_id, '_thumbnail_id', $attach_id);
				
				echo '<div class="updated"><p>The video <b>'.htmlspecialchars($title, ENT_QUOTES).'</b> has been posted.</p></div>';
			}
			else
			{
				echo '<div class="error"><p>You must enter a video URL.</p></div>';
			}
		}
	}

	?>

	<form method="post">

	<table class="form-table">
	
	<tr valign="top">
	<th scope="row">YouTube video URL</th>
	<td><input type="text" name="url" value="" class="regular-text" /></td>
	</tr>
	
	<tr valign="top">
	<th scope="row">Post category</th>
	<td><?php wp_dropdown_categories('hide_empty=0&orderby=name'); ?></td>
	</tr>
	
	</table>

	<p class="submit">
	<input type="submit" value="Post Video" class="button-primary" />
	</p>

	</form>

</div>