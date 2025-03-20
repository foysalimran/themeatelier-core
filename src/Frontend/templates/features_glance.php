<?php
$features_glance_section_id = isset($options['features_glance_section_id']) ? $options['features_glance_section_id'] : 'features_glance';
$features_glance_section_title = isset($options['features_glance_section_title']) ? $options['features_glance_section_title'] : '';
$features_left_side_list = isset($options['features_left_side_list']) ? $options['features_left_side_list'] : '';
$features_right_side_list = isset($options['features_right_side_list']) ? $options['features_right_side_list'] : '';
?>

<section id="<?php echo esc_attr($features_glance_section_id); ?>" class="py-12 offers md:py-20 demo_section_bg">
    <div class="container px-4 mx-auto">
        <div class="max-w-3xl mx-auto mb-12 text-center">
            <?php if ($features_glance_section_title) : ?>
                <h2 class="text-ta-section-title -mt-1.5 mb-0">
                    <?php echo esc_html($features_glance_section_title); ?>
                </h2>
            <?php endif; ?>
        </div>
        <div class="grid lg:gap-8 lg:grid-cols-2">
            <ul class="features-list">
                <?php echo wp_kses_post($features_left_side_list); ?>
            </ul>
            <ul class="features-list">
                <?php echo wp_kses_post($features_right_side_list); ?>
            </ul>
        </div>
    </div>
</section>