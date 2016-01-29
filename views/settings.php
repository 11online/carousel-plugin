<?php
$quote_message_array = get_option("quote_message_array");
$quote_message_array = explode("|", $quote_message_array);

echo '<div class="wrap">
	<div id="quote-settings">

	    <h2>Quote quote Settings</h2>

                <form method="post" action="">
                    <table>
										<tbody class="slideGroup"></tbody>';
										$count = count($quote_message_array);
										for($i = 0; $i <  $count; $i++) {
											$slideCount = $i + 1;
											echo '<tbody class="slideGroup"><tr><td><h3>Slide ' . $slideCount . '</h3></td></tr>';
											echo '<tr><td><label for="quote_message_array">Caption</label></td>';
					      			echo '<td><input name="quote_message_array[]" type="text" value="' . stripslashes($quote_message_array[$i]) . '"></td></tr>';
											echo '<tr class="deleteSlide"><td><a class="button button-primary">Delete This Slide</a></td></tr></tbody>';
										}
										echo '<tr><td>&nbsp;</td></tr><tr><td><a class="button button-primary" id="addSlide">Add a New Slide</a></td></tr>
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
