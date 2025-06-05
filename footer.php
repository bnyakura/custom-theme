<?php
/**
 * Footer template
 *
 * @package CustomTheme
 */
?>

    <footer id="colophon" class="site-footer" role="contentinfo">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <?php if (has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo-link">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-blue.png" alt="<?php bloginfo('name'); ?>" class="logo">
                        </a>
                    <?php endif; ?>
                </div>
                
                <div class="footer-social">
                    <a href="https://facebook.com" class="social-link" aria-label="Facebook" target="_blank">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                    <a href="www.instagram.com" class="social-link" aria-label="Instagram" target="_blank">
                        <i class="fab fa-instagram" aria-hidden="true"></i>
                    </a>
                    <a href="www.x.com" class="social-link" aria-label="Twitter" target="_blank">
                        <i class="fa-brands fa-x-twitter" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
            
            <div class="footer-copyright">
                <p>Cursus commodo vitae faucibus hac. Sem pretium lacus nunc urna commodo feugiat lacus. Massa a faucibus porttitor est maecenas aliquet.</p>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
