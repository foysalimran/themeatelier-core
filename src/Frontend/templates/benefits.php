<?php
$benefits_section_id = isset($options['benefits_section_id']) ? $options['benefits_section_id'] : 'benefits';
$benefits_section_title = isset($options['benefits_section_title']) ? $options['benefits_section_title'] : '';
$benefits_items = isset($options['benefits_items']) ? $options['benefits_items'] : '';
?>

<section id="<?php echo esc_attr($benefits_section_id); ?>" class="py-12 ta-featured md:pb-20 md:pt-24">
    <div class="container px-4 mx-auto">
        <div class="max-w-3xl mx-auto mb-12 text-center">
            <?php if ($benefits_section_title) : ?>
                <h2 class="text-ta-section-title -mt-1.5 mb-0">
                    <?php echo wp_kses_post($benefits_section_title); ?>
                </h2>
            <?php endif; ?>
        </div>
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3 lg:gap-7">
            <?php
            if (!empty($benefits_items)) {
                foreach ($benefits_items as $item) {

                    $benefits_title = isset($item['benefits_title']) ? $item['benefits_title'] : '';
                    $benefits_icon = isset($item['benefits_icon']) ? $item['benefits_icon'] : '';
                    $benefits_description = isset($item['benefits_description']) ? $item['benefits_description'] : '';

                    if ($benefits_title || $benefits_description) {
            ?>
                        <div class="p-6 border border-solid rounded-md shadow-md border-secondary">
                            <div class="flex items-center gap-3 mb-2">
                                <i class="text-2xl demo_text_primary <?php echo esc_attr($benefits_icon); ?>"></i>
                                <?php if ($benefits_title) : ?>
                                    <h3 class="text-lg"><?php echo esc_html($benefits_title); ?></h3>
                                <?php endif; ?>
                            </div>
                            <?php if ($benefits_description) : ?>
                                <span><?php echo wp_kses_post($benefits_description); ?></span>
                            <?php endif; ?>
                        </div>
            <?php
                    }
                }
            }
            ?>
        </div>
    </div>
</section>