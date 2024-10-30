<?php
/**
 * Plugin Name: Login Info Alert
 * Plugin URI:  http://webplanetsoft.com/plugins/login-alert/
 * Description: Admin get an email after every login
 * Version: 1.0.0
 * Author: Web Planet Soft
 * Author URI:  http://webplanetsoft.com
 */

 
if ( ! defined( 'ABSPATH' ) ) {
	die("You can't access this file directly"); // disable direct access
} 

class WPS_LOGIN_INFO
{		
	public $aParams;
	public function __construct()
	{
		global $wpdb;		
		add_action( 'admin_menu', array($this, 'wps_login_info_admin_menu'));
		add_action('wp_login',array($this, 'wps_wp_login_info'), 10, 2);
	}

	public function wps_login_info_admin_menu()
	{
		add_menu_page(__( 'Login Alert Option', 'wps-login-alert' ), __( 'Login Alert Option', 'wps-login-alert' ), 'manage_options', 'wps_login_info_admin_option',array($this, 'wps_login_info_admin_option'));	
		
	}

	public function wps_login_info_admin_option()
	{
		$this->set_template('index',$aParams);
	}
	
	public function wps_wp_login_info($aUname, $aUser)
	{ 	
		$aParams['aUser'] = $aUser;
		$this->set_template('info',$aParams);
	}	

	public function set_template($aTemplate,$aOpts,$aView = 'html')
	{
		ob_start();		
		$aParams['template'] = $aTemplate;
		$aParams['view'] = $aView;
		$aParams['aBrowser'] = $this->getBrowser();
		$aParams['aCurrUser'] = $this->getIpJson();
		$aVars = $aOpts ? array_merge($aParams,$aOpts) : $aParams;
		include "template/template.php";		
		return ob_get_contents();		
		ob_get_clean();
	}

	public function getIpJson()
	{
		$cUrl = "http://freegeoip.net/json/";
		$aResponse = wp_remote_get($cUrl);
		$cData = wp_remote_retrieve_body( $aResponse );		
		$aGeoInfo = json_decode($cData);
		return $aGeoInfo;
	}

	public function getBrowser() 
	{ 
	    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
	    $bname = 'Unknown';
	    $platform = 'Unknown';
	    $version= "";

	    //First get the platform?
	    if (preg_match('/linux/i', $u_agent)) {
	        $platform = 'linux';
	    }
	    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
	        $platform = 'mac';
	    }
	    elseif (preg_match('/windows|win32/i', $u_agent)) {
	        $platform = 'windows';
	    }
	    
	    // Next get the name of the useragent yes seperately and for good reason
	    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
	    { 
	        $bname = 'Internet Explorer'; 
	        $ub = "MSIE"; 
	    } 
	    elseif(preg_match('/Firefox/i',$u_agent)) 
	    { 
	        $bname = 'Mozilla Firefox'; 
	        $ub = "Firefox"; 
	    } 
	    elseif(preg_match('/Chrome/i',$u_agent)) 
	    { 
	        $bname = 'Google Chrome'; 
	        $ub = "Chrome"; 
	    } 
	    elseif(preg_match('/Safari/i',$u_agent)) 
	    { 
	        $bname = 'Apple Safari'; 
	        $ub = "Safari"; 
	    } 
	    elseif(preg_match('/Opera/i',$u_agent)) 
	    { 
	        $bname = 'Opera'; 
	        $ub = "Opera"; 
	    } 
	    elseif(preg_match('/Netscape/i',$u_agent)) 
	    { 
	        $bname = 'Netscape'; 
	        $ub = "Netscape"; 
	    } 
	    
	    // finally get the correct version number
	    $known = array('Version', $ub, 'other');
	    $pattern = '#(?<browser>' . join('|', $known) .
	    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
	    if (!preg_match_all($pattern, $u_agent, $matches)) {
	        // we have no matching number just continue
	    }
	    
	    // see how many we have
	    $i = count($matches['browser']);
	    if ($i != 1) {
	        //we will have two since we are not using 'other' argument yet
	        //see if version is before or after the name
	        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
	            $version= $matches['version'][0];
	        }
	        else {
	            $version= $matches['version'][1];
	        }
	    }
	    else {
	        $version= $matches['version'][0];
	    }
	    
	    // check if we have a number
	    if ($version==null || $version=="") {$version="?";}
	    
	    return array(
	        'userAgent' => $u_agent,
	        'name'      => $bname,
	        'version'   => $version,
	        'platform'  => $platform,
	        'pattern'    => $pattern
	    );
	} 

}

$wpsObj = new WPS_LOGIN_INFO;

