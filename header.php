<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

    <?php // To be sure you're using the latest rendering mode for IE. ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

	<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/assets/images/favicon.png">

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<?php include(TEMPLATEPATH . "/_includes/navigation.php"); ?>

	<section class="wrapper">
		<?php include(TEMPLATEPATH . "/_includes/profile.php"); ?>


