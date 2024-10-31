<?php
   /*   
   Plugin Name: Play Pause Button for Video   
   Description: This plugin used for add automatic 'Play Pause' button on vedio.   
   Version: 2.1   
   Licence: GPL2   
   Author: Sunny Sehgal   
   Author URI: http://www.realitypremedia.com/   
   */

/*Table create and setting file start*/
require( plugin_dir_path( __FILE__ ) . 'play-pause-settings.php');
/*Table create and setting file End*/

   function Pause_play() { 
    /*settings Enable / Disable start*/
        global $wpdb;
        $table_name = $wpdb->prefix . "Play_pause_video";
        $button_status = $wpdb->get_var("SELECT ss_play_button_status FROM $table_name group by id DESC");
        $float_html_status = $wpdb->get_var("SELECT ss_float_status FROM $table_name group by id DESC");
        $float_iframe_status = $wpdb->get_var("SELECT iframe_status FROM $table_name group by id DESC");
    /*settings Enable / Disable end*/
?>

    <style type="text/css">
    <?php if ($button_status==1) {?>
        .pause-play-img {
            position: absolute;
            /*top: 50%;*/
            z-index: 99;
            /*margin-top: -50px;*/
            left: 50%;
            display: none;
            opacity: 0.4;
            width: 64px;
        }

        .video-parent-class:hover img.pause-play-img {
            display: block;
        }

        .video-parent-class {
            position: relative;
        }
    <?php } if ($float_html_status==1 || $float_iframe_status==1) {?>
        /*Floating CSS Start*/

        @keyframes fade-in-up {
            0% {
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .stuck {
            position: fixed;
            bottom: 20px;
            right: 20px;
            transform: translateY(100%);
            width: 260px;
            height: 145px;
            animation: fade-in-up .25s ease forwards;
            z-index: 999;
        }

        /*Floating CSS End*/
    <?php } ?>
    </style>
    <?php
   wp_enqueue_script( 'jquery' );
   ?>
        <script>
            /*Site URL in jQuery*/

            var plugin_url = "<?php echo plugin_dir_url(__FILE__) ?>";

            jQuery(document).ready(function() {
                if (jQuery("video").length > 0) {
                    /*Wrap (all code inside div) all vedio code inside div*/
                    jQuery("video").wrap("<div class='video-parent-class'></div>");

                    <?php if ($button_status==1) {?>
                    /*Add image just before to vedio    */
                    jQuery("<img class='pause-play-img' src='" + plugin_url + "/img/img01.png' >").insertBefore("video");
                    <?php } ?>

                    /*var myVideo = document.getElementsByTagName('video')[0]; */

                    /*main code of each (particular) vedio*/
                    jQuery("video").each(function(index) {
                        <?php if ($button_status==1) {?>
                        /*vedio parent div height width code*/
                        var vedio_width = jQuery(this).width();
                        var vedio_height = jQuery(this).height();
                        jQuery(".video-parent-class").css({
                            "width": vedio_width + "px",
                            "height": vedio_height + "px"
                        });

                        /*Pause Play image, middle width in vedio code*/
                        var half_width_vedio = vedio_width / 2;
                        var middle_object_width = half_width_vedio - 32;
                        jQuery(".pause-play-img").css({
                            "left": middle_object_width + "px"
                        });

                        /*Pause Play image middle height in vedio code*/
                        var half_height_vedio = vedio_height / 2;
                        var middle_object_heigh = half_height_vedio - 32;
                        jQuery(".pause-play-img").css({
                            "top": middle_object_heigh + "px"
                        });

                        /*Pause play and image src change code*/
                        jQuery(this).on("click", function() {
                            if (this.paused) {
                                this.play();
                                jQuery(this).prev().attr("src", plugin_url + "/img/img02.png");
                            } else {
                                this.pause();
                                jQuery(this).prev().attr("src", plugin_url + "/img/img01.png");
                            }


                        });


                        /*pause play image click vedio on off functionlity code*/
                        jQuery(this).prev().on("click", function() {
                            var myVideo = jQuery(this).next()[0];
                            if (myVideo.paused) {

                                myVideo.play();
                                jQuery(this).attr("src", plugin_url + "/img/img02.png");
                            } else {

                                myVideo.pause();
                                jQuery(this).attr("src", plugin_url + "/img/img01.png");
                            }

                        });
                        /*Floating js for HTML Video Start*/
                        <?php } if ($float_html_status==1) { ?>
                        var windows = jQuery(window);
                        var videoWrap = jQuery(this).parent();
                        var video = jQuery(this);
                        var videoHeight = video.outerHeight();
                        var videoElement = video.get(0);
                        windows.on('scroll', function() {
                            var windowScrollTop = windows.scrollTop();
                            var videoBottom = videoHeight + videoWrap.offset().top;
                            //alert(videoBottom);
                            
                                if ((windowScrollTop > videoBottom)) {
                                    if (!videoElement.paused) {
                                        videoWrap.height(videoHeight);
                                        video.addClass('stuck');
                                        if (video.hasClass('stuck')) {
                                           video.attr("controls","1");
                                        }
                                        /*when video automatically off on scroll and when we play again so img not changed so we used this below code*/
                                        video.prev().attr("src", plugin_url + "/img/img02.png");
                                    }
                                    else {
                                        videoWrap.height('auto');
                                        video.removeClass('stuck');
                                        video.removeAttr('controls');
                                        if (videoElement.paused) {
                                           video.prev().attr("src", plugin_url + "/img/img01.png");
                                        }
                                    }
                                } else {
                                    videoWrap.height('auto');
                                    video.removeClass('stuck');
                                    video.removeAttr('controls');
                                }
                            
                        });
                        <?php } ?>
                        /*Floating js for HTML Video End*/
                        
                    });
                    <?php if ($button_status==1) {?>
                    /*After end vedio change image*/
                    var video = document.getElementsByTagName('video')[0];

                    video.onended = function(e) {
                        jQuery(".pause-play-img").attr("src", plugin_url + "/img/img01.png");
                    };
                    <?php } ?>
                }

        /*################################################################*/
                <?php if ($float_iframe_status==1) { ?>
                /*Floating Code for Iframe Start*/
                if (jQuery('iframe[src*="https://www.youtube.com/embed/"],iframe[src*="https://player.vimeo.com/"],iframe[src*="https://player.vimeo.com/"]').length > 0) {
                    /*Wrap (all code inside div) all vedio code inside div*/
                    jQuery('iframe[src*="https://www.youtube.com/embed/"],iframe[src*="https://player.vimeo.com/"]').wrap("<div class='iframe-parent-class'></div>");
                    /*main code of each (particular) vedio*/
                    jQuery('iframe[src*="https://www.youtube.com/embed/"],iframe[src*="https://player.vimeo.com/"]').each(function(index) {

                        /*Floating js Start*/
                        var windows = jQuery(window);
                        var iframeWrap = jQuery(this).parent();
                        var iframe = jQuery(this);
                        var iframeHeight = iframe.outerHeight();
                        var iframeElement = iframe.get(0);
                        windows.on('scroll', function() {
                            var windowScrollTop = windows.scrollTop();
                            var iframeBottom = iframeHeight + iframeWrap.offset().top;
                            //alert(iframeBottom);

                            if ((windowScrollTop > iframeBottom)) {
                                iframeWrap.height(iframeHeight);
                                iframe.addClass('stuck');
                            } else {
                                iframeWrap.height('auto');
                                iframe.removeClass('stuck');
                            }
                        });
                        /*Floating js End*/
                    });
                }

                /*Floating Code for Iframe End*/
                <?php } ?>

            });
        </script>
        <?php
   }
   add_action('wp_head', 'Pause_play');
?>