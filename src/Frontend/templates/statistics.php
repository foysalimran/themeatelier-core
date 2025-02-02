<?php
$statistics_section_id = isset($options['statistics_section_id']) ? $options['statistics_section_id'] : 'statistics';
$statistics_section = isset($options['statistics_section']) ? $options['statistics_section'] : '';
?>
<section id="<?php echo esc_attr($statistics_section_id); ?>" class="px-4">
    <div class="max-w-5xl px-10 py-8 mx-auto -mt-16 bg-white shadow-md statistics rounded-xl">
        <div class="grid justify-center gap-8 md:grid-cols-3 md:justify-start">
            <?php
            if (!empty($statistics_section)) :
                foreach ($statistics_section as $statistics) :
                    $statistics_title = isset($statistics['statistics_title']) ? $statistics['statistics_title'] : '';
                    $statistics_subtitle = isset($statistics['statistics_subtitle']) ? $statistics['statistics_subtitle'] : '';
                    $statistics_icon_bg = isset($statistics['statistics_icon_bg']) ? $statistics['statistics_icon_bg'] : '';
                    $statistics_icon = isset($statistics['statistics_icon']['url']) ? $statistics['statistics_icon']['url'] : '';

            ?>
                    <div class="flex gap-3 statistic_item">
                        <?php if (!empty($statistics_icon)) : ?>
                            <div class="w-16 h-16 flex items-center justify-center rounded-md" style="background-color: <?php echo esc_attr($statistics_icon_bg) ?>">
                                <img src="<?php echo esc_attr($statistics_icon) ?>" alt="" />
                            </div>
                        <?php endif ?>

                        <div class="content">
                            <?php if (!empty($statistics_title)) : ?>
                                <p class="text-2xl text-[#333] pb-0 mb-0 font-bold"><?php echo esc_html($statistics_title); ?></p>
                            <?php endif; ?>

                            <?php if (!empty($statistics_subtitle)) : ?>
                                <p><?php echo esc_html($statistics_subtitle); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
            <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>