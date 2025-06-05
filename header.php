<?php
/**
 * Header template
 *
 * @package CustomTheme
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#main">
        <?php _e('Skip to content', 'custom-theme'); ?>
    </a>

    <header id="masthead" class="site-header" role="banner">
        <div class="container">
            <div class="site-branding">
                <?php if (has_custom_logo()) : ?>
                    <div class="site-logo">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo-link">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-white.png" alt="<?php bloginfo('name'); ?>" class="logo">
                    </a>
                <?php endif; ?>
            </div>

            <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php _e('Primary Menu', 'custom-theme'); ?>">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span class=""><i class="fa-solid fa-bars"></i></span>
                    <span class="hamburger"></span>
                </button>
                <div class="primary-menu" id="mobile-menu-wrapper">
                    <span class="menu-close" aria-label="<?php _e('Close menu', 'custom-theme'); ?>" tabindex="0">×</span>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'primary-menu',
                    'container'      => false,
                ));
                ?>
                <div class="header-buttons">
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('register'))); ?>" class="btn btn-primary register-btn">Register</a>
                </div>
                </div>

            </nav>
        </div>
    </header>
