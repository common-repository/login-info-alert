<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
$page_url =  admin_url( 'admin.php?page=wps_login_info_admin_option' );



if ( isset( $_POST['wps_login_option_nonce_field'] )  && wp_verify_nonce( $_POST['wps_login_option_nonce_field'], 'wps_login_option_nonce_action' ) )
{
	if($_POST['submit'])
	{

		$aVals =  array_map( 'sanitize_text_field', wp_unslash( $_POST['val'] ) );	
		
		foreach($aVals as $aKey => $aVal)
		{
			update_option($aKey,$aVal);					
		}	
		header('location:'.$page_url);

	}
}

$aEmailOpts = array();
$aEmailOpts['wps_login_show_user_role'] = array("name" => "Show User Role", "value" => get_option("wps_login_show_user_role"));
$aEmailOpts['wps_login_show_res_date'] = array("name" => "Show Registration Date", "value" =>get_option("wps_login_show_res_date"));
$aEmailOpts['wps_login_show_ip_address'] = array("name" => "Show Ip Address", "value" =>get_option("wps_login_show_ip_address"));
$aEmailOpts['wps_login_show_user_browser'] = array("name" => "Show User Browser", "value" =>get_option("wps_login_show_user_browser"));
$aEmailOpts['wps_login_show_user_country'] = array("name" => "Show User Country", "value" =>get_option("wps_login_show_user_country"));
$aEmailOpts['wps_login_show_user_city'] = array("name" => "Show User City", "value" =>get_option("wps_login_show_user_city"));
$aEmailOpts['wps_login_show_user_timezone'] = array("name" => "Show user Timezone", "value" =>get_option("wps_login_show_user_timezone"));


?>

<h1>Login Alert Option</h1>
<form action="" method="post" enctype="multipart/form-data">
	<?php wp_nonce_field( 'wps_login_option_nonce_action', 'wps_login_option_nonce_field' ); ?>
	<table class="form-table">
		<tbody>	
			<?php foreach ($aEmailOpts as $aKey => $aEmailOpt) { ?>				
			<tr>
				<th scope="row"><?php echo __( $aEmailOpt['name'], 'wps-login-alert' ) ?></th>
				<td>
					<input type="radio" <?php if($aEmailOpt['value'] == 1) { ?> checked="checked" <?php } ?>  value="1" name="val[<?php echo $aKey; ?>]" /> Yes
					<input type="radio" <?php if($aEmailOpt['value'] == 0) { ?> checked="checked" <?php } ?>  value="0" name="val[<?php echo $aKey; ?>]" /> No
				</td>
			</tr>	
			<?php } ?>		
		</tbody>
	</table>
	<p class="submit"><input type="submit" value="<?php echo __( 'Save Changes', 'wps-login-alert' ) ?>" class="button button-primary" id="submit" name="submit"></p>
</form>