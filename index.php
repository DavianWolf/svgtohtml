<?php
	$step = 1;
	
	if ( isset($_POST['filename']) && isset($_POST['mapname']) && file_exists($_POST['filename'])) {

		$map_name = $_POST['mapname'];
		$file_name = $_POST['filename'];

		$svg = simplexml_load_file( $file_name );
		$map = "<map name='{$map_name}'>\n";
		$counter = 0;

		foreach ($svg->path as $path) {

		 	$attributes = $path->attributes();
		 	$str_path = $attributes['d'];
		 	$arr_path = explode(' ', trim($str_path));

		 	$area = "\t<area shape='poly' title='{$map_name}" . $counter . "' alt='{$map_name}" . $counter++ . "' href='#' coords='";

		 	$coords = '';

		 	foreach ($arr_path as $value) {
		 		if ( is_numeric($value) ) {
		 			$coords .= round($value) . ',';
		 		}
		 	}

		 	$coords = rtrim($coords, ',');

		 	$area .= $coords . "' >\n";

		 	$map .= $area;
		}

		$map .= "</map>";

		
		$step = 2;

	}
?>

<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
	<script type="text/javascript" src="jquery.maphilight.min.js"></script>
	<script type="text/javascript">$(function() {
			$('.map').maphilight({fade: false});
		});</script>
</head>
<body>

	<?php if ($step == 1): ?>

		<form method='post'>
			<input type="text" name='filename' placeholder="Filename SVG">* <br />
			<input type="text" name='png' placeholder="Filename PNG">* <br />
			<input type="text" name='mapname' placeholder="Map name">* <br />
			<input type="text" name='width' placeholder="Width"> <br />
			<input type="submit" value="Generate">
		</form>

	<?php else: ?>

		<img class="map" src="<?php print $_POST['png'] ?>" width="<?php print $_POST['width'] ?>" alt="<?php print $map_name ?>" usemap="#<?php print $map_name ?>" style="opacity: 0; position: absolute; left: 0px; top: 0px; padding: 0px; border: 0px; ">

		<?php print $map ?>

		<textarea rows='50' cols='100'>">
		<?php print $map ?>
		</textarea>

	<?php endif; ?>


</body>