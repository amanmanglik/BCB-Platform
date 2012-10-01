<?php
/*
  Plugin Name: Barcamp Bangalore Platform
  Plugin URI: http://barcampbangalore.org.com/platform
  Description: Provides Scheduling capabilities and Android App compatibility for Barcamp Bangalore Platform
  Version: 0.1
  Author: Aman Manglik
  Author URI: http://amanmanglik.com
  License: GPL2
 */

register_activation_hook(__FILE__, 'bcbp_plugin_activate');
register_deactivation_hook(__FILE__, 'bcbp_plugin_deactivate');


add_action('admin_menu', 'bcbp_add_admin_menu');

function bcbp_plugin_activate()
{
    add_option("bcbp_num_tracks", 6);
    add_option("bcbp_num_slots", 11);
    add_option("bcbp_category", 6);

    $TRACKS = array('Asteroids', 'Battleship', 'Contra', 'Diablo', 'Everquest', 'Fable');
    add_option("bcbp_trackdata", $TRACKS );

    $SLOTS = array();

    $SLOTS[] = array("type" => "fixed", "start" => "800", "end" => "900", "display_string" => "8:00AM - 9:00AM", "name" => "Registration");
    $SLOTS[] = array("type" => "fixed", "start" => "900", "end" => "930", "display_string" => "9:00AM - 9:30AM", "name" => "Introduction");
    $SLOTS[] = array("type" => "session", "start" => "930", "end" => "1015", "display_string" => "9:30AM - 10:15AM", "name" => "Slot 1");
    $SLOTS[] = array("type" => "session", "start" => "1030", "end" => "1115", "display_string" => "10:30AM - 11:15AM", "name" => "Slot 2");
    $SLOTS[] = array("type" => "session", "start" => "1130", "end" => "1215", "display_string" => "11:30AM - 12:15AM", "name" => "Slot 3");
    $SLOTS[] = array("type" => "fixed", "start" => "1230", "end" => "1330", "display_string" => "12:30AM - 13:30AM", "name" => "Lunch");
    $SLOTS[] = array("type" => "fixed", "start" => "1330", "end" => "1430", "display_string" => "1:30PM - 2:30PM", "name" => "Techlash");
    $SLOTS[] = array("type" => "session", "start" => "1430", "end" => "1515", "display_string" => "2:30PM - 3:15PM", "name" => "Slot 4");
    $SLOTS[] = array("type" => "session", "start" => "1530", "end" => "1615", "display_string" => "3:30PM - 4:15PM", "name" => "Slot 5");
    $SLOTS[] = array("type" => "session", "start" => "1630", "end" => "1715", "display_string" => "4:30PM - 5:15PM", "name" => "Slot 6");
    $SLOTS[] = array("type" => "fixed", "start" => "1730", "end" => "1815", "display_string" => "5:30PM - 6:15PM", "name" => "Feedback");
    
    
    add_option("bcbp_slotdata", $SLOTS);
    
}


function bcbp_plugin_deactivate()
{
    
    delete_option("bcbp_num_tracks");
    delete_option("bcbp_num_slots");
    delete_option("bcbp_category");
    delete_option("bcbp_trackdata");
    delete_option("bcbp_slotdata");
    
}




function bcbp_add_admin_menu()
{
    add_menu_page('BCB Platform Administration', 'BCB Platform Admin', 'manage_options', 'bcbp_admin', 'bcbp_admin_content_callback');
}

function bcbp_admin_content_callback()
{
    
    $NUM_TRACKS = get_option("bcbp_num_tracks");
    $NUM_SLOTS = get_option("bcbp_num_slots");
    
    $TRACKS = get_option("bcbp_trackdata");
    $SLOTS = get_option("bcbp_slotdata");
        
    ?>

    BCB Platform Settings
    
    <form>
        <?php for ($i = 0; $i < $NUM_TRACKS; $i++): ?>
        Track <?php echo $i+1; ?> <input type="text" name="track<?php echo $i; ?>" value="<?php echo $TRACKS[$i]; ?>" /><br/>
        <?php endfor;  ?>
        
        
        <br/><br/>
        <?php for ($i = 0; $i < $NUM_SLOTS; $i++): ?>
        Slot <?php echo $i+1; ?> | 
        
        Type <select name="slot-select-<?php echo $i; ?>" >
        
            <option value="fixed" <?php if ($SLOTS[$i]['type'] == "fixed") echo 'selected' ?> >Fixed</option>
            <option value="session"  <?php if ($SLOTS[$i]['type'] == "session") echo 'selected' ?> >Session</option>
        </select>  
        
        Name <input type="text" name="slot-name-<?php echo $i; ?>" value="<?php echo $SLOTS[$i]['name']; ?>" />
        Start Time <input type="number" name="slot-start-<?php echo $i; ?>"  value="<?php echo $SLOTS[$i]['start']; ?>" />
        End Time <input type="number" name="slot-end-<?php echo $i; ?>"  value="<?php echo $SLOTS[$i]['end']; ?>" />
        
        
        <br/>
        <?php endfor;  ?>
        
    </form>
    
    
    <pre>
    <?php
    
    
    print_r($SLOTS);
    print_r($TRACKS);
    
    ?>
    </pre>
    
    
    
    <?php
    
    
}

add_action("admin_enqueue_scripts", "bcbp_enqueue_admin_scripts");

function bcbp_enqueue_admin_scripts()
{
    
    
    wp_enqueue_script("bcbp_admin_script", plugin_dir_url(__FILE__)."bcbp_script.js", array('jquery'));
    
    
}




add_action("wp_ajax_bcbp_tracks_form", "bcbp_get_tracks_form");


function bcbp_get_tracks_form($hook)
{
    
    echo "TYEST".$hook;
    die();
    
}


?>
