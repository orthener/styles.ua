<?php if (!empty($sliders)): ?>
    <div id="slider">
        <div class="sliderContent">
            <?php foreach ($sliders as $slide): ?>
                <?php if (!empty($slide['Slider']['img'])): ?>
                    <div class="slide-order-<?php echo $slide['Slider']['order']; ?>" id="slide-<?php echo $slide['Slider']['id']; ?>">
                        <?php echo $this->Html->image('/files/slider/' . $slide['Slider']['img']); ?>
                        <?php if (!empty($slide['Slider']['name'])): ?>
                            <h2><?php echo $slide['Slider']['name']; ?></h2>
                        <?php endif; ?>
                        <?php if (!empty($slide['Slider']['tiny_name'])): ?>
                            <div class="more-info">
                                <div class="info">
                                    <h6 style="color: #<?php echo $slide['Slider']['text_color']; ?>"><?php echo $slide['Slider']['tiny_name']; ?></h6>
                                    <p style="color: #<?php echo $slide['Slider']['text_color']; ?>"><?php echo $slide['Slider']['content']; ?></p>
                                </div>
                                <?php if (!empty($slide['Slider']['button_text'])): ?>
                                    <div class="more">
                                        <?php echo (!empty($slide['Slider']['button_text'])) ? $this->Html->link($slide['Slider']['button_text'], $slide['Slider']['button_link'], array('class' => '')) : ''; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <div class="row-fluid">
            <div id="slider-pager" class="">

            </div>
        </div>
    </div>

    <script type="text/javascript">
        //<![CDATA[
        $('#slider .sliderContent').cycle({
            timeout: 4000,
            delay: 0,
            pause: 1,
            pager: '#slider-pager',
            pagerAnchorBuilder: function(idx, slide) {
                return '<a href="#"><span class="white-flag"></span><span class="slide-number">0' + (idx + 1) + '.</span><img src="' + $(slide).find('img').attr('src') + '" width="195" height="70"/></a>';
            }
        });
        //]]>
    </script>

<?php endif; ?>