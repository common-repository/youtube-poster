<div class="wrap">

	<?php include 'dd.php'; ?>

	<div id="icon-plugins" class="icon32"></div>
	<h2>YouTube Poster &raquo; Player Settings</h2>

	<?php
	
	if (isset($_POST['width']))
	{
		$errors = false;
	
		foreach ($_POST as $k => $v)
		{
			if ($k != 'theme')
			{
				if (!ctype_digit($v))
					$errors = true;
				else
					$wpdb->query("update ".$wpdb->prefix."dd_ytp set `value`='$v' where `variable`='$k'");
			}
			else
			{
				if ($v != 'dark' && $v != 'light')
					$errors = true;
				else
					$wpdb->query("update ".$wpdb->prefix."dd_ytp set `value`='$v' where `variable`='$k'");
			}
		}
		
		if ($errors)
			echo '<div class="error"><p>Not all settings were saved, an invalid setting selection was made.</p></div>';
		else	
			echo '<div class="updated"><p>Your settings have been updated.</p></div>';
	}
	
	$rows = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."dd_ytp");
	
	foreach ($rows as $k => $v)
		${$v->variable} = $v->value;

	?>

	<form method="post">

	<table class="form-table">
	
	<tr valign="top">
	<th scope="row">Width</th>
	<td><input type="text" name="width" value="<?php echo $width; ?>" class="regular-text" /></td>
	</tr>
	
	<tr valign="top">
	<th scope="row">Height</th>
	<td><input type="text" name="height" value="<?php echo $height; ?>" class="regular-text" /></td>
	</tr>
	
	<tr valign="top">
	<th scope="row">Auto-hide controls</th>
	<td>
	<select name="autohide">
	<option value="0"<?php if ($autohide == '0') echo ' selected="selected"'; ?>>No</option>
	<option value="1"<?php if ($autohide == '1') echo ' selected="selected"'; ?>>Yes</option>
	<option value="2"<?php if ($autohide == '2') echo ' selected="selected"'; ?>>Fade out progress bar</option>
	</select>
	</td>
	</tr>
	
	<tr valign="top">
	<th scope="row">Auto-play videos</th>
	<td>
	<select name="autoplay">
	<option value="0"<?php if ($autoplay == '0') echo ' selected="selected"'; ?>>No</option>
	<option value="1"<?php if ($autoplay == '1') echo ' selected="selected"'; ?>>Yes</option>
	</select>
	</td>
	</tr>
	
	<tr valign="top">
	<th scope="row">Show controls</th>
	<td>
	<select name="controls">
	<option value="0"<?php if ($controls == '0') echo ' selected="selected"'; ?>>No</option>
	<option value="1"<?php if ($controls == '1') echo ' selected="selected"'; ?>>Yes</option>
	</select>
	</td>
	</tr>
	
	<tr valign="top">
	<th scope="row">Show fullscreen button</th>
	<td>
	<select name="fs">
	<option value="0"<?php if ($fs == '0') echo ' selected="selected"'; ?>>No</option>
	<option value="1"<?php if ($fs == '1') echo ' selected="selected"'; ?>>Yes</option>
	</select>
	</td>
	</tr>
	
	<tr valign="top">
	<th scope="row">Enable HD playback</th>
	<td>
	<select name="hd">
	<option value="0"<?php if ($hd == '0') echo ' selected="selected"'; ?>>No</option>
	<option value="1"<?php if ($hd == '1') echo ' selected="selected"'; ?>>Yes</option>
	</select>
	</td>
	</tr>
	
	<tr valign="top">
	<th scope="row">Loop video</th>
	<td>
	<select name="loop">
	<option value="0"<?php if ($loop == '0') echo ' selected="selected"'; ?>>No</option>
	<option value="1"<?php if ($loop == '1') echo ' selected="selected"'; ?>>Yes</option>
	</select>
	</td>
	</tr>
	
	<tr valign="top">
	<th scope="row">Hide YouTube button</th>
	<td>
	<select name="modestbranding">
	<option value="0"<?php if ($modestbranding == '0') echo ' selected="selected"'; ?>>No</option>
	<option value="1"<?php if ($modestbranding == '1') echo ' selected="selected"'; ?>>Yes</option>
	</select>
	</td>
	</tr>
	
	<tr valign="top">
	<th scope="row">Show related videos</th>
	<td>
	<select name="rel">
	<option value="0"<?php if ($rel == '0') echo ' selected="selected"'; ?>>No</option>
	<option value="1"<?php if ($rel == '1') echo ' selected="selected"'; ?>>Yes</option>
	</select>
	</td>
	</tr>
	
	<tr valign="top">
	<th scope="row">Show title and uploader</th>
	<td>
	<select name="showinfo">
	<option value="0"<?php if ($showinfo == '0') echo ' selected="selected"'; ?>>No</option>
	<option value="1"<?php if ($showinfo == '1') echo ' selected="selected"'; ?>>Yes</option>
	</select>
	</td>
	</tr>
	
	<tr valign="top">
	<th scope="row">Show search box</th>
	<td>
	<select name="showsearch">
	<option value="0"<?php if ($showsearch == '0') echo ' selected="selected"'; ?>>No</option>
	<option value="1"<?php if ($showsearch == '1') echo ' selected="selected"'; ?>>Yes</option>
	</select>
	</td>
	</tr>
	
	<tr valign="top">
	<th scope="row">Theme</th>
	<td>
	<select name="theme">
	<option value="dark"<?php if ($theme == 'dark') echo ' selected="selected"'; ?>>Dark</option>
	<option value="light"<?php if ($theme == 'light') echo ' selected="selected"'; ?>>Light</option>
	</select>
	</td>
	</tr>
	
	</table>

	<p class="submit">
	<input type="submit" value="Update Settings" class="button-primary" />
	</p>

	</form>

</div>