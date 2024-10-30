<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
$aUser =  $aVars['aUser'];

$aAlerts[] = array("label" => "Name", "value" => $aUser->user_nicename, "show" => 1);
$aAlerts[] = array("label" => "Userame", "value" => $aUser->user_nicename , "show" => 1);
$aAlerts[] = array("label" => "Email", "value" => $aUser->user_email , "show" => 1);
$aAlerts[] = array("label" => "Role", "value" => implode(', ', $aUser->roles) , "show" => get_option("wps_login_show_user_role"));
$aAlerts[] = array("label" => "Registration Date", "value" => $aUser->user_registered , "show" => get_option("wps_login_show_res_date"));
$aAlerts[] = array("label" => "Ip Address", "value" => $_SERVER['REMOTE_ADDR'] , "show" => get_option("wps_login_show_ip_address"));
$aAlerts[] = array("label" => "Browser", "value" => $aVars['aBrowser']['name'] , "show" => get_option("wps_login_show_user_browser"));
$aAlerts[] = array("label" => "User Country", "value" => $aVars['aCurrUser']->country_name , "show" => get_option("wps_login_show_user_country"));
$aAlerts[] = array("label" => "User City", "value" => $aVars['aCurrUser']->city ? $aVars['aCurrUser']->city : "--" , "show" => get_option("wps_login_show_user_city"));
$aAlerts[] = array("label" => "User Timezone", "value" => $aVars['aCurrUser']->time_zone , "show" => get_option("wps_login_show_user_timezone"));


$aTo = get_option('admin_email');
$blogAlert = get_bloginfo('name');
$aSubject = "[{$blogAlert} Alert] New login found";
	
$aContent  = "<p>Hello Admin,</p>";
$aContent .= "<p>A user with username <b><i>".$aUser->user_nicename."</b></i>  has signed in to your site <b><i>{$blogAlert}</b></i>.</p><br>";
$aContent .= "<table border='0' width='100%'>";
foreach ($aAlerts as $aKey => $aAlert)
{
	if( $aAlert['show'] == 1)
	{
		$aContent .= "<tr><td style='width: 180px;padding:6px;'>".$aAlert['label']." :</td><td style='padding:6px;'>".$aAlert['value']."</td></tr>";
	}	
}
$aContent .= "</table>";
//echo $aContent ;

$headers = array('Content-Type: text/html; charset=UTF-8');
wp_mail( $aTo, $aSubject, $aContent, $headers );

?>

