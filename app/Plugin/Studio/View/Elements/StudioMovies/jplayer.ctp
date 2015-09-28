<div class="slide">
    <?php //$player_id = "jquery_jplayer_" . $movie['StudioMovie']['id']; ?>
    <?php //debug($player_id);?>
    <?php //$player_container_id = "jp_container_" . $movie['StudioMovie']['id']; ?>
    <?php //debug($player_container_id);?>
    <!--<div id="<?php //echo $player_id;     ?>" style="width: 0px; height: 0px;"></div>-->

    <div class="circleplayer">
        <div id="jquery_jplayer_<?php echo $movie['StudioMovie']['id']; ?>" class="cp-jplayer"></div>
        <div id="cp_container_<?php echo $movie['StudioMovie']['id']; ?>" class="cp-container">
            <div class="cp-buffer-holder">
                <div class="cp-buffer-1"></div>
                <div class="cp-buffer-2"></div>
            </div>
            <div class="cp-progress-holder">
                <div class="cp-progress-1"></div>
                <div class="cp-progress-2"></div>
            </div>
            <div class="cp-circle-control"></div>
            <ul class="cp-controls">
                <li><a class="cp-play" tabindex="1">play</a></li>
                <li><a class="cp-pause" style="display:none;" tabindex="1">pause</a></li>
            </ul>
        </div>
        <div class="cp-title">
            <ul>
                <li>
                    <?php echo empty($movie['StudioMovie']['author']) ? '' : $movie['StudioMovie']['author'] . ' - '; ?>
                    <?php echo empty($movie['StudioMovie']['name']) ? '' : $movie['StudioMovie']['name']; ?>&nbsp;
                </li>
            </ul>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        console.log('test');

        var myCirclePlayer = new CirclePlayer(
            "#jquery_jplayer_<?php echo $movie['StudioMovie']['id']; ?>",
            {
                mp3: "<?php echo '/files/studiomovie/' . $movie['StudioMovie']['file']; ?>",
            }, 
            {
                cssSelectorAncestor: "#cp_container_<?php echo $movie['StudioMovie']['id']; ?>",
                // solution: "flash,html",
                swfPath: "/js/jplayer-2_4_0",
                supplied: "mp3",
                wmode: "window",
                keyEnabled: true
            }
        );

//        $('#jquery_jplayer_<?php echo $movie['StudioMovie']['id']; ?>').jPlayer({
//            ready: function() {
//                $(this).jPlayer("setMedia", {
//                    mp3: "<?php echo '/files/studiomovie/' . $movie['StudioMovie']['file']; ?>",
//                    //mp3: "files/studiomovie/missin_red__-_i_feel_so_blue.mp3",
//                    //mp3: "media/No_Mas_-_La_Banda_-_Yerba_buena.mp3",
//                    //oga: "media/Epoq-Lepidoptera.ogg",
//                });
//            },
//            swfPath: "js/jplayer-2_4_0",
//            supplied: "mp3",
//            cssSelectorAncestor: "#cp_container_<?php echo $movie['StudioMovie']['id']; ?>",
//            wmode: "window",
//            keyEnabled: true,
//            cssSelector: {
//                play: ".cp-play",
//                pause: ".cp-pause",
//            }
//        });
    });
</script>



    <!--<div id="<?php //echo $player_container_id;     ?>" class='jp-audio'>-->
<!--    <div id="jp_container_<?php //echo $movie['StudioMovie']['id'];     ?>" class='jp-audio'>
        <div class='jp-type-single'>
            <div class="jp-gui jp-interface">
                <ul class='jp-controls'>
                    <li><a href="#" class="jp-play" tabindex="1">play</a></li>
                    <li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
                    <li><a href="#" class="jp-stop" tabindex="1">stop</a></li>
                    <li><a href="#" class="jp-mute" title="mute" tabindex="1">mute</a></li>
                    <li><a href="#" class="jp-unmute" title="unmute" tabindex="1" style="display: none;">unmute</a></li>
                    <li><a href="#" class="jp-volume-max" title="max volume" tabindex="1">max volume</a></li>
                </ul>
                <div class="jp-progress">
                    <div class="jp-seek-bar" style="width: 100%;">
                        <div class="jp-play-bar" style="width: 0%;"></div>
                    </div>
                </div>
                <div class="jp-volume-bar">
                    <div class="jp-volume-bar-value" style="width: 80%;"></div>
                </div>
                <div class="jp-time-holder">
                    <div class="jp-current-time"></div>
                    <div class="jp-duration"></div>

                    <ul class="jp-toggles">
                        <li><a href="#" title="repeat" tabindex="1" class="jp-repeat">repeat</a></li>
                        <li><a href="#" title="repeat off" tabindex="1" class="jp-repeat-off" style="display: none;">repeat off</a></li>
                    </ul>
                </div>
            </div>
            <div class="jp-title">
                <ul>
                    <li>
<?php //echo empty($movie['StudioMovie']['author']) ? '' : $movie['StudioMovie']['author'] . ' - '; ?>
<?php //echo empty($movie['StudioMovie']['name']) ? '' : $movie['StudioMovie']['name']; ?>&nbsp;
                    </li>
                </ul>
            </div>
        </div>
    </div>-->


