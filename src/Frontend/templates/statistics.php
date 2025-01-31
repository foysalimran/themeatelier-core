<?php
$statistics_section = isset($options['statistics_section']) ? $options['statistics_section'] : '';

?>

<section class="px-4">
    <div class="max-w-5xl px-10 py-8 mx-auto -mt-16 bg-white shadow-md statistics rounded-xl">
        <div class="grid justify-center gap-8 md:grid-cols-3 md:justify-start">
            <?php foreach ($statistics_section as $statistics) :
                $statistics_title = isset($statistics['statistics_title']) ? $statistics['statistics_title'] : '';
                $statistics_subtitle = isset($statistics['statistics_subtitle']) ? $statistics['statistics_subtitle'] : '';
                $statistics_icon = isset($statistics['statistics_icon']) ? $statistics['statistics_icon'] : '';

            ?>
                <div class="flex gap-3 statistic_item">
                    <?php if (!empty($statistics_icon)) : ?>
                        <div class="icon-wrapper">
                            <?php echo $statistics_icon; // Directly output the icon 
                            ?>
                        </div>
                    <?php endif; ?>

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
            ?>
        </div>
    </div>
</section>