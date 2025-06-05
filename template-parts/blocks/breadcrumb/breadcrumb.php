<?php
/**
 * Breadcrumb Block Template
 *
 * @package custom-theme
 */

// Start with Home
$breadcrumb_items = array(
    array('label' => __('Home', 'custom-theme'), 'url' => home_url('/')),
);

// Generate breadcrumbs for singular posts/pages
if (is_singular('post') || is_singular('page')) {
    $ancestors = array_reverse(get_post_ancestors(get_the_ID()));

    foreach ($ancestors as $ancestor_id) {
        $breadcrumb_items[] = array(
            'label' => get_the_title($ancestor_id),
            'url' => get_permalink($ancestor_id),
        );
    }

    // Add current post/page
    $breadcrumb_items[] = array(
        'label' => get_the_title(),
        'url' => '',
    );
}

// Fallback if still empty
if (empty($breadcrumb_items)) {
    $breadcrumb_items[] = array('label' => __('Home', 'custom-theme'), 'url' => home_url('/'));
}
?>

<nav class="breadcrumb" aria-label="<?php esc_attr_e('Breadcrumb', 'custom-theme'); ?>">
    <ul class="breadcrumb-list">
        <?php foreach ($breadcrumb_items as $index => $item): ?>
            <li class="breadcrumb-item">
                <?php if (!empty($item['url']) && $index < count($breadcrumb_items) - 1): ?>
                    <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a>
                <?php else: ?>
                    <span aria-current="page"><?php echo esc_html($item['label']); ?></span>
                <?php endif; ?>

                <?php if ($index < count($breadcrumb_items) - 1): ?>
                    <span class="breadcrumb-separator">
                        <i class="fas fa-chevron-right" aria-hidden="true"></i>
                    </span>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
