<?php
$section_id = isset($options['section_id']) ? $options['section_id'] : 'hero';
$section_title = isset($options['section_title']) ? $options['section_title'] : '';
$subtitle = isset($options['subtitle']) ? $options['subtitle'] : '';
$button_01_text = isset($options['button_01']['text']) ? $options['button_01']['text'] : '';
$button_01_url = isset($options['button_01']['url']) ? $options['button_01']['url'] : '#';
$button_01_target = isset($options['button_01']['target']) ? $options['button_01']['target'] : '';
$button_02_text = isset($options['button_02']['text']) ? $options['button_02']['text'] : '';
$button_02_url = isset($options['button_02']['url']) ? $options['button_02']['url'] : '#';
$button_02_target = isset($options['button_02']['target']) ? $options['button_02']['target'] : '';

$money_back_guarantee = isset($options['money_back_guarantee']) ? $options['money_back_guarantee'] : '';
$right_image = isset($options['right_image']['url']) ? $options['right_image']['url'] : '';

?>
<section id="<?php echo esc_attr($section_id); ?>"
    class="h-full pb-20 lg:pb-0 lg:h-[750px] demo_section_bg">
    <div class="container h-full px-4 m-auto">
        <div class="relative z-10 grid items-center h-full grid-cols-1 gap-8 lg:grid-cols-2">
            <div class="order-2 lg:order-1">
                <?php if ($section_title) : ?>
                    <h1 class="mb-0 text-4xl xl:text-ta-section-title">
                        <?php echo wp_kses_post($section_title); ?>
                    </h1>
                <?php endif;
                if ($subtitle) :
                ?>
                    <p class="mt-6 text-lg">
                        <?php echo wp_kses_post($subtitle); ?>
                    </p>
                <?php endif;
                if ($button_01_text || $button_02_text) :
                ?>
                    <div class="flex gap-3 mb-1">
                        <?php
                        if ($button_01_text) :
                        ?>
                            <a target="<?php esc_attr($button_01_target) ?>"
                                href="<?php echo esc_url($button_01_url) ?>" class="demo_btn_primary"><?php echo esc_html__($button_01_text); ?></a>
                        <?php endif;
                        if ($button_02_text) :
                        ?>
                            <a
                                target="<?php esc_attr($button_02_target) ?>" href="<?php echo esc_url($button_02_url) ?>" class="demo_btn_secondary"><?php echo esc_html__($button_02_text); ?></a>
                        <?php endif;
                        ?>
                    </div>
                <?php endif;
                ?>
                <p class="text-sm"><?php echo wp_kses_post($money_back_guarantee); ?></a></p>
            </div>
            <div class="order-1 pt-36 lg:order-2 lg:pt-0">
                <img src="<?php echo esc_url($right_image) ?>" alt="">
            </div>
        </div>
    </div>
</section>