<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<?php if($aParams['view'] == "html") { ?>
	<div class="wrap">
		<?php if(isset($_SESSION['wps_success']) && $_SESSION['wps_success']) { ?>
			<div class="updated"><p><?php echo $_SESSION['wps_success']; ?></p></div>
			<?php unset($_SESSION['wps_success']);  ?>
		<?php } ?>
		<?php if(isset($_SESSION['wps_error']) && $_SESSION['wps_error']) { ?>
			<div class="error"><p><?php echo $_SESSION['wps_error']; ?></p></div>
			<?php unset($_SESSION['wps_error']);  ?>
		<?php } ?>
		<?php include_once plugin_dir_path( __FILE__ ).$aParams['template'].".php"; ?>
	</div>
<?php } else { ?>
	<?php include_once plugin_dir_path( __FILE__ ).$aParams['template'].".php"; ?>
<?php } ?>

