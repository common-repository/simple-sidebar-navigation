<?php
add_action('admin_menu', 'simple_sidenav_menu');

function simple_sidenav_menu() {
  add_options_page('Simple SideNav Options', 'Simple SideNav', 'manage_options', 'ssn_general_settings', 'simple_sidenav_options');
}

add_action('admin_init', 'simple_sidenav_register_settings');
function simple_sidenav_register_settings()
{
    register_setting('ssn_general_settings', 'ssn_general_settings', 'ssn_settings_validate');
}

function ssn_settings_validate($input)
{
    $newInput['dropdown_css'] = (isset($input['dropdown_css'])) ? $input['dropdown_css'] : false;
    $newInput['custom_css'] = (isset($input['custom_css'])) ? $input['custom_css'] : false;
    $newInput['blog_post_links'] = (isset($input['blog_post_links'])) ? $input['blog_post_links'] : false;
    $newInput['target_attr'] = (isset($input['target_attr'])) ? $input['target_attr'] : false;

    return $newInput;
}


function simple_sidenav_options() {
   
   if (isset($_POST['ssn_submit'])):  
     update_option('dropdown_css', $_POST['dropdown_css']);
	 update_option('custom_css', $_POST['custom_css']); 
	 update_option('blog_post_links', $_POST['blog_post_links']); 
	 update_option('target_attr', $_POST['target_attr']); 

     echo '<div id="message" class="updated fade"><p>Option Saved!</p>';  
     endif;  

        $opt = get_option('ssn_general_settings');

     if ($opt['dropdown_css']) {
		 $dropdown_css = ' checked="checked"';  
     } else {  
         $dropdown_css = '';  
     } 
	 
	 if ($opt['blog_post_links']) {
     	$blog_post_links = ' checked="checked"';  
     } else {  
         $blog_post_links = '';  
     }
	 
	 if ($opt['custom_css']) {
     	$custom_css = $opt['custom_css'];
     } else {  
         $custom_css = '';  
     }
	 
	 if ($opt['target_attr']) {
     	$target_attr = ' checked="checked"';  
     } else {  
         $target_attr = '';  
     }  
	
  echo '<div class="wrap">';
  echo '<h2>Plugin Settings: Simple Sidebar Navigation</h2>';
  ?>
  <form method="post" action="options.php">
<?php
    wp_nonce_field('update-options');
    settings_fields('ssn_general_settings');
    do_settings_sections('ssn_general_settings');
	?>
  <table class="form-table">
    <tr valign="bottom"> 
      <th scope="row">Default Suckerfish CSS</th>
      <td><input type="checkbox" name="ssn_general_settings[dropdown_css]" value="1"<?php echo $dropdown_css;?> /><br /><small><?php echo 'Default Suckerfish CSS file: '. plugins_url().'/simple-sidebar-navigation/suckerfish.css';?></small></td>
    </tr>
    <tr valign="middle">
      <th scope="row">Custom Dropdown Menu CSS</th>
      <td><input type="text" name="ssn_general_settings[custom_css]" size="100" value="<?php echo $custom_css; ?>">
        <br>
        <small>Enter path to your custom suckerfish/dropdown menus CSS file, if 
        it's not included into your primary CSS.</small></td>
    </tr>
    <tr valign="bottom"> 
      <th scope="row">Add Posts Into Navigation Selection List</th>
      <td><input type="checkbox" name="ssn_general_settings[blog_post_links]" value="1"<?php echo $blog_post_links;?> />
	  <br />
        <small>Only <strong>pages</strong> added by default to the navigation 
        selection list.</small> </td>
    </tr>
	<tr valign="bottom"> 
      <th scope="row">Custom Links Target Attribute</th>
      <td><input type="checkbox" name="ssn_general_settings[target_attr]" value="1"<?php echo $target_attr;?> /><br /><small><?php echo 'Adds a target attribute option for custom navigation links (i.e. target="_blank").<br /><em>Note: target attribute is not valid with some DOCTYPEs like XHTLM 1.0 Strict.</em>';?></small></td>
    </tr>
  </table>
	
	<input type="hidden" name="ssn_general_settings[action]" value="update" />
	<input type="hidden" name="ssn_general_settings[page_options]" value="dropdown_css,custom_css,blog_post_links,target_attr" />
	
	<p class="submit">
	<input name="ssn_general_settings[ssn_submit]" type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>
	
	</form>

  <?php
  echo '</div>';
}