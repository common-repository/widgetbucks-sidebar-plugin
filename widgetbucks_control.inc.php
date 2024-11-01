<?php

	echo '<p style="text-align:left;"><label for="widgetbucks-title">Title:</label><br /> <input style="width: 235px;" id="widgetbucks-title" name="widgetbucks-title" type="text" value="'.$title.'" /></p>';

	//You need one of these for each option/parameter. You can use input boxes, radio buttons, checkboxes, etc.
	echo '<p style="text-align:left;"><label for="widgetbucks-parameter1">Widgetbucks Ad Code ( UID Only ):</label><br /> <input style="width: 235px;" id="widgetbucks-parameter1" name="widgetbucks-parameter1" type="text" value="'.$options['parameter1'].'" /></p>';


	echo '<input type="hidden" id="widgetbucks-submit" name="widgetbucks-submit" value="1" />';
?>