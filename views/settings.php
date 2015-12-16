<?php
$carousel_image_array = get_option("carousel_image_array");
$carousel_image_array = explode("|", $carousel_image_array);
$carousel_message_array = get_option("carousel_message_array");
$carousel_message_array = explode("|", $carousel_message_array);
$carousel_height = get_option("carousel_height");

echo '<div class="wrap">
	<div id="carousel-settings">

	    <h2>Carousel Settings</h2>

                <form method="post" action="">
                    <table>
										<tbody class="slideGroup"></tbody>';
										$count = count($carousel_image_array);
										for($i = 0; $i <  $count; $i++) {
											$slideCount = $i + 1;
											echo '<tbody class="slideGroup"><tr><td><h3>Slide ' . $slideCount . '</h3></td></tr>';
											echo '<tr><td><label for="carousel_image_array">Image Url</label></td>';
					      			echo '<td><input class="slide' . $slideCount . '" name="carousel_image_array[]" type="text" value="' . stripslashes($carousel_image_array[$i]) . '"><input class="upload_image_button button" id="slide' . $slideCount . '" type="button" value="Upload Image" /></td></tr>';
											echo '<tr><td><label for="carousel_message_array">Caption</label></td>';
					      			echo '<td><input name="carousel_message_array[]" type="text" value="' . stripslashes($carousel_message_array[$i]) . '"></td></tr>';
											echo '<tr class="deleteSlide"><td><a class="button button-primary">Delete This Slide</a></td></tr></tbody>';
										}
										echo '<tr><td>&nbsp;</td></tr><tr><td><a class="button button-primary" id="addSlide">Add a New Slide</a></td></tr>';
										echo '<tr><td><h3>General Settings</h3></td></tr><tr>
                        <td><label for="carousel_height">Height in pixels</label></td>
                        <td><input type="number" name="carousel_height" id="carousel_height" value="';
                        if($carousel_height) {
                            echo stripslashes($carousel_height);
                        }
                        echo '"></td>
                    </table>';
                    submit_button();
                echo '</form>
	</div>
	<div id="messages">';
        if(isset($messages)) {
            echo $messages;
        }
        echo '</div>
</div><!-- .wrap -->';
