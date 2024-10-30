/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

(function ($) {
    "use strict";
    var HaruVidi = {
        init: function() {
            HaruVidi.video.init();
        }
    };

    HaruVidi.video = {
        init: function() {
            // Other variables
            HaruVidi.video.videoID = '';
            HaruVidi.video.video_server = '';
            HaruVidi.video.autoplay = 'on';
            HaruVidi.video.muted = false;
            HaruVidi.video.auto_next = true;
            HaruVidi.video.videos_data = [];
            // Functions
            HaruVidi.video.videoPlayer();
            HaruVidi.video.turnOffLight();
            HaruVidi.video.floatingPlayer();
            HaruVidi.video.autoNextStatus();
            HaruVidi.video.videoRating();
            HaruVidi.video.videoScreenShots();
            HaruVidi.video.watchLater();
            HaruVidi.video.videoSocialShare();
            HaruVidi.video.videoToggleContent();
            HaruVidi.video.videoReport();
            // 
            HaruVidi.video.playlistScrollBar();
            HaruVidi.video.playlistScrollTitle();
            HaruVidi.video.layoutToggle();
            // Archive Video
            HaruVidi.video.archiveVideoSort();
            HaruVidi.video.videoLayoutIsotope();
            HaruVidi.video.videoLoadMore();
            HaruVidi.video.videoInfiniteScroll();
            // Channel
            HaruVidi.video.channelSubscribe();
            // Shortcode
            HaruVidi.video.shortcodeSingle();
            HaruVidi.video.shortcodeVideoFilter();
            HaruVidi.video.shortcodeVideoFeatured();
            HaruVidi.video.shortcodeVideoOrder();
            HaruVidi.video.shortcodeVideoOrderSingle();
            HaruVidi.video.shortcodeVideoCategory();
            HaruVidi.video.shortcodeVideoCategorySingle();
            HaruVidi.video.shortcodeVideoTop();
            HaruVidi.video.shortcodeVideoSlideshow();
            HaruVidi.video.shortcodeVideoSearch();
            HaruVidi.video.shortcodeChannelCategory();
            HaruVidi.video.shortcodeChannelTop();
            HaruVidi.video.shortcodeSeriesCategory();
            HaruVidi.video.shortcodeSeriesTop();
            HaruVidi.video.shortcodePlaylistCategory();
            HaruVidi.video.shortcodePlaylistTop();
            HaruVidi.video.shortcodeSubmit();
            // Hover
            HaruVidi.video.thumbnailHoverSlideshow();
            // BuddyPress & Author
            HaruVidi.video.buddyPress();
            HaruVidi.video.authorSingle();
        },
        playlistScrollTitle: function() {
            // Need add .audio-list__title span in HTML
            $('.single-video-playlist-title-scroll').each(function(){
                var el = $(this);

                $(this).mouseenter(function(){
                    if ( $(this).find('span').width() > $(this).width() ) {
                        var scroll_text = setInterval(function () {
                            scrollText();
                        }, 30);
                    } else {
                        return;
                    }

                    $(this).mouseleave(function(){
                        clearInterval(scroll_text);

                        el.css({
                            left: 0
                        });
                    });
                });

                var scrollText = function () {
                    var width = el.find('span').width(),
                        left = el.position().left - 1;

                    left = -left > width ? el.width() : left;
                    el.css({
                        left: left
                    });
                };
            });
        },
        videoReport: function() {
            $('.video-report-button').off().on('click', function() {
                var $this           = $(this);
                var video_id        = $(this).attr('data-video_id');
                var reportWrap      = $(this).parents('.video-report-form');
                var report_content  = reportWrap.find('.video-report-content').val();

                $.ajax({
                    type : 'POST',
                    timeout : 30000,
                    url : haru_vidi_ajax_url,
                    data : {
                        action: 'haru_video_report',
                        video_id: video_id,
                        report_content: report_content
                    },
                    error: function(xhr,err) {
                        console.log('Have something wrong! Please try again!');
                    },
                    success: function(response) {
                        console.log(response);
                        if ( response ) {
                            if ( response.status == 'success' ) {
                                reportWrap.find('.video-report-notice').addClass('success').text(response.message);
                                reportWrap.find('.video-report-reason').hide();
                                reportWrap.find('.video-report-submit').hide();
                            } else {
                                reportWrap.find('.video-report-notice').addClass('failed').text(response.message);
                            }
                        }
                    }
                });
            });
        },
        channelSubscribe: function() {
            $('.channel-subscribe').each(function(){
                var is_clicked = false;

                $('.channel-subscribe').off().on('click', function() {
                    var $this           = $(this);
                    var channel_id      = parseInt($(this).attr('data-channel_id'));
                    var text_subscribe  = $(this).attr('data-text_subscribe');
                    var text_subscribed = $(this).attr('data-text_subscribed');
                    var login           = $(this).attr('data-login');
                    var login_url       = $(this).attr('data-login_url');

                    if ( typeof(login) === 'undefined' || login === 'no' ) {
                        window.location.href = login_url; // Go to sign up link

                        return false;
                    }

                    // Process click multitimes before ajax process
                    if ( is_clicked === true ) {
                        return;
                    }

                    is_clicked = true;   

                    $.ajax({
                        type : 'POST',
                        timeout : 30000,
                        url : haru_vidi_ajax_url,
                        data : {
                            action: 'haru_channel_subscribe',
                            channel_id: channel_id,
                            login: login
                        },
                        error: function(xhr,err) {
                            console.log('Have something wrong! Please try again!');
                        },
                        success: function(response) {
                            if ( response ) {
                                if ( response.channel_subscribed == 1 ) {
                                    $this.find('.text-subscribe').text(text_subscribed);
                                    $this.find('.count-subscribed').text(response.channel_subscribed_count);
                                    $this.parents('.channel-item').find('.count-subscribed').text(response.channel_subscribed_count);
                                    $this.parents('.single-channel__meta-info').find('.count-subscribed').text(response.channel_subscribed_count);
                                    $this.addClass('subscribed');
                                } else {
                                    $this.find('.text-subscribe').text(text_subscribe);
                                    $this.find('.count-subscribed').text(response.channel_subscribed_count);
                                    $this.parents('.channel-item').find('.count-subscribed').text(response.channel_subscribed_count);
                                    $this.parents('.single-channel__meta-info').find('.count-subscribed').text(response.channel_subscribed_count);
                                    $this.removeClass('subscribed');
                                }
                            }

                            is_clicked = false;
                        }
                    });
                });
            });
        },
        thumbnailHoverSlideshow: function() {
            $('.video-thumbnail.slideshow, .playlist-thumbnail.slideshow, .series-thumbnail.slideshow').each(function(){
                var $self = $(this);
                var speed = $(this).data('speed');
                var currentIndex = 0,
                    items = $('img', $self),
                    itemAmt = items.length;

                if ( itemAmt == 1 ) {
                    return;
                }

                function cycleItems(currentIndex) {
                    var item = $('img', $self).eq(currentIndex);
                    items.hide();
                    item.css('display','block'); // @TODO: item.fadeIn();
                }

                $self.mouseenter(function(){
                    var autoSlide = setInterval(function() {
                        currentIndex += 1;
                        if ( currentIndex > itemAmt - 1 ) {
                            currentIndex = 0;
                            // Go to first & stop
                            clearInterval(autoSlide);
                        }
                        cycleItems(currentIndex);
                    }, speed);

                    $self.mouseleave(function(){
                        clearInterval(autoSlide);
                        // Show first thumb
                        $.each(items, function( index, item ) {
                            if ( item == items[0] ) {
                                $(item).css('display','block');
                            } else {
                                $(item).hide();
                            }
                        });
                    });
                });
            });
        },
        buddyPress: function() {
            $('.bp-video-load-more').off().on('click', function() {
                var $this           = $(this).addClass('loading');
                var contentWrap     = '.layout-wrap';
                var element         = '.layout-wrap article.grid-item';
                var current_page    = parseInt($(this).attr('data-current_page'));
                var max_page        = parseInt($(this).attr('data-max_page'));
                var posts_per_page  = parseInt($(this).attr('data-posts_per_page'));

                $this.addClass('loading');

                $.ajax({
                    type : 'POST',
                    timeout : 30000,
                    url : haru_vidi_ajax_url,
                    data : {
                        action: 'haru_bp_get_video', 
                        current_page: current_page, 
                        max_page: max_page,
                        posts_per_page: posts_per_page
                    },
                    error: function(xhr,err) {
                        console.log('Have something wrong! Please try again!');
                    },
                    success: function(response) {
                        if ( response ) {
                            var $newElems = $(response).find('.video-item').css({ opacity: 0 });

                            console.log($newElems);

                            $(contentWrap).append($newElems);

                            $newElems.imagesLoaded(function () {
                                $newElems.animate({ opacity: 1 });

                                $(contentWrap).isotope('appended', $newElems);

                                setTimeout(function() {
                                    $(contentWrap).isotope('layout');
                                }, 300);

                                // Re Init functions
                                HaruVidi.video.init();
                            });

                            if ( current_page + 1 >= max_page ) {
                                $this.parent().hide(); // @TODO: cause height issue
                            } else {
                                $this.removeClass('loading');
                                $this.attr('data-current_page', current_page + 1);
                            }
                        }
                    }
                });
            });

            // Playlist
            $('.bp-playlist-load-more').off().on('click', function() {
                var $this           = $(this).addClass('loading');
                var contentWrap     = '.layout-wrap';
                var element         = '.layout-wrap article.grid-item';
                var current_page    = parseInt($(this).attr('data-current_page'));
                var max_page        = parseInt($(this).attr('data-max_page'));
                var posts_per_page  = parseInt($(this).attr('data-posts_per_page'));

                $this.addClass('loading');

                $.ajax({
                    type : 'POST',
                    timeout : 30000,
                    url : haru_vidi_ajax_url,
                    data : {
                        action: 'haru_bp_get_playlist', 
                        current_page: current_page, 
                        max_page: max_page,
                        posts_per_page: posts_per_page
                    },
                    error: function(xhr,err) {
                        console.log('Have something wrong! Please try again!');
                    },
                    success: function(response) {
                        if ( response ) {
                            var $newElems = $(response).find('.playlist-item').css({ opacity: 0 });

                            $(contentWrap).append($newElems);

                            $newElems.imagesLoaded(function () {
                                $newElems.animate({ opacity: 1 });

                                $(contentWrap).isotope('appended', $newElems);

                                setTimeout(function() {
                                    $(contentWrap).isotope('layout');
                                }, 300);

                                // Re Init functions
                                HaruVidi.video.init();
                            });

                            if ( current_page + 1 >= max_page ) {
                                $this.parent().hide(); // @TODO: cause height issue
                            } else {
                                $this.removeClass('loading');
                                $this.attr('data-current_page', current_page + 1);
                            }
                        }
                    }
                });
            });

            // Series
            $('.bp-series-load-more').off().on('click', function() {
                var $this           = $(this).addClass('loading');
                var contentWrap     = '.layout-wrap';
                var element         = '.layout-wrap article.grid-item';
                var current_page    = parseInt($(this).attr('data-current_page'));
                var max_page        = parseInt($(this).attr('data-max_page'));
                var posts_per_page  = parseInt($(this).attr('data-posts_per_page'));

                $this.addClass('loading');

                $.ajax({
                    type : 'POST',
                    timeout : 30000,
                    url : haru_vidi_ajax_url,
                    data : {
                        action: 'haru_bp_get_series', 
                        current_page: current_page, 
                        max_page: max_page,
                        posts_per_page: posts_per_page
                    },
                    error: function(xhr,err) {
                        console.log('Have something wrong! Please try again!');
                    },
                    success: function(response) {
                        if ( response ) {
                            var $newElems = $(response).find('.series-item').css({ opacity: 0 });

                            $(contentWrap).append($newElems);

                            $newElems.imagesLoaded(function () {
                                $newElems.animate({ opacity: 1 });

                                $(contentWrap).isotope('appended', $newElems);

                                setTimeout(function() {
                                    $(contentWrap).isotope('layout');
                                }, 300);

                                // Re Init functions
                                HaruVidi.video.init();
                            });

                            if ( current_page + 1 >= max_page ) {
                                $this.parent().hide(); // @TODO: cause height issue
                            } else {
                                $this.removeClass('loading');
                                $this.attr('data-current_page', current_page + 1);
                            }
                        }
                    }
                });
            });

            // Channel
            $('.bp-channel-load-more').off().on('click', function() {
                var $this           = $(this).addClass('loading');
                var contentWrap     = '.layout-wrap';
                var element         = '.layout-wrap article.grid-item';
                var current_page    = parseInt($(this).attr('data-current_page'));
                var max_page        = parseInt($(this).attr('data-max_page'));
                var posts_per_page  = parseInt($(this).attr('data-posts_per_page'));

                $this.addClass('loading');

                $.ajax({
                    type : 'POST',
                    timeout : 30000,
                    url : haru_vidi_ajax_url,
                    data : {
                        action: 'haru_bp_get_channel', 
                        current_page: current_page, 
                        max_page: max_page,
                        posts_per_page: posts_per_page
                    },
                    error: function(xhr,err) {
                        console.log('Have something wrong! Please try again!');
                    },
                    success: function(response) {
                        if ( response ) {
                            var $newElems = $(response).find('.channel-item').css({ opacity: 0 });

                            $(contentWrap).append($newElems);

                            $newElems.imagesLoaded(function () {
                                $newElems.animate({ opacity: 1 });

                                $(contentWrap).isotope('appended', $newElems);

                                setTimeout(function() {
                                    $(contentWrap).isotope('layout');
                                }, 300);

                                // Re Init functions
                                HaruVidi.video.init();
                            });

                            if ( current_page + 1 >= max_page ) {
                                $this.parent().hide(); // @TODO: cause height issue
                            } else {
                                $this.removeClass('loading');
                                $this.attr('data-current_page', current_page + 1);
                            }
                        }
                    }
                });
            });
        },
        authorSingle: function() {
            $('.author-video-load-more').off().on('click', function() {
                var $this           = $(this).addClass('loading');
                var contentWrap     = '.layout-wrap';
                var element         = '.layout-wrap article.grid-item';
                var current_page    = parseInt($(this).attr('data-current_page'));
                var max_page        = parseInt($(this).attr('data-max_page'));
                var posts_per_page  = parseInt($(this).attr('data-posts_per_page'));

                $this.addClass('loading');

                $.ajax({
                    type : 'POST',
                    timeout : 30000,
                    url : haru_vidi_ajax_url,
                    data : {
                        action: 'haru_author_get_video', 
                        current_page: current_page, 
                        max_page: max_page,
                        posts_per_page: posts_per_page
                    },
                    error: function(xhr,err) {
                        console.log('Have something wrong! Please try again!');
                    },
                    success: function(response) {
                        if ( response ) {
                            var $newElems = $(response).find('.video-item').css({ opacity: 0 });

                            $(contentWrap).append($newElems);

                            $newElems.imagesLoaded(function () {
                                $newElems.animate({ opacity: 1 });

                                $(contentWrap).isotope('appended', $newElems);

                                setTimeout(function() {
                                    $(contentWrap).isotope('layout');
                                }, 300);

                                // Re Init functions
                                HaruVidi.video.init();
                            });

                            if ( current_page + 1 >= max_page ) {
                                $this.parent().hide(); // @TODO: cause height issue
                            } else {
                                $this.removeClass('loading');
                                $this.attr('data-current_page', current_page + 1);
                            }
                        }
                    }
                });
            });

            $('.author-playlist-load-more').off().on('click', function() {
                var $this           = $(this).addClass('loading');
                var contentWrap     = '.layout-wrap';
                var element         = '.layout-wrap article.grid-item';
                var current_page    = parseInt($(this).attr('data-current_page'));
                var max_page        = parseInt($(this).attr('data-max_page'));
                var posts_per_page  = parseInt($(this).attr('data-posts_per_page'));

                $this.addClass('loading');

                $.ajax({
                    type : 'POST',
                    timeout : 30000,
                    url : haru_vidi_ajax_url,
                    data : {
                        action: 'haru_author_get_playlist', 
                        current_page: current_page, 
                        max_page: max_page,
                        posts_per_page: posts_per_page
                    },
                    error: function(xhr,err) {
                        console.log('Have something wrong! Please try again!');
                    },
                    success: function(response) {
                        if ( response ) {
                            var $newElems = $(response).find('.playlist-item').css({ opacity: 0 });

                            $(contentWrap).append($newElems);

                            $newElems.imagesLoaded(function () {
                                $newElems.animate({ opacity: 1 });

                                $(contentWrap).isotope('appended', $newElems);

                                setTimeout(function() {
                                    $(contentWrap).isotope('layout');
                                }, 300);

                                // Re Init functions
                                HaruVidi.video.init();
                            });

                            if ( current_page + 1 >= max_page ) {
                                $this.parent().hide(); // @TODO: cause height issue
                            } else {
                                $this.removeClass('loading');
                                $this.attr('data-current_page', current_page + 1);
                            }
                        }
                    }
                });
            });

            $('.author-series-load-more').off().on('click', function() {
                var $this           = $(this).addClass('loading');
                var contentWrap     = '.layout-wrap';
                var element         = '.layout-wrap article.grid-item';
                var current_page    = parseInt($(this).attr('data-current_page'));
                var max_page        = parseInt($(this).attr('data-max_page'));
                var posts_per_page  = parseInt($(this).attr('data-posts_per_page'));

                $this.addClass('loading');

                $.ajax({
                    type : 'POST',
                    timeout : 30000,
                    url : haru_vidi_ajax_url,
                    data : {
                        action: 'haru_author_get_series', 
                        current_page: current_page, 
                        max_page: max_page,
                        posts_per_page: posts_per_page
                    },
                    error: function(xhr,err) {
                        console.log('Have something wrong! Please try again!');
                    },
                    success: function(response) {
                        if ( response ) {
                            var $newElems = $(response).find('.series-item').css({ opacity: 0 });

                            $(contentWrap).append($newElems);

                            $newElems.imagesLoaded(function () {
                                $newElems.animate({ opacity: 1 });

                                $(contentWrap).isotope('appended', $newElems);

                                setTimeout(function() {
                                    $(contentWrap).isotope('layout');
                                }, 300);

                                // Re Init functions
                                HaruVidi.video.init();
                            });

                            if ( current_page + 1 >= max_page ) {
                                $this.parent().hide(); // @TODO: cause height issue
                            } else {
                                $this.removeClass('loading');
                                $this.attr('data-current_page', current_page + 1);
                            }
                        }
                    }
                });
            });

            $('.author-channel-load-more').off().on('click', function() {
                var $this           = $(this).addClass('loading');
                var contentWrap     = '.layout-wrap';
                var element         = '.layout-wrap article.grid-item';
                var current_page    = parseInt($(this).attr('data-current_page'));
                var max_page        = parseInt($(this).attr('data-max_page'));
                var posts_per_page  = parseInt($(this).attr('data-posts_per_page'));

                $this.addClass('loading');

                $.ajax({
                    type : 'POST',
                    timeout : 30000,
                    url : haru_vidi_ajax_url,
                    data : {
                        action: 'haru_author_get_channel', 
                        current_page: current_page, 
                        max_page: max_page,
                        posts_per_page: posts_per_page
                    },
                    error: function(xhr,err) {
                        console.log('Have something wrong! Please try again!');
                    },
                    success: function(response) {
                        if ( response ) {
                            var $newElems = $(response).find('.channel-item').css({ opacity: 0 });

                            $(contentWrap).append($newElems);

                            $newElems.imagesLoaded(function () {
                                $newElems.animate({ opacity: 1 });

                                $(contentWrap).isotope('appended', $newElems);

                                setTimeout(function() {
                                    $(contentWrap).isotope('layout');
                                }, 300);

                                // Re Init functions
                                HaruVidi.video.init();
                            });

                            if ( current_page + 1 >= max_page ) {
                                $this.parent().hide(); // @TODO: cause height issue
                            } else {
                                $this.removeClass('loading');
                                $this.attr('data-current_page', current_page + 1);
                            }
                        }
                    }
                });
            });
        },
        shortcodeSubmit: function() {
            // Do something
        },
        videoPlayer: function() {
            // Process for unmute video button
            if ( HaruVidi.video.isiOS() ) {
                $('body').addClass('haru-ios');
            }

            HaruVidi.video.displayVideoPlayerDirect();
            HaruVidi.video.displayVideoPlayerPopup();
        },
        processAutoPlay: function() {
            // Check on each server serverAPI
            var serverAPI = null;
            var autoplay = null;

            if ( $('.video-player-data').length > 0 ) {
                serverAPI = $('.video-player-data').attr('data-server');
                autoplay = ($('.video-player-data').attr('data-autoplay')) == 'true' ? true : false;

                // Check on iOS and Safari
                if ( HaruVidi.video.isiOS() ) {
                    autoplay == true;

                    switch ( serverAPI ) {
                        case 'vimeo':
                            HaruVidi.video.muted = true;

                            break;

                        case 'youtube':
                            HaruVidi.video.muted = true;

                            break;

                        case 'twitch':
                            HaruVidi.video.muted = true;

                            break;

                        case 'dailymotion':
                            HaruVidi.video.muted = true;

                            break;

                        case 'facebook':
                            // @TODO: doesn't work safari & iOS
                            HaruVidi.video.muted = false;

                            break;
                            
                        case 'selfhost':
                            // @TODO: check video player js library
                            HaruVidi.video.muted = true;

                            break;

                        case 'google':
                            // @TODO: check video player js library
                            HaruVidi.video.muted = true;

                            break;                              
                    }
                } else {
                    if ( autoplay == true ) {
                        switch ( serverAPI ) {
                            case 'vimeo':
                                if ( HaruVidi.video.isSafari() ) {
                                    HaruVidi.video.muted = true;
                                }

                                break;

                            case 'youtube':
                                if ( HaruVidi.video.isSafari() ) {
                                    HaruVidi.video.muted = true;
                                }

                                break;

                            case 'twitch':
                                if ( HaruVidi.video.isSafari() ) {
                                    HaruVidi.video.muted = true;
                                }

                                break;

                            case 'dailymotion':
                                if ( HaruVidi.video.isSafari() ) {
                                    HaruVidi.video.muted = true;
                                }

                                break;

                            case 'facebook':
                                // @TODO: doesn't work safari & iOS
                                HaruVidi.video.muted = true;

                                break;
                                
                            case 'selfhost':
                                // @TODO: check video player js library
                                HaruVidi.video.muted = true;

                                break;

                            case 'google':
                                // @TODO: check video player js library
                                HaruVidi.video.muted = true;

                                break;                              
                        }
                    }
                }

                if ( autoplay == true ) {
                    setTimeout(function() {
                        $('.video-player-direct').trigger('click');
                    }, 10);
                }
            }
        },
        beforeAjax: function() {
            $('.haru-ajax-overflow').addClass('active');
        },
        afterAjax: function() {
            $('.haru-ajax-overflow').removeClass('active');
        },
        displayVideoPlayerPopup: function() {
            $('.video-player-popup').off().on('click', function(e) {
                e.preventDefault();
                var video_id = $(this).data('id');
                var playlist_id = $(this).data('playlist');
                var playerID = 'youtube-video'; // @TODO: need change here

                if ( HaruVidi.video.videos_data[video_id] != undefined ) {
                    $('body').find('.haru-lightbox-content').remove();
                    $('body').find('.haru-lightbox').append( HaruVidi.video.videos_data[video_id] );
                    $('body').find('.haru-lightbox-overlay').addClass('show-lightbox');
                    $('body').find('.haru-lightbox').addClass('show-lightbox');

                    HaruVidi.video.displayVideoPlayerDirect();
                    HaruVidi.video.playlistScrollBar();
                    HaruVidi.video.getVideoPlayerPopupAjax();

                    return;
                }

                $.ajax({
                    url: haru_vidi_ajax_url,
                    type: "POST",
                    data: {
                        action: 'haru_video_player_popup_content',
                        video_id: video_id,
                        playlist_id: playlist_id
                    },
                    dataType: "html",
                    beforeSend: function() {
                        HaruVidi.video.beforeAjax();
                    }
                }).success(function(result) {
                    HaruVidi.video.afterAjax();

                    if ( result ) {
                        $('body').find('.haru-lightbox-content').remove();
                        $('body').find('.haru-lightbox').append(result);
                        $('body').find('.haru-lightbox-overlay').addClass('show-lightbox');
                        $('body').find('.haru-lightbox').addClass('show-lightbox');                       

                        // Actions after ajax
                        HaruVidi.video.displayVideoPlayerDirect();
                        HaruVidi.video.playlistScrollBar();
                        HaruVidi.video.getVideoPlayerPopupAjax(); // @TODO: for Playlist
                    }

                    $('.close-lightbox').off().on('click', function() {
                        $('body').find('.haru-lightbox-content').remove();
                        $('body').find('.haru-lightbox-overlay').removeClass('show-lightbox');
                        $('body').find('.haru-lightbox').removeClass('show-lightbox');
                    });
                });
            });
        },
        getVideoPlayerPopupAjax: function() {
            $('.popup-playlist .video-item').each(function() {
                var $self = $(this);

                $(this).find('.video-player-popup-ajax').off().on('click', function(e) {
                    e.preventDefault();
                    var video_id = $(this).data('id');

                    $.ajax({
                        url: haru_vidi_ajax_url,
                        type: "POST",
                        data: {
                            action: 'haru_get_video_player_popup_ajax',
                            video_id: video_id
                        },
                        dataType: "html",
                        beforeSend: function() {
                            // Process animate
                        }
                    }).success(function(result) {
                        $self.addClass('active').siblings('.popup-playlist .video-item').removeClass('active');

                        $('body').find('.video-player-container').remove();
                        $('body').find('.single-video-top').prepend(result); // prepend

                        // Actions after ajax
                        HaruVidi.video.displayVideoPlayerDirect();
                        // Process
                    });
                });
            });
        },
        displayVideoPlayerDirect: function() {
            // Autoplay
            HaruVidi.video.processAutoPlay();

            // Check on iOS
            if ( HaruVidi.video.isiOS() ) {
                $('.video-toggle-fullscreen').hide();
            }

            // @TODO: ajax Youtube playlist player.getDuration is not a function
            $('.video-player-direct').off().on('click', function(e) {
                e.preventDefault();

                var $self = $(this);
                var video_id = $(this).attr('data-video-id');
                var video_server = $(this).attr('data-video-server');
                var player_js = $(this).attr('data-player');

                HaruVidi.video.videoID = video_id;
                HaruVidi.video.video_server = video_server;

                // Loading icon
                $self.parents('.video-image').addClass('loading');

                // Do not use Player JS
                if( player_js == 'none' ) {
                    // Youtube
                    if ( video_server == 'youtube' ) {
                        // Do something
                        HaruVidi.video.youtubeAPIReady(video_id);
                    }
                    // Vimeo
                    if ( video_server == 'vimeo' ) {
                        // Do something
                        HaruVidi.video.vimeoAPIReady();
                    }
                    // Twitch
                    if ( video_server == 'twitch' ) {
                        // Do something
                        HaruVidi.video.twitchAPIReady();
                    }
                    // Dailymotion
                    if ( video_server == 'dailymotion' ) {
                        // Do something
                        HaruVidi.video.dailymotionAPIReady();
                    }
                    // Facebook
                    if ( video_server == 'facebook' ) {
                        // Do something
                        HaruVidi.video.facebookAPIReady();
                    }
                    // Google or SelfHosted
                    if ( video_server == 'selfhost' || video_server == 'google' ) {
                        // Do something
                        HaruVidi.video.selfHostAPIReady();
                    }
                    // Embed
                    if ( video_server == 'embed' ) {
                        // Do something like autoplay
                        $self.parents('.video-image').addClass('played');
                        $self.parents('.video-image').removeClass('loading');
                    }
                    // Other
                    if ( video_server == 'other' ) {
                        // Do something like autoplay
                        $self.parents('.video-image').addClass('played');
                        $self.parents('.video-image').removeClass('loading');
                    }
                }
                // Use JS Player

            });

            // Toolbar actions
            $('.toolbar-action.action-show').off().on('click', function(e) {
                var group_show = $(this).attr('data-group');

                setTimeout(function(){
                    $('.haru-slick-more-videos').not('.slick-initialized').slick();
                }, 10);

                if ( $('.toolbar-group.' + group_show).hasClass('show') ) {
                    $('.toolbar-group').removeClass('show');
                    $('.toolbar-action.action-show').removeClass('active');
                    $(this).removeClass('active');
                } else {
                    $('.toolbar-action.action-show').removeClass('active');
                    $(this).addClass('active');
                    $('.toolbar-group:not(.' + group_show + ')').removeClass('show');
                    $('.toolbar-group.' + group_show).addClass('show');
                }
            });
        },
        youtubePlayer: function(video_id) {
            // https://css-tricks.com/play-button-youtube-and-vimeo-api/
            // https://developers.google.com/youtube/iframe_api_reference
            // https://chromatichq.com/blog/working-youtube-player-api-iframe-embeds
            // Failed to execute 'postMessage' on 'DOMWindow': The target origin provided (not use HTTPS)             
            var youtubeScriptId = 'youtube-api';
            var youtubeScript = document.getElementById(youtubeScriptId);

            // Load YouTube API script
            if ( youtubeScript === null ) {
                var tag = document.createElement('script');
                    tag.src = 'https://www.youtube.com/iframe_api';
                var firstScriptTag = document.getElementsByTagName('script')[0];
                    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
            }

            window.onYouTubeIframeAPIReady = function() {
                $(document).trigger('youtubeAPIReady' + video_id);
            };
        },
        youtubeAPIReady: function(video_id) {
            $(document).on('youtubeAPIReady' + video_id, function(){
                var player;
                var playerWrap = $('#youtube-video').parents('.haru-video-player');

                // Remove loading and add played video
                playerWrap.find('.video-image').removeClass('loading').addClass('played');

                // https://developers.google.com/youtube/player_parameters
                var options = {
                        autoplay:       1,
                        enablejsapi:    1,
                        iv_load_policy: 1,
                        modestbranding: 1,
                        playsinline:    1,
                        rel:            0
                    }

                player = new YT.Player('youtube-video', {
                    videoId: String(HaruVidi.video.videoID),
                    playerVars: options,
                    events: {
                        // Call this function when player is ready to use
                        'onReady': function() {
                            if ( HaruVidi.video.muted == true ) {
                                player.mute();
                            }
                            player.playVideo(); // Autoplay

                            // Do something
                            $('.video-youtube-unmute').on('click', function() {
                                player.unMute();

                                $(this).hide(300);
                            });
                        },
                        'onStateChange': function(e){
                            if ( e.data === 0 ) {
                                console.log('Player Ended');
                                
                                if ( HaruVidi.video.autoNextStatus() == true ) {
                                    HaruVidi.video.autoNextProcess({
                                        'playerWrap': playerWrap
                                    });
                                }
                                
                                e.target.stopVideo();
                            }
                        }
                    }
                });
            });

            HaruVidi.video.youtubePlayer(video_id);
        },
        vimeoAPIReady: function() {
            // https://developer.vimeo.com/player/sdk/reference#play-a-video
            $(document).on('vimeoAPIReady', function(){
                var player;
                var playerWrap = $('#vimeo-video').parents('.haru-video-player');

               // Remove loading and add played video
                playerWrap.find('.video-image').removeClass('loading').addClass('played');

                // https://vimeo.zendesk.com/hc/en-us/articles/360001494447-Using-Player-Parameters
                var options = {
                        id:             String(HaruVidi.video.videoID),
                        autoplay:       1,
                        muted:          HaruVidi.video.muted,
                        playsinline:    true,
                    }

                player = new Vimeo.Player('vimeo-video',
                    options
                );

                player.ready().then(function(){
                    // Mobile iOS @TODO: now use auto click play or must use muted
                    player.play().then(function() {
                        // The video is playing
                        }).catch(function(error) {
                            switch (error.name) {
                                case 'PasswordError':
                                    // The video is password-protected
                                    break;

                                case 'PrivacyError':
                                    // The video is private
                                    break;

                                default:
                                    // Some other error occurred
                                    break;
                        }
                    });

                    player.on('play', function(e) {
                        // Do something
                    });

                    player.on('ended', function(){
                        console.log('Video Ended');

                        if ( HaruVidi.video.autoNextStatus() == true ) {
                            HaruVidi.video.autoNextProcess({
                                'playerWrap': playerWrap
                            });
                        }
                    });
                });
            });

            HaruVidi.video.playerAPIReady('vimeo');
        },
        twitchAPIReady: function() {
            // https://dev.twitch.tv/docs/embed/everything
            $(document).on('twitchAPIReady', function(){
                var player;
                var playerWrap = $('#twitch-video').parents('.haru-video-player');

                // Remove loading and add played video
                playerWrap.find('.video-image').removeClass('loading').addClass('played');

                // https://dev.twitch.tv/docs/embed/video-and-clips#interactive-frames-for-live-streams-and-vods
                // https://discuss.dev.twitch.tv/t/twitch-embedded-player-updates-in-2020/23956
                var options = {
                        video:          String(HaruVidi.video.videoID),
                        autoplay:       true,
                        playsinline:    true,
                        muted:      HaruVidi.video.muted,
                        parent:     [window.location.hostname, 'www' + window.location.hostname], // require parent and https
                        controls: true
                    }

                player = new Twitch.Embed('twitch-video',
                    options
                );

                player.addEventListener(Twitch.Player.READY, function() {
                    player.play();

                    player.addEventListener(Twitch.Player.PLAY, function() {
                        // Do something
                    });

                    player.addEventListener(Twitch.Player.ENDED, function() {
                        console.log('Video Ended');

                        if ( HaruVidi.video.autoNextStatus() == true ) {
                            HaruVidi.video.autoNextProcess({
                                'playerWrap': playerWrap
                            });
                        }
                    });
                });
            });

            HaruVidi.video.playerAPIReady('twitch');
        },
        dailymotionAPIReady: function() {
            // https://developer.dailymotion.com/player/
            $(document).on('dailymotionAPIReady', function(){
                var player;
                var playerWrap = $('#dailymotion-video').parents('.haru-video-player');

                // Remove loading and add played video
                playerWrap.find('.video-image').removeClass('loading').addClass('played');

                // https://developer.dailymotion.com/player/#player-oembed-params
                var options = {
                        video: String(HaruVidi.video.videoID),
                        width: "100%", 
                        height: "100%",
                        params: { 
                            'autoplay': true,
                            'mute': HaruVidi.video.muted,
                            'queue-enable': false,
                            'sharing-enable': false,
                            'playsinline': true,
                            'webkit-playsinline': true,
                            'ui-logo': false
                        }
                    }

                player = DM.player(document.getElementById( 'dailymotion-video' ), 
                    options
                );

                // https://developer.dailymotion.com/player/#player-api-events-player
                player.addEventListener('apiready', function() {
                    player.addEventListener('playing', function() {
                        // Do something
                    });

                    player.addEventListener('video_end', function() {
                        console.log('Video Ended');

                        if ( HaruVidi.video.autoNextStatus() == true ) {
                            HaruVidi.video.autoNextProcess({
                                'playerWrap': playerWrap
                            });
                        }
                    });
                });
            });

            HaruVidi.video.playerAPIReady('dailymotion');
        },
        facebookAPIReady: function() {
            // https://developers.facebook.com/docs/plugins/embedded-video-player/api/
            $(document).on('facebookAPIReady', function(){
                var player;
                var playerWrap = $('#facebook-video').parents('.haru-video-player');

                // Remove loading and add played video
                playerWrap.find('.video-image').removeClass('loading').addClass('played');

                // Set attribute for Facebook video player
                var options = {
                        'data-autoplay': 'true',
                    }
                $('#facebook-video').attr( options );

                // Get Embedded Video Player API Instance
                FB.Event.subscribe('xfbml.ready', function(msg) {
                    if ( msg.type === 'video' && msg.id === 'facebook-video' ) {
                        player = msg.instance;

                        if ( HaruVidi.video.muted ) {
                            player.mute();
                        }
                        player.play();
                    }

                    var videoEventStarted = player.subscribe('startedPlaying', function(e) {
                        // Do something
                    });

                    var videoEventPause = player.subscribe('paused', function(e) {
                        // Do something
                    });

                    var videoEventFinished = player.subscribe('finishedPlaying', function(e) {
                        console.log('Video Ended');

                        if ( HaruVidi.video.autoNextStatus() == true ) {
                            HaruVidi.video.autoNextProcess({
                                'playerWrap': playerWrap
                            });
                        }
                    });
                });
            });

            HaruVidi.video.playerAPIReady('facebook');
        },
        selfHostAPIReady: function() {
            $(document).on('selfHostAPIReady', function(){
                var player;
                var playerWrap = $('#video-player').parents('.haru-video-player');

                // Remove loading and add played video
                playerWrap.find('.video-image').removeClass('loading').addClass('played');

                if ( !player ) {
                    $('#video-player').mediaelementplayer({
                        stretching: 'fill', // responsive, none, fill
                        videoWidth: '100%',
                        videoHeight: '100%',
                        loop: false,
                        features: ['playpause', 'progress', 'current', 'duration', 'volume', 'fullscreen'],
                        // setDimensions: false,
                        // pluginPath: "/path/to/shims/",
                        // When using jQuery's `mediaelementplayer`, an `instance` argument
                        // is available in the `success` callback
                        success: function(mediaElement, originalNode, instance) {
                            player = mediaElement;

                            // Do something
                            player.load();

                            if ( HaruVidi.video.muted == true ) {
                                player.setMuted(true);
                            }
                            
                            setTimeout(function() {
                                player.play();
                            }, 10);

                            player.addEventListener('loadedmetadata', function(){
                                player.addEventListener('playing', function(){
                                    // Do something
                                    $('.video-mediaelement-unmute').on('click', function() {
                                        player.setMuted(false);

                                        $(this).hide(300);
                                    });
                                });

                                player.addEventListener('ended', function(){
                                    console.log('Player Ended');

                                    if ( HaruVidi.video.autoNextStatus() == true ) {
                                        HaruVidi.video.autoNextProcess({
                                            'playerWrap': playerWrap
                                        });
                                    }
                                });
                            });

                        }
                    });
                }
            });

            HaruVidi.video.playerAPIReady('selfhost');
        },
        playerAPIReady: function(serverAPI) {
            // Load serverAPI Script if need
            switch ( serverAPI ) {
                case 'vimeo':
                    if ( typeof(Vimeo) !== 'undefined' && typeof(Vimeo.Player) !== 'undefined' ) {
                        $(document).trigger('vimeoAPIReady');
                    } else {
                        var script_url = 'https://player.vimeo.com/api/player.js';

                        $.getScript( script_url, function() {
                            $(document).trigger('vimeoAPIReady');
                        });
                    }
                    
                    break;

                case 'twitch':
                    if ( typeof(Twitch) !== 'undefined' && typeof(Twitch.Player) !== 'undefined' ) {
                        $(document).trigger('twitchAPIReady');
                    } else {
                        var script_url = 'https://embed.twitch.tv/embed/v1.js';

                        $.getScript( script_url, function() {
                            $(document).trigger('twitchAPIReady');
                        });
                    }
                    
                    break;

                case 'dailymotion':
                    if ( typeof(DM) !== 'undefined' && typeof(DM.player) !== 'undefined' ) {
                        $(document).trigger('dailymotionAPIReady');
                    } else {
                        var script_url = 'https://api.dmcdn.net/all.js';

                        $.getScript( script_url, function() {
                            $(document).trigger('dailymotionAPIReady');
                        });
                    }
                    
                    break;

                case 'facebook':
                    if ( typeof(FB) !== 'undefined' && typeof(FB.Event) !== 'undefined' ) {
                        $(document).trigger('facebookAPIReady');
                    } else {
                        var script_url = 'https://connect.facebook.net/en_US/sdk.js?xfbml=1&version=v3.2';

                        $.getScript( script_url, function() {
                            $(document).trigger('facebookAPIReady');
                        });
                    }
                    
                    break;
                    
                case 'selfhost':
                    $(document).trigger('selfHostAPIReady');

                    break;

                case 'google':
                    $(document).trigger('selfHostAPIReady');

                    break;                              
            }
        },
        autoNextStatus: function() {
            HaruVidi.video.videoAutoNext();

            if ( typeof(Cookies.get('videoautonext')) !== 'undefined' ) {
                HaruVidi.video.auto_next = Cookies.get('videoautonext') == 'true' ? true : false;
            }  

            if ( HaruVidi.video.auto_next == true ) {           
                $('.video-auto-next').addClass('active');

                return true;      
            } else {
                return false;
            }
        },
        videoAutoNext: function() {
            $('.video-auto-next').off().on('click', function(e) {
                $(this).toggleClass('active');

                if ( $(this).hasClass('active') ) {
                    Cookies.set('videoautonext', 'true', { 
                        expires: 1
                    });
                } else {
                    Cookies.set('videoautonext', 'false', { 
                        expires: 1
                    });
                }
            });
        },
        autoNextProcess: function( params ) {
            var playerWrap = params.playerWrap;
            var autoNextUrl = playerWrap.find('.video-auto-next-wrap').attr('data-next-url');
            var autoNextTimer = playerWrap.find('.progess-time-remain');
            var autoNextSeconds = 10;

            // @TODO: check last video auto next
            if ( typeof( autoNextUrl ) === 'undefined' ) {
                return;
            }

            playerWrap.find('.video-auto-next-wrap').addClass('active');
            autoNextTimer.text(autoNextSeconds);

            playerWrap.find('.progess-time').addClass('active');
            var autoNextInterval = setInterval(function() {
                autoNextSeconds--;
                if ( autoNextSeconds === 0 ) {
                    playerWrap.find('.progess-time').removeClass('active');
                    clearInterval(autoNextInterval);
                }
                
                autoNextTimer.text(autoNextSeconds);
            }, 1000);

            var autoNextCancel = null;
                
                autoNextCancel = setTimeout(function() {
                    if ( autoNextCancel !== null ) {
                        clearTimeout(autoNextCancel);
                    }

                    window.location.href = autoNextUrl;

                }, autoNextSeconds * 1000);

            playerWrap.find('.video-next-cancel').off().on('click', function() {
                if ( autoNextCancel !== null ) {
                    clearTimeout(autoNextCancel);
                }

                playerWrap.find('.progess-time').removeClass('active'); // @TODO: autoNextTimer.text(0); 

                return false;
            });
        },
        isMobileOS: function() {
            var check = false;

            (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);

            return check;
        },
        isiOS: function() {
            var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

            return iOS;
        },
        isSafari: function() {
            // https://stackoverflow.com/questions/9847580/how-to-detect-safari-chrome-ie-firefox-and-opera-browser/9851769
            // Safari 3.0+ "[object HTMLElementConstructor]" 
            var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));

            return isSafari;
        },
        playlistScrollBar: function() {
            if ( $('.single-video-playlist .playlist-videos').length > 0 ) {
                // More options: http://manos.malihu.gr/jquery-custom-content-scroller/
                var active_index = $('.single-video-playlist .playlist-videos').find('li.video-item.active').index();

                $('.single-video-playlist .playlist-videos').mCustomScrollbar({
                    axis: 'y', // vertical scrollbar
                    autoHideScrollbar: false,                
                    autoExpandScrollbar: false,
                    scrollButtons: {
                        enable: true,
                        scrollType: 'stepped'
                    },
                    keyboard: {
                        scrollType: 'stepped'
                    },
                    mouseWheel: {
                        scrollAmount: 188,
                        normalizeDelta: true
                    },
                    theme: 'minimal-dark',
                    callbacks: {
                        onInit:function(){
                            if ( active_index != -1 ) {
                                $('.single-video-playlist .playlist-videos').mCustomScrollbar('scrollTo',$('.single-video-playlist .playlist-videos').find('.mCSB_container').find('li.video-item:eq('+ (active_index) + ')'));
                            }
                        }
                    }
                });
            }
        },
        turnOffLight: function() {
            $('.video-turn-off-light').on('click', function() {
                $('body').toggleClass('video-light-off');
                $(this).toggleClass('active');
            });
        },
        floatingPlayer: function() {
            if ( $('.video-player-wrap').length ) {
                var playerWrap = $('.video-player-wrap');
                var playerOffset = playerWrap.offset().top + playerWrap.outerHeight(true);

                $(window).on('scroll', function() {
                    if ( !$('body').hasClass('floating-video-disabled') ) {
                        if ( $(this).scrollTop() > playerOffset ) {
                            $('body').addClass('floating-video');
                            $('.video-player-container').addClass('floating-video');
                            $(document).trigger('floatingVideoEnable'); // Use this for responsive Google Ads
                        } else {
                            $('body').removeClass('floating-video');
                            $('.video-player-container').removeClass('floating-video');
                            $(document).trigger('floatingVideoDisable'); // Use this for responsive Google Ads
                        }
                    }
                });

                $('.video-float__close').on('click', function() {
                    $('body').addClass('floating-video-disabled');
                    $('body').removeClass('floating-video');
                    $('.video-player-container').removeClass('floating-video');
                });
            }
        },
        videoRating: function() {
            $('.post-rating').each(function(){
                var $rating_element  = $(this);
                var is_clicked = false;

                $rating_element.find('.action-rating').off().on('click', function(e) {
                    // Process click multitimes before ajax process
                    if ( is_clicked === true ) {
                        return;
                    }

                    is_clicked = true;

                    var post_id = $(this).data('id');
                    var post_action = $(this).attr('data-action');
                    var vote_status = $(this).attr('data-vote-status');
                    var login = $(this).attr('data-login');
                    var login_required = $(this).attr('data-login-required');

                    if ( login_required == 'yes' && login == 'false' ) {
                        return;
                    }

                    $(this).toggleClass('active').siblings('.action-rating').removeClass('active');

                    if ( $(this).hasClass('active') ) {
                        vote_status = post_action;
                    } else {
                        vote_status = '';
                    }

                    $.ajax({
                        url: haru_vidi_ajax_url,
                        type: "POST",
                        data: {
                            action: 'haru_ajax_voting',
                            post_id: post_id,
                            post_action: post_action,
                            vote_status: vote_status
                        },
                        dataType: "html",
                        beforeSend: function() {
                            // Do Somethings
                        }
                    }).success(function(result) {
                        // Do Somethings
                        result = JSON.parse(result);

                        $rating_element.attr('data-vote-status', result.vote_status);
                        $rating_element.find('.post-like-count').text(result.like_count);
                        $rating_element.find('.post-dislike-count').text(result.dislike_count);
                        $rating_element.find('.like-tooltip').text(result.message_like);
                        $rating_element.find('.dislike-tooltip').text(result.message_dislike);
                        $rating_element.find('.post-rating-percentage').css('width', result.like_percentage);
                        // For single rating count display
                        $('.post-rating-bar').find('.post-rating-percentage').css('width', result.like_percentage);
                        $('.post-rating-count').find('.post-like-count').text(result.like_count);
                        $('.post-rating-count').find('.post-dislike-count').text(result.dislike_count);

                        is_clicked = false;
                    });
                });
            });
        },
        videoScreenShots: function() {
            // https://codepen.io/ryanjbonnell/pen/dqsxI
            // https://codepen.io/dariodev/pen/PbwVxv
            $('.single-video-screenshot-btn').off().on('click', function(){
                $(this).next().magnificPopup('open');
            });

            $('.single-video-screenshots .video-screenshots').each(function(){
                $(this).magnificPopup({
                    delegate: 'a.video-screenshot',
                    type: 'image',
                    mainClass: 'video-screenshots-popup',
                    gallery: {
                        enabled: true,
                        navigateByImgClick: true,
                        preload: [0,1] // Will preload 0 - before current, and 1 after the current image
                    },
                    image: {
                        titleSrc: function(item) {
                            var $gallery = $('.video-screenshots');
                            var $result = '';
                            if ( $gallery.find('.video-screenshot').length > 0 ) {
                                $result = '<div class="mfp-pager">' + 
                                    '<div class="arrow_prev">' +
                                        '<button type="button" class="prev arrow" onclick="javascript:jQuery(\'.video-screenshots\').magnificPopup(\'prev\');return false;">Previous</button>' +
                                    '</div>' + 
                                    '<div class="dots">' +
                                        '<ul class="dots" style="display: inline-block;">';
                                for ( var i = 0; i < $gallery.find('.video-screenshot').length; i++ ) {
                                    var $cl_active = '';
                                    if ( item.index == i ) $cl_active = ' class="active"'; else $cl_active = '';
                                    var $thumb = $gallery.find('.video-screenshot:eq('+ i +')').attr('href');
                                    $result += '<li' + $cl_active + '>' +
                                            '<button type="button" onclick="javascript:jQuery(\'.video-screenshots\').magnificPopup(\'goTo\', '+ i +');return false;"><img src="' + $thumb + '" width="100"></button>' +
                                        '</li>';
                                }
                                $result += '</ul>' +
                                    '</div>' +
                                    '<div class="arrow_next">' +
                                        '<button type="button" class="next arrow" onclick="javascript:jQuery(\'.video-screenshots\').magnificPopup(\'next\');return false;">Next</button>' +
                                    '</div>' +
                                '</div>';
                            }

                            return $result;
                        }
                    }
                });

            });
        },
        videoSocialShare: function() {
            $('.single-video-share').off().on('click', function() {
                $(this).find('.video-social-share').toggle();
            });
        },
        videoToggleContent: function() {
            $('.single-video-content-btn').off().on('click', function(){
                var show_more = $(this).attr('data-show-more');
                var show_less = $(this).attr('data-show-less');

                $(this).toggleClass('active');
                $('.single-video-content').toggleClass('active');

                if ( $(this).hasClass('active') ) {
                    $(this).text(show_less);
                } else {
                    $(this).text(show_more);
                }
            });
        },
        shortcodeVideoCategory: function() {
            var video_category_data = []; // Use this for video category shortcode
            var video_category_control = [];

            $('.video-category-shortcode').each(function() {
                var element         = $(this);
                var element_id      = element.attr('id');
                var atts            = element.data('atts');


                if ( atts['filter'] != 'hide' ) {
                    var category        = element.find('.video-filter .filter-item:first').attr('data-category');
                    var max_pages       = parseInt(element.find('.video-control-item').attr('data-max_pages'));
                    var current_page    = parseInt(element.find('.video-control-item').attr('data-current_page'));

                    // Save first load to cache
                    var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-1';
                    var tab_control_index = element_id + '-' + category.toString().split(',').join('-');

                    video_category_data[tab_data_index] = element.find('.video-category-content').clone(true);
                    video_category_control[tab_control_index] = [category, max_pages, current_page];

                    element.find('.video-filter .filter-item').off().on('click', function() {
                        // Check if already click or loading
                        if ( $(this).hasClass('active') || element.find('.video-ajax-content').hasClass('loading') ) {
                            return;
                        }

                        element.find('.video-filter .filter-item').removeClass('active');
                        $(this).addClass('active');

                        // Check cache
                        var category            = $(this).data('category');
                        var tab_control_index   = element_id + '-' + category.toString().split(',').join('-');

                        if ( video_category_control[tab_control_index] != undefined ) {
                            element.find('.video-category-content').remove();

                            var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-' + video_category_control[tab_control_index][2].toString();

                            element.find('.video-ajax-content').append( video_category_data[tab_data_index] );
                            element.find('.video-control .video-control-item').attr('data-category', video_category_control[tab_control_index][0]);
                            element.find('.video-control .video-control-item').attr('data-max_pages', video_category_control[tab_control_index][1]);
                            element.find('.video-control .video-control-item').attr('data-current_page', video_category_control[tab_control_index][2]);
                            // Check show/hide control
                            if ( video_category_control[tab_control_index][1] <= 1 ) {
                                element.find('.video-control').addClass('hide');
                            } else {
                                element.find('.video-control').removeClass('hide');
                            }
                            // Check last page, first page
                            if ( video_category_control[tab_control_index][2] == video_category_control[tab_control_index][1] ) {
                                element.find('.video-control .video-control-item[data-action="prev"]').removeClass('disable');
                                element.find('.video-control .video-control-item[data-action="next"]').addClass('disable');
                            } else if ( video_category_control[tab_control_index][2] == 1 ) {
                                element.find('.video-control .video-control-item[data-action="prev"]').addClass('disable');
                                element.find('.video-control .video-control-item[data-action="next"]').removeClass('disable');
                            } else {
                                element.find('.video-control .video-control-item[data-action="prev"]').removeClass('disable');
                                element.find('.video-control .video-control-item[data-action="next"]').removeClass('disable');
                            }

                            return;
                        }

                        // Load content via ajax
                        element.find('.video-ajax-content').addClass('loading');

                        $.ajax({
                            type : "POST",
                            timeout : 30000,
                            url : haru_vidi_ajax_url,
                            data : {
                                action: 'haru_get_video_category', 
                                atts: atts, 
                                category: category
                            },
                            error: function(xhr,err) {
                                console.log('Have something wrong! Please try again!');
                            },
                            success: function(response) {
                                if ( response ) {
                                    element.find('.video-category-content').remove();
                                    element.find('.video-ajax-content').append( response );       

                                    // Save cache
                                    var tab_data_index      = element_id + '-' + category.toString().split(',').join('-') + '-page-1';
                                    video_category_data[tab_data_index] = response;

                                    // Do something
                                    var max_pages = parseInt(element.find('.video-category-content').attr('data-max_pages'));
                                    video_category_control[tab_control_index] = [category, max_pages, 1];
                                    // Check show/hide control
                                    if ( max_pages <= 1 ) {
                                        // Do something
                                        element.find('.video-control').addClass('hide');
                                    } else {
                                        element.find('.video-control').removeClass('hide');
                                    }
                                    // Set new value for control
                                    element.find('.video-control .video-control-item').attr('data-category', category);
                                    element.find('.video-control .video-control-item').attr('data-max_pages', max_pages);
                                    element.find('.video-control .video-control-item').attr('data-current_page', 1);
                                    // Check last page, first page
                                    element.find('.video-control .video-control-item[data-action="prev"]').addClass('disable');
                                    element.find('.video-control .video-control-item[data-action="next"]').removeClass('disable');
                                }
                                element.find('.video-ajax-content').removeClass('loading');
                            }
                        });
                    });
                } else {
                    var category        = element.find('.video-control-item').attr('data-category');
                    var max_pages       = parseInt(element.find('.video-control-item').attr('data-max_pages'));
                    var current_page    = parseInt(element.find('.video-control-item').attr('data-current_page'));

                    // Save first load to cache
                    var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-1';
                    var tab_control_index = element_id + '-' + category.toString().split(',').join('-');

                    video_category_data[tab_data_index] = element.find('.video-category-content').clone(true);
                    video_category_control[tab_control_index] = [category, max_pages, current_page];
                }

                // Next/Prev control
                element.find('.video-control .video-control-item').off().on('click', function() {
                    // Check if already click or loading
                    if ( $(this).hasClass('disable') || element.find('.video-ajax-content').hasClass('loading') ) {
                        return;
                    }

                    var category        = $(this).attr('data-category');
                    var max_pages       = parseInt($(this).attr('data-max_pages'));
                    var action          = $(this).attr('data-action');

                    if ( action == 'next' ) {
                        var current_page    = parseInt($(this).attr('data-current_page'));

                        if ( (current_page + 1) <= max_pages ) {
                            // Check cache
                            var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-' + ( current_page + 1 );
                            var tab_control_index = element_id + '-' + category.toString().split(',').join('-');

                            if ( video_category_data[tab_data_index] != undefined ) {
                                element.find('.video-category-content').remove();
                                element.find('.video-ajax-content').append( video_category_data[tab_data_index] );
                                
                                // Do something
                                element.find('.video-control .video-control-item').attr('data-current_page', current_page + 1);
                                video_category_control[tab_control_index] = [category, max_pages, current_page + 1];
                                // Check last page
                                element.find('.video-control .video-control-item[data-action="prev"]').removeClass('disable');
                                if ( current_page + 1 >= max_pages ) {
                                    element.find('.video-control .video-control-item[data-action="next"]').addClass('disable');
                                }

                                return;
                            }
                        
                            // Load content via ajax
                            element.find('.video-ajax-content').addClass('loading');

                            $.ajax({
                                type : "POST",
                                timeout : 30000,
                                url : haru_vidi_ajax_url,
                                data : {
                                    action: 'haru_get_video_category_next', 
                                    atts: atts, 
                                    category: category,
                                    current_page: current_page
                                },
                                error: function(xhr,err) {
                                    console.log('Have something wrong! Please try again!');
                                },
                                success: function(response) {
                                    if ( response ) {
                                        element.find('.video-category-content').remove();
                                        element.find('.video-ajax-content').append( response );       

                                        // Save cache
                                        video_category_data[tab_data_index] = response;
                                        video_category_control[tab_control_index] = [category, max_pages, current_page + 1];
                                    }
                                    // Do something
                                    element.find('.video-control .video-control-item').attr('data-current_page', current_page + 1);
                                    element.find('.video-ajax-content').removeClass('loading');
                                    // Check last page
                                    element.find('.video-control .video-control-item[data-action="prev"]').removeClass('disable');
                                    if ( current_page + 1 >= max_pages ) {
                                        element.find('.video-control .video-control-item[data-action="next"]').addClass('disable');
                                    }
                                }
                            });
                        } else {
                            return;
                        }
                    } else if ( action == 'prev' ) {
                        var current_page    = parseInt($(this).attr('data-current_page'));

                        if ( current_page == 1 ) {
                            return;
                        }

                        // Check cache
                        var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-' + ( current_page - 1 );
                        var tab_control_index = element_id + '-' + category.toString().split(',').join('-');

                        if ( video_category_data[tab_data_index] != undefined ) {
                            element.find('.video-category-content').remove();
                            element.find('.video-ajax-content').append( video_category_data[tab_data_index] );
                            
                            // Do something
                            element.find('.video-control .video-control-item').attr('data-current_page', current_page - 1);
                            video_category_control[tab_control_index] = [category, max_pages, current_page - 1];
                        }

                        // Check first page
                        element.find('.video-control .video-control-item[data-action="next"]').removeClass('disable');
                        if ( current_page - 1 <= 1 ) {
                            element.find('.video-control .video-control-item[data-action="prev"]').addClass('disable');
                        }
                    }
                });
            });
        },
        shortcodeVideoCategorySingle: function() {
            var video_category_single_data = []; // Use this for video category shortcode
            var video_category_single_control = [];

            $('.video-category-single-shortcode').each(function() {
                var element         = $(this);
                var element_id      = element.attr('id');
                var atts            = element.data('atts');

                var category        = element.find('.video-filter .filter-item:first').attr('data-category');
                var max_pages       = parseInt(element.find('.video-control-item').attr('data-max_pages'));
                var current_page    = parseInt(element.find('.video-control-item').attr('data-current_page'));

                // Save first load to cache
                var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-1';
                var tab_control_index = element_id + '-' + category.toString().split(',').join('-');

                video_category_single_data[tab_data_index] = element.find('.video-category-single-content').clone(true);
                video_category_single_control[tab_control_index] = [category, max_pages, current_page];

                // Next/Prev control
                element.find('.video-control .video-control-item').off().on('click', function() {
                    // Check if already click or loading
                    if ( $(this).hasClass('disable') || element.find('.video-ajax-content').hasClass('loading') ) {
                        return;
                    }

                    var category        = $(this).attr('data-category');
                    var max_pages       = parseInt($(this).attr('data-max_pages'));
                    var action          = $(this).attr('data-action');

                    if ( action == 'next' ) {
                        var current_page    = parseInt($(this).attr('data-current_page'));

                        if ( (current_page + 1) <= max_pages ) {
                            // Check cache
                            var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-' + ( current_page + 1 );
                            var tab_control_index = element_id + '-' + category.toString().split(',').join('-');

                            if ( video_category_single_data[tab_data_index] != undefined ) {
                                element.find('.video-category-single-content').remove();
                                element.find('.video-ajax-content').append( video_category_single_data[tab_data_index] );
                                
                                // Do something
                                element.find('.video-control .video-control-item').attr('data-current_page', current_page + 1);
                                video_category_single_control[tab_control_index] = [category, max_pages, current_page + 1];
                                // Check last page
                                element.find('.video-control .video-control-item[data-action="prev"]').removeClass('disable');
                                if ( current_page + 1 >= max_pages ) {
                                    element.find('.video-control .video-control-item[data-action="next"]').addClass('disable');
                                }

                                return;
                            }
                        
                            // Load content via ajax
                            element.find('.video-ajax-content').addClass('loading');

                            $.ajax({
                                type : "POST",
                                timeout : 30000,
                                url : haru_vidi_ajax_url,
                                data : {
                                    action: 'haru_get_video_category_single_next', 
                                    atts: atts, 
                                    category: category,
                                    current_page: current_page
                                },
                                error: function(xhr,err) {
                                    console.log('Have something wrong! Please try again!');
                                },
                                success: function(response) {
                                    if ( response ) {
                                        element.find('.video-category-single-content').remove();
                                        element.find('.video-ajax-content').append( response );       

                                        // Save cache
                                        video_category_single_data[tab_data_index] = response;
                                        video_category_single_control[tab_control_index] = [category, max_pages, current_page + 1];
                                    }
                                    // Do something
                                    element.find('.video-control .video-control-item').attr('data-current_page', current_page + 1);
                                    element.find('.video-ajax-content').removeClass('loading');
                                    // Check last page
                                    element.find('.video-control .video-control-item[data-action="prev"]').removeClass('disable');
                                    if ( current_page + 1 >= max_pages ) {
                                        element.find('.video-control .video-control-item[data-action="next"]').addClass('disable');
                                    }
                                }
                            });
                        } else {
                            return;
                        }
                    } else if ( action == 'prev' ) {
                        var current_page    = parseInt($(this).attr('data-current_page'));

                        if ( current_page == 1 ) {
                            return;
                        }

                        // Check cache
                        var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-' + ( current_page - 1 );
                        var tab_control_index = element_id + '-' + category.toString().split(',').join('-');

                        if ( video_category_single_data[tab_data_index] != undefined ) {
                            element.find('.video-category-single-content').remove();
                            element.find('.video-ajax-content').append( video_category_single_data[tab_data_index] );
                            
                            // Do something
                            element.find('.video-control .video-control-item').attr('data-current_page', current_page - 1);
                            video_category_single_control[tab_control_index] = [category, max_pages, current_page - 1];
                        }

                        // Check first page
                        element.find('.video-control .video-control-item[data-action="next"]').removeClass('disable');
                        if ( current_page - 1 <= 1 ) {
                            element.find('.video-control .video-control-item[data-action="prev"]').addClass('disable');
                        }
                    }
                });
            });
        },
        shortcodeVideoFeatured: function() {
            var video_featured_data = []; // Use this for video featured shortcode
            var video_featured_control = [];

            $('.video-featured-shortcode').each(function() {
                var element         = $(this);
                var element_id      = element.attr('id');
                var atts            = element.data('atts');


                if ( atts['filter'] != 'hide' ) {
                    var category        = element.find('.video-filter .filter-item:first').attr('data-category');
                    var max_pages       = parseInt(element.find('.video-control-item').attr('data-max_pages'));
                    var current_page    = parseInt(element.find('.video-control-item').attr('data-current_page'));

                    // Save first load to cache
                    var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-1';
                    var tab_control_index = element_id + '-' + category.toString().split(',').join('-');

                    video_featured_data[tab_data_index] = element.find('.video-featured-content').clone(true);
                    video_featured_control[tab_control_index] = [category, max_pages, current_page];

                    element.find('.video-filter .filter-item').off().on('click', function() {
                        // Check if already click or loading
                        if ( $(this).hasClass('active') || element.find('.video-ajax-content').hasClass('loading') ) {
                            return;
                        }

                        element.find('.video-filter .filter-item').removeClass('active');
                        $(this).addClass('active');

                        // Check cache
                        var category            = $(this).data('category');
                        var tab_control_index   = element_id + '-' + category.toString().split(',').join('-');

                        if ( video_featured_control[tab_control_index] != undefined ) {
                            element.find('.video-featured-content').remove();

                            var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-' + video_featured_control[tab_control_index][2].toString();

                            element.find('.video-ajax-content').append( video_featured_data[tab_data_index] );
                            element.find('.video-control .video-control-item').attr('data-category', video_featured_control[tab_control_index][0]);
                            element.find('.video-control .video-control-item').attr('data-max_pages', video_featured_control[tab_control_index][1]);
                            element.find('.video-control .video-control-item').attr('data-current_page', video_featured_control[tab_control_index][2]);
                            // Check show/hide control
                            if ( video_featured_control[tab_control_index][1] <= 1 ) {
                                element.find('.video-control').addClass('hide');
                            } else {
                                element.find('.video-control').removeClass('hide');
                            }
                            // Check last page, first page
                            if ( video_featured_control[tab_control_index][2] == video_featured_control[tab_control_index][1] ) {
                                element.find('.video-control .video-control-item[data-action="prev"]').removeClass('disable');
                                element.find('.video-control .video-control-item[data-action="next"]').addClass('disable');
                            } else if ( video_featured_control[tab_control_index][2] == 1 ) {
                                element.find('.video-control .video-control-item[data-action="prev"]').addClass('disable');
                                element.find('.video-control .video-control-item[data-action="next"]').removeClass('disable');
                            } else {
                                element.find('.video-control .video-control-item[data-action="prev"]').removeClass('disable');
                                element.find('.video-control .video-control-item[data-action="next"]').removeClass('disable');
                            }

                            return;
                        }

                        // Load content via ajax
                        element.find('.video-ajax-content').addClass('loading');

                        $.ajax({
                            type : "POST",
                            timeout : 30000,
                            url : haru_vidi_ajax_url,
                            data : {
                                action: 'haru_get_video_featured', 
                                atts: atts, 
                                category: category
                            },
                            error: function(xhr,err) {
                                console.log('Have something wrong! Please try again!');
                            },
                            success: function(response) {
                                if ( response ) {
                                    element.find('.video-featured-content').remove();
                                    element.find('.video-ajax-content').append( response );       

                                    // Save cache
                                    var tab_data_index      = element_id + '-' + category.toString().split(',').join('-') + '-page-1';
                                    video_featured_data[tab_data_index] = response;

                                    // Do something
                                    var max_pages = parseInt(element.find('.video-featured-content').attr('data-max_pages'));
                                    video_featured_control[tab_control_index] = [category, max_pages, 1];
                                    // Check show/hide control
                                    if ( max_pages <= 1 ) {
                                        // Do something
                                        element.find('.video-control').addClass('hide');
                                    } else {
                                        element.find('.video-control').removeClass('hide');
                                    }
                                    // Set new value for control
                                    element.find('.video-control .video-control-item').attr('data-category', category);
                                    element.find('.video-control .video-control-item').attr('data-max_pages', max_pages);
                                    element.find('.video-control .video-control-item').attr('data-current_page', 1);
                                    // Check last page, first page
                                    element.find('.video-control .video-control-item[data-action="prev"]').addClass('disable');
                                    element.find('.video-control .video-control-item[data-action="next"]').removeClass('disable');
                                }
                                element.find('.video-ajax-content').removeClass('loading');
                            }
                        });
                    });
                } else {
                    var category        = element.find('.video-control-item').attr('data-category');
                    var max_pages       = parseInt(element.find('.video-control-item').attr('data-max_pages'));
                    var current_page    = parseInt(element.find('.video-control-item').attr('data-current_page'));

                    // Save first load to cache
                    var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-1';
                    var tab_control_index = element_id + '-' + category.toString().split(',').join('-');

                    video_featured_data[tab_data_index] = element.find('.video-featured-content').clone(true);
                    video_featured_control[tab_control_index] = [category, max_pages, current_page];
                }

                // Next/Prev control
                element.find('.video-control .video-control-item').off().on('click', function() {
                    // Check if already click or loading
                    if ( $(this).hasClass('disable') || element.find('.video-ajax-content').hasClass('loading') ) {
                        return;
                    }

                    var category        = $(this).attr('data-category');
                    var max_pages       = parseInt($(this).attr('data-max_pages'));
                    var action          = $(this).attr('data-action');

                    if ( action == 'next' ) {
                        var current_page    = parseInt($(this).attr('data-current_page'));

                        if ( (current_page + 1) <= max_pages ) {
                            // Check cache
                            var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-' + ( current_page + 1 );
                            var tab_control_index = element_id + '-' + category.toString().split(',').join('-');

                            if ( video_featured_data[tab_data_index] != undefined ) {
                                element.find('.video-featured-content').remove();
                                element.find('.video-ajax-content').append( video_featured_data[tab_data_index] );
                                
                                // Do something
                                element.find('.video-control .video-control-item').attr('data-current_page', current_page + 1);
                                video_featured_control[tab_control_index] = [category, max_pages, current_page + 1];
                                // Check last page
                                element.find('.video-control .video-control-item[data-action="prev"]').removeClass('disable');
                                if ( current_page + 1 >= max_pages ) {
                                    element.find('.video-control .video-control-item[data-action="next"]').addClass('disable');
                                }

                                return;
                            }
                        
                            // Load content via ajax
                            element.find('.video-ajax-content').addClass('loading');

                            $.ajax({
                                type : "POST",
                                timeout : 30000,
                                url : haru_vidi_ajax_url,
                                data : {
                                    action: 'haru_get_video_featured_next', 
                                    atts: atts, 
                                    category: category,
                                    current_page: current_page
                                },
                                error: function(xhr,err) {
                                    console.log('Have something wrong! Please try again!');
                                },
                                success: function(response) {
                                    if ( response ) {
                                        element.find('.video-featured-content').remove();
                                        element.find('.video-ajax-content').append( response );       

                                        // Save cache
                                        video_featured_data[tab_data_index] = response;
                                        video_featured_control[tab_control_index] = [category, max_pages, current_page + 1];
                                    }
                                    // Do something
                                    element.find('.video-control .video-control-item').attr('data-current_page', current_page + 1);
                                    element.find('.video-ajax-content').removeClass('loading');
                                    // Check last page
                                    element.find('.video-control .video-control-item[data-action="prev"]').removeClass('disable');
                                    if ( current_page + 1 >= max_pages ) {
                                        element.find('.video-control .video-control-item[data-action="next"]').addClass('disable');
                                    }
                                }
                            });
                        } else {
                            return;
                        }
                    } else if ( action == 'prev' ) {
                        var current_page    = parseInt($(this).attr('data-current_page'));

                        if ( current_page == 1 ) {
                            return;
                        }

                        // Check cache
                        var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-' + ( current_page - 1 );
                        var tab_control_index = element_id + '-' + category.toString().split(',').join('-');

                        if ( video_featured_data[tab_data_index] != undefined ) {
                            element.find('.video-featured-content').remove();
                            element.find('.video-ajax-content').append( video_featured_data[tab_data_index] );
                            
                            // Do something
                            element.find('.video-control .video-control-item').attr('data-current_page', current_page - 1);
                            video_featured_control[tab_control_index] = [category, max_pages, current_page - 1];
                        }

                        // Check first page
                        element.find('.video-control .video-control-item[data-action="next"]').removeClass('disable');
                        if ( current_page - 1 <= 1 ) {
                            element.find('.video-control .video-control-item[data-action="prev"]').addClass('disable');
                        }
                    }
                });
            });
        },
        shortcodeVideoOrder: function() {
            var video_order_data = []; // Use this for video order shortcode
            var video_order_control = [];

            $('.video-order-shortcode').each(function() {
                var element         = $(this);
                var element_id      = element.attr('id');
                var atts            = element.data('atts');

                // Have Video filter
                var video_order     = element.find('.video-filter .filter-item:first').attr('data-video_order');
                var max_pages       = parseInt(element.find('.video-control-item').attr('data-max_pages'));
                var current_page    = parseInt(element.find('.video-control-item').attr('data-current_page'));

                // Save first load to cache
                var tab_data_index = element_id + '-' + video_order.toString().split(',').join('-') + '-page-1';
                var tab_control_index = element_id + '-' + video_order.toString().split(',').join('-');

                video_order_data[tab_data_index] = element.find('.video-order-content').clone(true);
                video_order_control[tab_control_index] = [video_order, max_pages, current_page];

                element.find('.video-filter .filter-item').off().on('click', function() {
                    // Check if already click or loading
                    if ( $(this).hasClass('active') || element.find('.video-ajax-content').hasClass('loading') ) {
                        return;
                    }

                    element.find('.video-filter .filter-item').removeClass('active');
                    $(this).addClass('active');

                    // Check cache
                    var video_order            = $(this).data('video_order');
                    var tab_control_index   = element_id + '-' + video_order.toString().split(',').join('-');

                    if ( video_order_control[tab_control_index] != undefined ) {
                        element.find('.video-order-content').remove();

                        var tab_data_index = element_id + '-' + video_order.toString().split(',').join('-') + '-page-' + video_order_control[tab_control_index][2].toString();

                        element.find('.video-ajax-content').append( video_order_data[tab_data_index] );
                        element.find('.video-control .video-control-item').attr('data-video_order', video_order_control[tab_control_index][0]);
                        element.find('.video-control .video-control-item').attr('data-max_pages', video_order_control[tab_control_index][1]);
                        element.find('.video-control .video-control-item').attr('data-current_page', video_order_control[tab_control_index][2]);
                        // Check show/hide control
                        if ( video_order_control[tab_control_index][1] <= 1 ) {
                            element.find('.video-control').addClass('hide');
                        } else {
                            element.find('.video-control').removeClass('hide');
                        }
                        // Check last page, first page
                        if ( video_order_control[tab_control_index][2] == video_order_control[tab_control_index][1] ) {
                            element.find('.video-control .video-control-item[data-action="prev"]').removeClass('disable');
                            element.find('.video-control .video-control-item[data-action="next"]').addClass('disable');
                        } else if ( video_order_control[tab_control_index][2] == 1 ) {
                            element.find('.video-control .video-control-item[data-action="prev"]').addClass('disable');
                            element.find('.video-control .video-control-item[data-action="next"]').removeClass('disable');
                        } else {
                            element.find('.video-control .video-control-item[data-action="prev"]').removeClass('disable');
                            element.find('.video-control .video-control-item[data-action="next"]').removeClass('disable');
                        }

                        return;
                    }

                    // Load content via ajax
                    element.find('.video-ajax-content').addClass('loading');

                    $.ajax({
                        type : "POST",
                        timeout : 30000,
                        url : haru_vidi_ajax_url,
                        data : {
                            action: 'haru_get_video_order', 
                            atts: atts, 
                            video_order: video_order
                        },
                        error: function(xhr,err) {
                            console.log('Have something wrong! Please try again!');
                        },
                        success: function(response) {
                            if ( response ) {
                                element.find('.video-order-content').remove();
                                element.find('.video-ajax-content').append( response );       

                                // Save cache
                                var tab_data_index      = element_id + '-' + video_order.toString().split(',').join('-') + '-page-1';
                                video_order_data[tab_data_index] = response;

                                // Do something
                                var max_pages = parseInt(element.find('.video-order-content').attr('data-max_pages'));
                                video_order_control[tab_control_index] = [video_order, max_pages, 1];
                                // Check show/hide control
                                if ( max_pages <= 1 ) {
                                    // Do something
                                    element.find('.video-control').addClass('hide');
                                } else {
                                    element.find('.video-control').removeClass('hide');
                                }
                                // Set new value for control
                                element.find('.video-control .video-control-item').attr('data-video_order', video_order);
                                element.find('.video-control .video-control-item').attr('data-max_pages', max_pages);
                                element.find('.video-control .video-control-item').attr('data-current_page', 1);
                                // Check last page, first page
                                element.find('.video-control .video-control-item[data-action="prev"]').addClass('disable');
                                element.find('.video-control .video-control-item[data-action="next"]').removeClass('disable');
                            }
                            element.find('.video-ajax-content').removeClass('loading');
                        }
                    });
                });

                // Next/Prev control
                element.find('.video-control .video-control-item').off().on('click', function() {
                    // Check if already click or loading
                    if ( $(this).hasClass('disable') || element.find('.video-ajax-content').hasClass('loading') ) {
                        return;
                    }

                    var video_order        = $(this).attr('data-video_order');
                    var max_pages       = parseInt($(this).attr('data-max_pages'));
                    var action          = $(this).attr('data-action');

                    if ( action == 'next' ) {
                        var current_page    = parseInt($(this).attr('data-current_page'));

                        if ( (current_page + 1) <= max_pages ) {
                            // Check cache
                            var tab_data_index = element_id + '-' + video_order.toString().split(',').join('-') + '-page-' + ( current_page + 1 );
                            var tab_control_index = element_id + '-' + video_order.toString().split(',').join('-');

                            if ( video_order_data[tab_data_index] != undefined ) {
                                element.find('.video-order-content').remove();
                                element.find('.video-ajax-content').append( video_order_data[tab_data_index] );
                                
                                // Do something
                                element.find('.video-control .video-control-item').attr('data-current_page', current_page + 1);
                                video_order_control[tab_control_index] = [video_order, max_pages, current_page + 1];
                                // Check last page
                                element.find('.video-control .video-control-item[data-action="prev"]').removeClass('disable');
                                if ( current_page + 1 >= max_pages ) {
                                    element.find('.video-control .video-control-item[data-action="next"]').addClass('disable');
                                }

                                return;
                            }
                        
                            // Load content via ajax
                            element.find('.video-ajax-content').addClass('loading');

                            $.ajax({
                                type : "POST",
                                timeout : 30000,
                                url : haru_vidi_ajax_url,
                                data : {
                                    action: 'haru_get_video_order_next', 
                                    atts: atts, 
                                    video_order: video_order,
                                    current_page: current_page
                                },
                                error: function(xhr,err) {
                                    console.log('Have something wrong! Please try again!');
                                },
                                success: function(response) {
                                    if ( response ) {
                                        element.find('.video-order-content').remove();
                                        element.find('.video-ajax-content').append( response );       

                                        // Save cache
                                        video_order_data[tab_data_index] = response;
                                        video_order_control[tab_control_index] = [video_order, max_pages, current_page + 1];
                                    }
                                    // Do something
                                    element.find('.video-control .video-control-item').attr('data-current_page', current_page + 1);
                                    element.find('.video-ajax-content').removeClass('loading');
                                    // Check last page
                                    element.find('.video-control .video-control-item[data-action="prev"]').removeClass('disable');
                                    if ( current_page + 1 >= max_pages ) {
                                        element.find('.video-control .video-control-item[data-action="next"]').addClass('disable');
                                    }
                                }
                            });
                        } else {
                            return;
                        }
                    } else if ( action == 'prev' ) {
                        var current_page    = parseInt($(this).attr('data-current_page'));

                        if ( current_page == 1 ) {
                            return;
                        }

                        // Check cache
                        var tab_data_index = element_id + '-' + video_order.toString().split(',').join('-') + '-page-' + ( current_page - 1 );
                        var tab_control_index = element_id + '-' + video_order.toString().split(',').join('-');

                        if ( video_order_data[tab_data_index] != undefined ) {
                            element.find('.video-order-content').remove();
                            element.find('.video-ajax-content').append( video_order_data[tab_data_index] );
                            
                            // Do something
                            element.find('.video-control .video-control-item').attr('data-current_page', current_page - 1);
                            video_order_control[tab_control_index] = [video_order, max_pages, current_page - 1];
                        }

                        // Check first page
                        element.find('.video-control .video-control-item[data-action="next"]').removeClass('disable');
                        if ( current_page - 1 <= 1 ) {
                            element.find('.video-control .video-control-item[data-action="prev"]').addClass('disable');
                        }
                    }
                });
            });
        },
        shortcodeVideoOrderSingle: function() {
            var video_order_single_data = []; // Use this for video order shortcode
            var video_order_single_control = [];

            $('.video-order-single-shortcode').each(function() {
                var element         = $(this);
                var element_id      = element.attr('id');
                var atts            = element.data('atts');

                // Have Video filter
                var video_order     = element.find('.video-filter .filter-item:first').attr('data-video_order');
                var max_pages       = parseInt(element.find('.video-control-item').attr('data-max_pages'));
                var current_page    = parseInt(element.find('.video-control-item').attr('data-current_page'));

                // Save first load to cache
                var tab_data_index = element_id + '-' + video_order.toString().split(',').join('-') + '-page-1';
                var tab_control_index = element_id + '-' + video_order.toString().split(',').join('-');

                video_order_single_data[tab_data_index] = element.find('.video-order-single-content').clone(true);
                video_order_single_control[tab_control_index] = [video_order, max_pages, current_page];

                // Next/Prev control
                element.find('.video-control .video-control-item').off().on('click', function() {
                    // Check if already click or loading
                    if ( $(this).hasClass('disable') || element.find('.video-ajax-content').hasClass('loading') ) {
                        return;
                    }

                    var video_order        = $(this).attr('data-video_order');
                    var max_pages       = parseInt($(this).attr('data-max_pages'));
                    var action          = $(this).attr('data-action');

                    if ( action == 'next' ) {
                        var current_page    = parseInt($(this).attr('data-current_page'));

                        if ( (current_page + 1) <= max_pages ) {
                            // Check cache
                            var tab_data_index = element_id + '-' + video_order.toString().split(',').join('-') + '-page-' + ( current_page + 1 );
                            var tab_control_index = element_id + '-' + video_order.toString().split(',').join('-');

                            if ( video_order_single_data[tab_data_index] != undefined ) {
                                element.find('.video-order-single-content').remove();
                                element.find('.video-ajax-content').append( video_order_single_data[tab_data_index] );
                                
                                // Do something
                                element.find('.video-control .video-control-item').attr('data-current_page', current_page + 1);
                                video_order_single_control[tab_control_index] = [video_order, max_pages, current_page + 1];
                                // Check last page
                                element.find('.video-control .video-control-item[data-action="prev"]').removeClass('disable');
                                if ( current_page + 1 >= max_pages ) {
                                    element.find('.video-control .video-control-item[data-action="next"]').addClass('disable');
                                }

                                return;
                            }
                        
                            // Load content via ajax
                            element.find('.video-ajax-content').addClass('loading');

                            $.ajax({
                                type : "POST",
                                timeout : 30000,
                                url : haru_vidi_ajax_url,
                                data : {
                                    action: 'haru_get_video_order_single_next', 
                                    atts: atts, 
                                    video_order: video_order,
                                    current_page: current_page
                                },
                                error: function(xhr,err) {
                                    console.log('Have something wrong! Please try again!');
                                },
                                success: function(response) {
                                    if ( response ) {
                                        element.find('.video-order-single-content').remove();
                                        element.find('.video-ajax-content').append( response );       

                                        // Save cache
                                        video_order_single_data[tab_data_index] = response;
                                        video_order_single_control[tab_control_index] = [video_order, max_pages, current_page + 1];
                                    }
                                    // Do something
                                    element.find('.video-control .video-control-item').attr('data-current_page', current_page + 1);
                                    element.find('.video-ajax-content').removeClass('loading');
                                    // Check last page
                                    element.find('.video-control .video-control-item[data-action="prev"]').removeClass('disable');
                                    if ( current_page + 1 >= max_pages ) {
                                        element.find('.video-control .video-control-item[data-action="next"]').addClass('disable');
                                    }
                                }
                            });
                        } else {
                            return;
                        }
                    } else if ( action == 'prev' ) {
                        var current_page    = parseInt($(this).attr('data-current_page'));

                        if ( current_page == 1 ) {
                            return;
                        }

                        // Check cache
                        var tab_data_index = element_id + '-' + video_order.toString().split(',').join('-') + '-page-' + ( current_page - 1 );
                        var tab_control_index = element_id + '-' + video_order.toString().split(',').join('-');

                        if ( video_order_single_data[tab_data_index] != undefined ) {
                            element.find('.video-order-single-content').remove();
                            element.find('.video-ajax-content').append( video_order_single_data[tab_data_index] );
                            
                            // Do something
                            element.find('.video-control .video-control-item').attr('data-current_page', current_page - 1);
                            video_order_single_control[tab_control_index] = [video_order, max_pages, current_page - 1];
                        }

                        // Check first page
                        element.find('.video-control .video-control-item[data-action="next"]').removeClass('disable');
                        if ( current_page - 1 <= 1 ) {
                            element.find('.video-control .video-control-item[data-action="prev"]').addClass('disable');
                        }
                    }
                });
            });
        },
        shortcodeVideoTop: function() {
            var video_top_data = []; // Use this for video top shortcode
            var video_top_control = [];

            $('.video-top-shortcode').each(function() {
                var element         = $(this);
                var element_id      = element.attr('id');
                var atts            = element.data('atts');

                // Have Video filter
                var video_order_by  = element.attr('data-video_order_by'); // Different if have tab
                var max_pages       = parseInt(element.find('.video-control-item').attr('data-max_pages'));
                var current_page    = parseInt(element.find('.video-control-item').attr('data-current_page'));

                // Save first load to cache
                var tab_data_index = element_id + '-' + video_order_by.toString().split(',').join('-') + '-page-1';
                var tab_control_index = element_id + '-' + video_order_by.toString().split(',').join('-');

                video_top_data[tab_data_index] = element.find('.video-top-content').clone(true);
                video_top_control[tab_control_index] = [video_order_by, max_pages, current_page];

                // Next/Prev control
                element.find('.video-control .video-control-item').off().on('click', function() {
                    // Check if already click or loading
                    if ( $(this).hasClass('disable') || element.find('.video-ajax-content').hasClass('loading') ) {
                        return;
                    }

                    var video_order_by  = $(this).attr('data-video_order_by');
                    var max_pages       = parseInt($(this).attr('data-max_pages'));
                    var action          = $(this).attr('data-action');

                    if ( action == 'next' ) {
                        var current_page    = parseInt($(this).attr('data-current_page'));

                        if ( (current_page + 1) <= max_pages ) {
                            // Check cache
                            var tab_data_index = element_id + '-' + video_order_by.toString().split(',').join('-') + '-page-' + ( current_page + 1 );
                            var tab_control_index = element_id + '-' + video_order_by.toString().split(',').join('-');

                            if ( video_top_data[tab_data_index] != undefined ) {
                                element.find('.video-top-content').remove();
                                element.find('.video-ajax-content').append( video_top_data[tab_data_index] );
                                
                                // Do something
                                element.find('.video-control .video-control-item').attr('data-current_page', current_page + 1);
                                video_top_control[tab_control_index] = [video_order_by, max_pages, current_page + 1];
                                // Check last page
                                element.find('.video-control .video-control-item[data-action="prev"]').removeClass('disable');
                                if ( current_page + 1 >= max_pages ) {
                                    element.find('.video-control .video-control-item[data-action="next"]').addClass('disable');
                                }

                                return;
                            }
                        
                            // Load content via ajax
                            element.find('.video-ajax-content').addClass('loading');

                            $.ajax({
                                type : "POST",
                                timeout : 30000,
                                url : haru_vidi_ajax_url,
                                data : {
                                    action: 'haru_get_video_top_next', 
                                    atts: atts, 
                                    video_order_by: video_order_by,
                                    current_page: current_page
                                },
                                error: function(xhr,err) {
                                    console.log('Have something wrong! Please try again!');
                                },
                                success: function(response) {
                                    if ( response ) {
                                        element.find('.video-top-content').remove();
                                        element.find('.video-ajax-content').append( response );       

                                        // Save cache
                                        video_top_data[tab_data_index] = response;
                                        video_top_control[tab_control_index] = [video_order_by, max_pages, current_page + 1];
                                    }
                                    // Do something
                                    element.find('.video-control .video-control-item').attr('data-current_page', current_page + 1);
                                    element.find('.video-ajax-content').removeClass('loading');
                                    // Check last page
                                    element.find('.video-control .video-control-item[data-action="prev"]').removeClass('disable');
                                    if ( current_page + 1 >= max_pages ) {
                                        element.find('.video-control .video-control-item[data-action="next"]').addClass('disable');
                                    }
                                }
                            });
                        } else {
                            return;
                        }
                    } else if ( action == 'prev' ) {
                        var current_page    = parseInt($(this).attr('data-current_page'));

                        if ( current_page == 1 ) {
                            return;
                        }

                        // Check cache
                        var tab_data_index = element_id + '-' + video_order_by.toString().split(',').join('-') + '-page-' + ( current_page - 1 );
                        var tab_control_index = element_id + '-' + video_order_by.toString().split(',').join('-');

                        if ( video_top_data[tab_data_index] != undefined ) {
                            element.find('.video-top-content').remove();
                            element.find('.video-ajax-content').append( video_top_data[tab_data_index] );
                            
                            // Do something
                            element.find('.video-control .video-control-item').attr('data-current_page', current_page - 1);
                            video_top_control[tab_control_index] = [video_order_by, max_pages, current_page - 1];
                        }

                        // Check first page
                        element.find('.video-control .video-control-item[data-action="next"]').removeClass('disable');
                        if ( current_page - 1 <= 1 ) {
                            element.find('.video-control .video-control-item[data-action="prev"]').addClass('disable');
                        }
                    }
                });
            });
        },
        shortcodeVideoSlideshow: function() {
            $('.haru-slick').not('.slick-initialized').each(function(index, value){
                var $self          = $(this);

                $self.slick();
                
                // Special
                if ( $self.parent().hasClass('info-featured') ) {
                    var stHeight = $self.find('.slick-track').height();
                    $self.find('.slick-slide').css('height',stHeight + 'px' );
                }
            });
        },
        shortcodeVideoSearch: function() {
            $('.video-search-shortcode').each(function() {
                var search_sc = $(this);
                
                $(this).find('.video-search-button').on('click', function() {
                    var popup_effect    = $(this).data('effect');

                    $(this).magnificPopup({
                        items: {
                          src: search_sc.find('.video-search-popup'),
                          type: 'inline'
                        },
                        removalDelay: 500, //delay removal by X to allow out-animation
                        callbacks: {
                            beforeOpen: function() {
                                this.st.mainClass = popup_effect;
                            },
                            beforeClose: function() {
                            
                            },
                        }
                        // (optionally) other options
                    }).magnificPopup('open');
                });
            });
        },
        shortcodeChannelCategory: function() {
            var channel_category_data = []; // Use this for channel category shortcode
            var channel_category_control = [];

            $('.channel-category-shortcode').each(function() {
                var element         = $(this);
                var element_id      = element.attr('id');
                var atts            = element.data('atts');


                if ( atts['filter'] != 'hide' ) {
                    var category        = element.find('.channel-filter .filter-item:first').attr('data-category');
                    var max_pages       = parseInt(element.find('.channel-control-item').attr('data-max_pages'));
                    var current_page    = parseInt(element.find('.channel-control-item').attr('data-current_page'));

                    // Save first load to cache
                    var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-1';
                    var tab_control_index = element_id + '-' + category.toString().split(',').join('-');

                    channel_category_data[tab_data_index] = element.find('.channel-category-content').clone(true);
                    channel_category_control[tab_control_index] = [category, max_pages, current_page];

                    element.find('.channel-filter .filter-item').off().on('click', function() {
                        // Check if already click or loading
                        if ( $(this).hasClass('active') || element.find('.channel-ajax-content').hasClass('loading') ) {
                            return;
                        }

                        element.find('.channel-filter .filter-item').removeClass('active');
                        $(this).addClass('active');

                        // Check cache
                        var category            = $(this).data('category');
                        var tab_control_index   = element_id + '-' + category.toString().split(',').join('-');

                        if ( channel_category_control[tab_control_index] != undefined ) {
                            element.find('.channel-category-content').remove();

                            var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-' + channel_category_control[tab_control_index][2].toString();

                            element.find('.channel-ajax-content').append( channel_category_data[tab_data_index] );
                            element.find('.channel-control .channel-control-item').attr('data-category', channel_category_control[tab_control_index][0]);
                            element.find('.channel-control .channel-control-item').attr('data-max_pages', channel_category_control[tab_control_index][1]);
                            element.find('.channel-control .channel-control-item').attr('data-current_page', channel_category_control[tab_control_index][2]);
                            // Check show/hide control
                            if ( channel_category_control[tab_control_index][1] <= 1 ) {
                                element.find('.channel-control').addClass('hide');
                            } else {
                                element.find('.channel-control').removeClass('hide');
                            }
                            // Check last page, first page
                            if ( channel_category_control[tab_control_index][2] == channel_category_control[tab_control_index][1] ) {
                                element.find('.channel-control .channel-control-item[data-action="prev"]').removeClass('disable');
                                element.find('.channel-control .channel-control-item[data-action="next"]').addClass('disable');
                            } else if ( channel_category_control[tab_control_index][2] == 1 ) {
                                element.find('.channel-control .channel-control-item[data-action="prev"]').addClass('disable');
                                element.find('.channel-control .channel-control-item[data-action="next"]').removeClass('disable');
                            } else {
                                element.find('.channel-control .channel-control-item[data-action="prev"]').removeClass('disable');
                                element.find('.channel-control .channel-control-item[data-action="next"]').removeClass('disable');
                            }

                            return;
                        }

                        // Load content via ajax
                        element.find('.channel-ajax-content').addClass('loading');

                        $.ajax({
                            type : "POST",
                            timeout : 30000,
                            url : haru_vidi_ajax_url,
                            data : {
                                action: 'haru_get_channel_category', 
                                atts: atts, 
                                category: category
                            },
                            error: function(xhr,err) {
                                console.log('Have something wrong! Please try again!');
                            },
                            success: function(response) {
                                if ( response ) {
                                    element.find('.channel-category-content').remove();
                                    element.find('.channel-ajax-content').append( response );       

                                    // Save cache
                                    var tab_data_index      = element_id + '-' + category.toString().split(',').join('-') + '-page-1';
                                    channel_category_data[tab_data_index] = response;

                                    // Do something
                                    var max_pages = parseInt(element.find('.channel-category-content').attr('data-max_pages'));
                                    channel_category_control[tab_control_index] = [category, max_pages, 1];
                                    // Check show/hide control
                                    if ( max_pages <= 1 ) {
                                        // Do something
                                        element.find('.channel-control').addClass('hide');
                                    } else {
                                        element.find('.channel-control').removeClass('hide');
                                    }
                                    // Set new value for control
                                    element.find('.channel-control .channel-control-item').attr('data-category', category);
                                    element.find('.channel-control .channel-control-item').attr('data-max_pages', max_pages);
                                    element.find('.channel-control .channel-control-item').attr('data-current_page', 1);
                                    // Check last page, first page
                                    element.find('.channel-control .channel-control-item[data-action="prev"]').addClass('disable');
                                    element.find('.channel-control .channel-control-item[data-action="next"]').removeClass('disable');
                                }
                                element.find('.channel-ajax-content').removeClass('loading');
                            }
                        });
                    });
                } else {
                    var category        = element.find('.channel-control-item').attr('data-category');
                    var max_pages       = parseInt(element.find('.channel-control-item').attr('data-max_pages'));
                    var current_page    = parseInt(element.find('.channel-control-item').attr('data-current_page'));

                    // Save first load to cache
                    var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-1';
                    var tab_control_index = element_id + '-' + category.toString().split(',').join('-');

                    channel_category_data[tab_data_index] = element.find('.channel-category-content').clone(true);
                    channel_category_control[tab_control_index] = [category, max_pages, current_page];
                }

                // Next/Prev control
                element.find('.channel-control .channel-control-item').off().on('click', function() {
                    // Check if already click or loading
                    if ( $(this).hasClass('disable') || element.find('.channel-ajax-content').hasClass('loading') ) {
                        return;
                    }

                    var category        = $(this).attr('data-category');
                    var max_pages       = parseInt($(this).attr('data-max_pages'));
                    var action          = $(this).attr('data-action');

                    if ( action == 'next' ) {
                        var current_page    = parseInt($(this).attr('data-current_page'));

                        if ( (current_page + 1) <= max_pages ) {
                            // Check cache
                            var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-' + ( current_page + 1 );
                            var tab_control_index = element_id + '-' + category.toString().split(',').join('-');

                            if ( channel_category_data[tab_data_index] != undefined ) {
                                element.find('.channel-category-content').remove();
                                element.find('.channel-ajax-content').append( channel_category_data[tab_data_index] );
                                
                                // Do something
                                element.find('.channel-control .channel-control-item').attr('data-current_page', current_page + 1);
                                channel_category_control[tab_control_index] = [category, max_pages, current_page + 1];
                                // Check last page
                                element.find('.channel-control .channel-control-item[data-action="prev"]').removeClass('disable');
                                if ( current_page + 1 >= max_pages ) {
                                    element.find('.channel-control .channel-control-item[data-action="next"]').addClass('disable');
                                }

                                return;
                            }
                        
                            // Load content via ajax
                            element.find('.channel-ajax-content').addClass('loading');

                            $.ajax({
                                type : "POST",
                                timeout : 30000,
                                url : haru_vidi_ajax_url,
                                data : {
                                    action: 'haru_get_channel_category_next', 
                                    atts: atts, 
                                    category: category,
                                    current_page: current_page
                                },
                                error: function(xhr,err) {
                                    console.log('Have something wrong! Please try again!');
                                },
                                success: function(response) {
                                    if ( response ) {
                                        element.find('.channel-category-content').remove();
                                        element.find('.channel-ajax-content').append( response );       

                                        // Save cache
                                        channel_category_data[tab_data_index] = response;
                                        channel_category_control[tab_control_index] = [category, max_pages, current_page + 1];
                                    }
                                    // Do something
                                    element.find('.channel-control .channel-control-item').attr('data-current_page', current_page + 1);
                                    element.find('.channel-ajax-content').removeClass('loading');
                                    // Check last page
                                    element.find('.channel-control .channel-control-item[data-action="prev"]').removeClass('disable');
                                    if ( current_page + 1 >= max_pages ) {
                                        element.find('.channel-control .channel-control-item[data-action="next"]').addClass('disable');
                                    }
                                }
                            });
                        } else {
                            return;
                        }
                    } else if ( action == 'prev' ) {
                        var current_page    = parseInt($(this).attr('data-current_page'));

                        if ( current_page == 1 ) {
                            return;
                        }

                        // Check cache
                        var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-' + ( current_page - 1 );
                        var tab_control_index = element_id + '-' + category.toString().split(',').join('-');

                        if ( channel_category_data[tab_data_index] != undefined ) {
                            element.find('.channel-category-content').remove();
                            element.find('.channel-ajax-content').append( channel_category_data[tab_data_index] );
                            
                            // Do something
                            element.find('.channel-control .channel-control-item').attr('data-current_page', current_page - 1);
                            channel_category_control[tab_control_index] = [category, max_pages, current_page - 1];
                        }

                        // Check first page
                        element.find('.channel-control .channel-control-item[data-action="next"]').removeClass('disable');
                        if ( current_page - 1 <= 1 ) {
                            element.find('.channel-control .channel-control-item[data-action="prev"]').addClass('disable');
                        }
                    }
                });
            });
        },
        shortcodeChannelTop: function() {
            var channel_top_data = []; // Use this for channel top shortcode
            var channel_top_control = [];

            $('.channel-top-shortcode').each(function() {
                var element         = $(this);
                var element_id      = element.attr('id');
                var atts            = element.data('atts');

                // Have Video filter
                var channel_order_by  = element.attr('data-channel_order_by'); // Different if have tab
                var max_pages       = parseInt(element.find('.channel-control-item').attr('data-max_pages'));
                var current_page    = parseInt(element.find('.channel-control-item').attr('data-current_page'));

                // Save first load to cache
                var tab_data_index = element_id + '-' + channel_order_by.toString().split(',').join('-') + '-page-1';
                var tab_control_index = element_id + '-' + channel_order_by.toString().split(',').join('-');

                channel_top_data[tab_data_index] = element.find('.channel-top-content').clone(true);
                channel_top_control[tab_control_index] = [channel_order_by, max_pages, current_page];

                // Next/Prev control
                element.find('.channel-control .channel-control-item').off().on('click', function() {
                    // Check if already click or loading
                    if ( $(this).hasClass('disable') || element.find('.channel-ajax-content').hasClass('loading') ) {
                        return;
                    }

                    var channel_order_by  = $(this).attr('data-channel_order_by');
                    var max_pages       = parseInt($(this).attr('data-max_pages'));
                    var action          = $(this).attr('data-action');

                    if ( action == 'next' ) {
                        var current_page    = parseInt($(this).attr('data-current_page'));

                        if ( (current_page + 1) <= max_pages ) {
                            // Check cache
                            var tab_data_index = element_id + '-' + channel_order_by.toString().split(',').join('-') + '-page-' + ( current_page + 1 );
                            var tab_control_index = element_id + '-' + channel_order_by.toString().split(',').join('-');

                            if ( channel_top_data[tab_data_index] != undefined ) {
                                element.find('.channel-top-content').remove();
                                element.find('.channel-ajax-content').append( channel_top_data[tab_data_index] );
                                
                                // Do something
                                element.find('.channel-control .channel-control-item').attr('data-current_page', current_page + 1);
                                channel_top_control[tab_control_index] = [channel_order_by, max_pages, current_page + 1];
                                // Check last page
                                element.find('.channel-control .channel-control-item[data-action="prev"]').removeClass('disable');
                                if ( current_page + 1 >= max_pages ) {
                                    element.find('.channel-control .channel-control-item[data-action="next"]').addClass('disable');
                                }

                                return;
                            }
                        
                            // Load content via ajax
                            element.find('.channel-ajax-content').addClass('loading');

                            $.ajax({
                                type : "POST",
                                timeout : 30000,
                                url : haru_vidi_ajax_url,
                                data : {
                                    action: 'haru_get_channel_top_next', 
                                    atts: atts, 
                                    channel_order_by: channel_order_by,
                                    current_page: current_page
                                },
                                error: function(xhr,err) {
                                    console.log('Have something wrong! Please try again!');
                                },
                                success: function(response) {
                                    if ( response ) {
                                        element.find('.channel-top-content').remove();
                                        element.find('.channel-ajax-content').append( response );       

                                        // Save cache
                                        channel_top_data[tab_data_index] = response;
                                        channel_top_control[tab_control_index] = [channel_order_by, max_pages, current_page + 1];
                                    }
                                    // Do something
                                    element.find('.channel-control .channel-control-item').attr('data-current_page', current_page + 1);
                                    element.find('.channel-ajax-content').removeClass('loading');
                                    // Check last page
                                    element.find('.channel-control .channel-control-item[data-action="prev"]').removeClass('disable');
                                    if ( current_page + 1 >= max_pages ) {
                                        element.find('.channel-control .channel-control-item[data-action="next"]').addClass('disable');
                                    }
                                }
                            });
                        } else {
                            return;
                        }
                    } else if ( action == 'prev' ) {
                        var current_page    = parseInt($(this).attr('data-current_page'));

                        if ( current_page == 1 ) {
                            return;
                        }

                        // Check cache
                        var tab_data_index = element_id + '-' + channel_order_by.toString().split(',').join('-') + '-page-' + ( current_page - 1 );
                        var tab_control_index = element_id + '-' + channel_order_by.toString().split(',').join('-');

                        if ( channel_top_data[tab_data_index] != undefined ) {
                            element.find('.channel-top-content').remove();
                            element.find('.channel-ajax-content').append( channel_top_data[tab_data_index] );
                            
                            // Do something
                            element.find('.channel-control .channel-control-item').attr('data-current_page', current_page - 1);
                            channel_top_control[tab_control_index] = [channel_order_by, max_pages, current_page - 1];
                        }

                        // Check first page
                        element.find('.channel-control .channel-control-item[data-action="next"]').removeClass('disable');
                        if ( current_page - 1 <= 1 ) {
                            element.find('.channel-control .channel-control-item[data-action="prev"]').addClass('disable');
                        }
                    }
                });
            });
        },
        shortcodeSeriesCategory: function() {
            var series_category_data = []; // Use this for series category shortcode
            var series_category_control = [];

            $('.series-category-shortcode').each(function() {
                var element         = $(this);
                var element_id      = element.attr('id');
                var atts            = element.data('atts');


                if ( atts['filter'] != 'hide' ) {
                    var category        = element.find('.series-filter .filter-item:first').attr('data-category');
                    var max_pages       = parseInt(element.find('.series-control-item').attr('data-max_pages'));
                    var current_page    = parseInt(element.find('.series-control-item').attr('data-current_page'));

                    // Save first load to cache
                    var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-1';
                    var tab_control_index = element_id + '-' + category.toString().split(',').join('-');

                    series_category_data[tab_data_index] = element.find('.series-category-content').clone(true);
                    series_category_control[tab_control_index] = [category, max_pages, current_page];

                    element.find('.series-filter .filter-item').off().on('click', function() {
                        // Check if already click or loading
                        if ( $(this).hasClass('active') || element.find('.series-ajax-content').hasClass('loading') ) {
                            return;
                        }

                        element.find('.series-filter .filter-item').removeClass('active');
                        $(this).addClass('active');

                        // Check cache
                        var category            = $(this).data('category');
                        var tab_control_index   = element_id + '-' + category.toString().split(',').join('-');

                        if ( series_category_control[tab_control_index] != undefined ) {
                            element.find('.series-category-content').remove();

                            var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-' + series_category_control[tab_control_index][2].toString();

                            element.find('.series-ajax-content').append( series_category_data[tab_data_index] );
                            element.find('.series-control .series-control-item').attr('data-category', series_category_control[tab_control_index][0]);
                            element.find('.series-control .series-control-item').attr('data-max_pages', series_category_control[tab_control_index][1]);
                            element.find('.series-control .series-control-item').attr('data-current_page', series_category_control[tab_control_index][2]);
                            // Check show/hide control
                            if ( series_category_control[tab_control_index][1] <= 1 ) {
                                element.find('.series-control').addClass('hide');
                            } else {
                                element.find('.series-control').removeClass('hide');
                            }
                            // Check last page, first page
                            if ( series_category_control[tab_control_index][2] == series_category_control[tab_control_index][1] ) {
                                element.find('.series-control .series-control-item[data-action="prev"]').removeClass('disable');
                                element.find('.series-control .series-control-item[data-action="next"]').addClass('disable');
                            } else if ( series_category_control[tab_control_index][2] == 1 ) {
                                element.find('.series-control .series-control-item[data-action="prev"]').addClass('disable');
                                element.find('.series-control .series-control-item[data-action="next"]').removeClass('disable');
                            } else {
                                element.find('.series-control .series-control-item[data-action="prev"]').removeClass('disable');
                                element.find('.series-control .series-control-item[data-action="next"]').removeClass('disable');
                            }

                            return;
                        }

                        // Load content via ajax
                        element.find('.series-ajax-content').addClass('loading');

                        $.ajax({
                            type : "POST",
                            timeout : 30000,
                            url : haru_vidi_ajax_url,
                            data : {
                                action: 'haru_get_series_category', 
                                atts: atts, 
                                category: category
                            },
                            error: function(xhr,err) {
                                console.log('Have something wrong! Please try again!');
                            },
                            success: function(response) {
                                if ( response ) {
                                    element.find('.series-category-content').remove();
                                    element.find('.series-ajax-content').append( response );       

                                    // Save cache
                                    var tab_data_index      = element_id + '-' + category.toString().split(',').join('-') + '-page-1';
                                    series_category_data[tab_data_index] = response;

                                    // Do something
                                    var max_pages = parseInt(element.find('.series-category-content').attr('data-max_pages'));
                                    series_category_control[tab_control_index] = [category, max_pages, 1];
                                    // Check show/hide control
                                    if ( max_pages <= 1 ) {
                                        // Do something
                                        element.find('.series-control').addClass('hide');
                                    } else {
                                        element.find('.series-control').removeClass('hide');
                                    }
                                    // Set new value for control
                                    element.find('.series-control .series-control-item').attr('data-category', category);
                                    element.find('.series-control .series-control-item').attr('data-max_pages', max_pages);
                                    element.find('.series-control .series-control-item').attr('data-current_page', 1);
                                    // Check last page, first page
                                    element.find('.series-control .series-control-item[data-action="prev"]').addClass('disable');
                                    element.find('.series-control .series-control-item[data-action="next"]').removeClass('disable');
                                }
                                element.find('.series-ajax-content').removeClass('loading');
                            }
                        });
                    });
                } else {
                    var category        = element.find('.series-control-item').attr('data-category');
                    var max_pages       = parseInt(element.find('.series-control-item').attr('data-max_pages'));
                    var current_page    = parseInt(element.find('.series-control-item').attr('data-current_page'));

                    // Save first load to cache
                    var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-1';
                    var tab_control_index = element_id + '-' + category.toString().split(',').join('-');

                    series_category_data[tab_data_index] = element.find('.series-category-content').clone(true);
                    series_category_control[tab_control_index] = [category, max_pages, current_page];
                }

                // Next/Prev control
                element.find('.series-control .series-control-item').off().on('click', function() {
                    // Check if already click or loading
                    if ( $(this).hasClass('disable') || element.find('.series-ajax-content').hasClass('loading') ) {
                        return;
                    }

                    var category        = $(this).attr('data-category');
                    var max_pages       = parseInt($(this).attr('data-max_pages'));
                    var action          = $(this).attr('data-action');

                    if ( action == 'next' ) {
                        var current_page    = parseInt($(this).attr('data-current_page'));

                        if ( (current_page + 1) <= max_pages ) {
                            // Check cache
                            var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-' + ( current_page + 1 );
                            var tab_control_index = element_id + '-' + category.toString().split(',').join('-');

                            if ( series_category_data[tab_data_index] != undefined ) {
                                element.find('.series-category-content').remove();
                                element.find('.series-ajax-content').append( series_category_data[tab_data_index] );
                                
                                // Do something
                                element.find('.series-control .series-control-item').attr('data-current_page', current_page + 1);
                                series_category_control[tab_control_index] = [category, max_pages, current_page + 1];
                                // Check last page
                                element.find('.series-control .series-control-item[data-action="prev"]').removeClass('disable');
                                if ( current_page + 1 >= max_pages ) {
                                    element.find('.series-control .series-control-item[data-action="next"]').addClass('disable');
                                }

                                return;
                            }
                        
                            // Load content via ajax
                            element.find('.series-ajax-content').addClass('loading');

                            $.ajax({
                                type : "POST",
                                timeout : 30000,
                                url : haru_vidi_ajax_url,
                                data : {
                                    action: 'haru_get_series_category_next', 
                                    atts: atts, 
                                    category: category,
                                    current_page: current_page
                                },
                                error: function(xhr,err) {
                                    console.log('Have something wrong! Please try again!');
                                },
                                success: function(response) {
                                    if ( response ) {
                                        element.find('.series-category-content').remove();
                                        element.find('.series-ajax-content').append( response );       

                                        // Save cache
                                        series_category_data[tab_data_index] = response;
                                        series_category_control[tab_control_index] = [category, max_pages, current_page + 1];
                                    }
                                    // Do something
                                    element.find('.series-control .series-control-item').attr('data-current_page', current_page + 1);
                                    element.find('.series-ajax-content').removeClass('loading');
                                    // Check last page
                                    element.find('.series-control .series-control-item[data-action="prev"]').removeClass('disable');
                                    if ( current_page + 1 >= max_pages ) {
                                        element.find('.series-control .series-control-item[data-action="next"]').addClass('disable');
                                    }
                                }
                            });
                        } else {
                            return;
                        }
                    } else if ( action == 'prev' ) {
                        var current_page    = parseInt($(this).attr('data-current_page'));

                        if ( current_page == 1 ) {
                            return;
                        }

                        // Check cache
                        var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-' + ( current_page - 1 );
                        var tab_control_index = element_id + '-' + category.toString().split(',').join('-');

                        if ( series_category_data[tab_data_index] != undefined ) {
                            element.find('.series-category-content').remove();
                            element.find('.series-ajax-content').append( series_category_data[tab_data_index] );
                            
                            // Do something
                            element.find('.series-control .series-control-item').attr('data-current_page', current_page - 1);
                            series_category_control[tab_control_index] = [category, max_pages, current_page - 1];
                        }

                        // Check first page
                        element.find('.series-control .series-control-item[data-action="next"]').removeClass('disable');
                        if ( current_page - 1 <= 1 ) {
                            element.find('.series-control .series-control-item[data-action="prev"]').addClass('disable');
                        }
                    }
                });
            });
        },
        shortcodeSeriesTop: function() {
            var series_top_data = []; // Use this for series top shortcode
            var series_top_control = [];

            $('.series-top-shortcode').each(function() {
                var element         = $(this);
                var element_id      = element.attr('id');
                var atts            = element.data('atts');

                // Have Video filter
                var series_order_by  = element.attr('data-series_order_by'); // Different if have tab
                var max_pages       = parseInt(element.find('.series-control-item').attr('data-max_pages'));
                var current_page    = parseInt(element.find('.series-control-item').attr('data-current_page'));

                // Save first load to cache
                var tab_data_index = element_id + '-' + series_order_by.toString().split(',').join('-') + '-page-1';
                var tab_control_index = element_id + '-' + series_order_by.toString().split(',').join('-');

                series_top_data[tab_data_index] = element.find('.series-top-content').clone(true);
                series_top_control[tab_control_index] = [series_order_by, max_pages, current_page];

                // Next/Prev control
                element.find('.series-control .series-control-item').off().on('click', function() {
                    // Check if already click or loading
                    if ( $(this).hasClass('disable') || element.find('.series-ajax-content').hasClass('loading') ) {
                        return;
                    }

                    var series_order_by  = $(this).attr('data-series_order_by');
                    var max_pages       = parseInt($(this).attr('data-max_pages'));
                    var action          = $(this).attr('data-action');

                    if ( action == 'next' ) {
                        var current_page    = parseInt($(this).attr('data-current_page'));

                        if ( (current_page + 1) <= max_pages ) {
                            // Check cache
                            var tab_data_index = element_id + '-' + series_order_by.toString().split(',').join('-') + '-page-' + ( current_page + 1 );
                            var tab_control_index = element_id + '-' + series_order_by.toString().split(',').join('-');

                            if ( series_top_data[tab_data_index] != undefined ) {
                                element.find('.series-top-content').remove();
                                element.find('.series-ajax-content').append( series_top_data[tab_data_index] );
                                
                                // Do something
                                element.find('.series-control .series-control-item').attr('data-current_page', current_page + 1);
                                series_top_control[tab_control_index] = [series_order_by, max_pages, current_page + 1];
                                // Check last page
                                element.find('.series-control .series-control-item[data-action="prev"]').removeClass('disable');
                                if ( current_page + 1 >= max_pages ) {
                                    element.find('.series-control .series-control-item[data-action="next"]').addClass('disable');
                                }

                                return;
                            }
                        
                            // Load content via ajax
                            element.find('.series-ajax-content').addClass('loading');

                            $.ajax({
                                type : "POST",
                                timeout : 30000,
                                url : haru_vidi_ajax_url,
                                data : {
                                    action: 'haru_get_series_top_next', 
                                    atts: atts, 
                                    series_order_by: series_order_by,
                                    current_page: current_page
                                },
                                error: function(xhr,err) {
                                    console.log('Have something wrong! Please try again!');
                                },
                                success: function(response) {
                                    if ( response ) {
                                        element.find('.series-top-content').remove();
                                        element.find('.series-ajax-content').append( response );       

                                        // Save cache
                                        series_top_data[tab_data_index] = response;
                                        series_top_control[tab_control_index] = [series_order_by, max_pages, current_page + 1];
                                    }
                                    // Do something
                                    element.find('.series-control .series-control-item').attr('data-current_page', current_page + 1);
                                    element.find('.series-ajax-content').removeClass('loading');
                                    // Check last page
                                    element.find('.series-control .series-control-item[data-action="prev"]').removeClass('disable');
                                    if ( current_page + 1 >= max_pages ) {
                                        element.find('.series-control .series-control-item[data-action="next"]').addClass('disable');
                                    }
                                }
                            });
                        } else {
                            return;
                        }
                    } else if ( action == 'prev' ) {
                        var current_page    = parseInt($(this).attr('data-current_page'));

                        if ( current_page == 1 ) {
                            return;
                        }

                        // Check cache
                        var tab_data_index = element_id + '-' + series_order_by.toString().split(',').join('-') + '-page-' + ( current_page - 1 );
                        var tab_control_index = element_id + '-' + series_order_by.toString().split(',').join('-');

                        if ( series_top_data[tab_data_index] != undefined ) {
                            element.find('.series-top-content').remove();
                            element.find('.series-ajax-content').append( series_top_data[tab_data_index] );
                            
                            // Do something
                            element.find('.series-control .series-control-item').attr('data-current_page', current_page - 1);
                            series_top_control[tab_control_index] = [series_order_by, max_pages, current_page - 1];
                        }

                        // Check first page
                        element.find('.series-control .series-control-item[data-action="next"]').removeClass('disable');
                        if ( current_page - 1 <= 1 ) {
                            element.find('.series-control .series-control-item[data-action="prev"]').addClass('disable');
                        }
                    }
                });
            });
        },
        shortcodePlaylistCategory: function() {
            var playlist_category_data = []; // Use this for playlist category shortcode
            var playlist_category_control = [];

            $('.playlist-category-shortcode').each(function() {
                var element         = $(this);
                var element_id      = element.attr('id');
                var atts            = element.data('atts');


                if ( atts['filter'] != 'hide' ) {
                    var category        = element.find('.playlist-filter .filter-item:first').attr('data-category');
                    var max_pages       = parseInt(element.find('.playlist-control-item').attr('data-max_pages'));
                    var current_page    = parseInt(element.find('.playlist-control-item').attr('data-current_page'));

                    // Save first load to cache
                    var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-1';
                    var tab_control_index = element_id + '-' + category.toString().split(',').join('-');

                    playlist_category_data[tab_data_index] = element.find('.playlist-category-content').clone(true);
                    playlist_category_control[tab_control_index] = [category, max_pages, current_page];

                    element.find('.playlist-filter .filter-item').off().on('click', function() {
                        // Check if already click or loading
                        if ( $(this).hasClass('active') || element.find('.playlist-ajax-content').hasClass('loading') ) {
                            return;
                        }

                        element.find('.playlist-filter .filter-item').removeClass('active');
                        $(this).addClass('active');

                        // Check cache
                        var category            = $(this).data('category');
                        var tab_control_index   = element_id + '-' + category.toString().split(',').join('-');

                        if ( playlist_category_control[tab_control_index] != undefined ) {
                            element.find('.playlist-category-content').remove();

                            var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-' + playlist_category_control[tab_control_index][2].toString();

                            element.find('.playlist-ajax-content').append( playlist_category_data[tab_data_index] );
                            element.find('.playlist-control .playlist-control-item').attr('data-category', playlist_category_control[tab_control_index][0]);
                            element.find('.playlist-control .playlist-control-item').attr('data-max_pages', playlist_category_control[tab_control_index][1]);
                            element.find('.playlist-control .playlist-control-item').attr('data-current_page', playlist_category_control[tab_control_index][2]);
                            // Check show/hide control
                            if ( playlist_category_control[tab_control_index][1] <= 1 ) {
                                element.find('.playlist-control').addClass('hide');
                            } else {
                                element.find('.playlist-control').removeClass('hide');
                            }
                            // Check last page, first page
                            if ( playlist_category_control[tab_control_index][2] == playlist_category_control[tab_control_index][1] ) {
                                element.find('.playlist-control .playlist-control-item[data-action="prev"]').removeClass('disable');
                                element.find('.playlist-control .playlist-control-item[data-action="next"]').addClass('disable');
                            } else if ( playlist_category_control[tab_control_index][2] == 1 ) {
                                element.find('.playlist-control .playlist-control-item[data-action="prev"]').addClass('disable');
                                element.find('.playlist-control .playlist-control-item[data-action="next"]').removeClass('disable');
                            } else {
                                element.find('.playlist-control .playlist-control-item[data-action="prev"]').removeClass('disable');
                                element.find('.playlist-control .playlist-control-item[data-action="next"]').removeClass('disable');
                            }

                            return;
                        }

                        // Load content via ajax
                        element.find('.playlist-ajax-content').addClass('loading');

                        $.ajax({
                            type : "POST",
                            timeout : 30000,
                            url : haru_vidi_ajax_url,
                            data : {
                                action: 'haru_get_playlist_category', 
                                atts: atts, 
                                category: category
                            },
                            error: function(xhr,err) {
                                console.log('Have something wrong! Please try again!');
                            },
                            success: function(response) {
                                if ( response ) {
                                    element.find('.playlist-category-content').remove();
                                    element.find('.playlist-ajax-content').append( response );       

                                    // Save cache
                                    var tab_data_index      = element_id + '-' + category.toString().split(',').join('-') + '-page-1';
                                    playlist_category_data[tab_data_index] = response;

                                    // Do something
                                    var max_pages = parseInt(element.find('.playlist-category-content').attr('data-max_pages'));
                                    playlist_category_control[tab_control_index] = [category, max_pages, 1];
                                    // Check show/hide control
                                    if ( max_pages <= 1 ) {
                                        // Do something
                                        element.find('.playlist-control').addClass('hide');
                                    } else {
                                        element.find('.playlist-control').removeClass('hide');
                                    }
                                    // Set new value for control
                                    element.find('.playlist-control .playlist-control-item').attr('data-category', category);
                                    element.find('.playlist-control .playlist-control-item').attr('data-max_pages', max_pages);
                                    element.find('.playlist-control .playlist-control-item').attr('data-current_page', 1);
                                    // Check last page, first page
                                    element.find('.playlist-control .playlist-control-item[data-action="prev"]').addClass('disable');
                                    element.find('.playlist-control .playlist-control-item[data-action="next"]').removeClass('disable');
                                }
                                element.find('.playlist-ajax-content').removeClass('loading');
                            }
                        });
                    });
                } else {
                    var category        = element.find('.playlist-control-item').attr('data-category');
                    var max_pages       = parseInt(element.find('.playlist-control-item').attr('data-max_pages'));
                    var current_page    = parseInt(element.find('.playlist-control-item').attr('data-current_page'));

                    // Save first load to cache
                    var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-1';
                    var tab_control_index = element_id + '-' + category.toString().split(',').join('-');

                    playlist_category_data[tab_data_index] = element.find('.playlist-category-content').clone(true);
                    playlist_category_control[tab_control_index] = [category, max_pages, current_page];
                }

                // Next/Prev control
                element.find('.playlist-control .playlist-control-item').off().on('click', function() {
                    // Check if already click or loading
                    if ( $(this).hasClass('disable') || element.find('.playlist-ajax-content').hasClass('loading') ) {
                        return;
                    }

                    var category        = $(this).attr('data-category');
                    var max_pages       = parseInt($(this).attr('data-max_pages'));
                    var action          = $(this).attr('data-action');

                    if ( action == 'next' ) {
                        var current_page    = parseInt($(this).attr('data-current_page'));

                        if ( (current_page + 1) <= max_pages ) {
                            // Check cache
                            var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-' + ( current_page + 1 );
                            var tab_control_index = element_id + '-' + category.toString().split(',').join('-');

                            if ( playlist_category_data[tab_data_index] != undefined ) {
                                element.find('.playlist-category-content').remove();
                                element.find('.playlist-ajax-content').append( playlist_category_data[tab_data_index] );
                                
                                // Do something
                                element.find('.playlist-control .playlist-control-item').attr('data-current_page', current_page + 1);
                                playlist_category_control[tab_control_index] = [category, max_pages, current_page + 1];
                                // Check last page
                                element.find('.playlist-control .playlist-control-item[data-action="prev"]').removeClass('disable');
                                if ( current_page + 1 >= max_pages ) {
                                    element.find('.playlist-control .playlist-control-item[data-action="next"]').addClass('disable');
                                }

                                return;
                            }
                        
                            // Load content via ajax
                            element.find('.playlist-ajax-content').addClass('loading');

                            $.ajax({
                                type : "POST",
                                timeout : 30000,
                                url : haru_vidi_ajax_url,
                                data : {
                                    action: 'haru_get_playlist_category_next', 
                                    atts: atts, 
                                    category: category,
                                    current_page: current_page
                                },
                                error: function(xhr,err) {
                                    console.log('Have something wrong! Please try again!');
                                },
                                success: function(response) {
                                    if ( response ) {
                                        element.find('.playlist-category-content').remove();
                                        element.find('.playlist-ajax-content').append( response );       

                                        // Save cache
                                        playlist_category_data[tab_data_index] = response;
                                        playlist_category_control[tab_control_index] = [category, max_pages, current_page + 1];
                                    }
                                    // Do something
                                    element.find('.playlist-control .playlist-control-item').attr('data-current_page', current_page + 1);
                                    element.find('.playlist-ajax-content').removeClass('loading');
                                    // Check last page
                                    element.find('.playlist-control .playlist-control-item[data-action="prev"]').removeClass('disable');
                                    if ( current_page + 1 >= max_pages ) {
                                        element.find('.playlist-control .playlist-control-item[data-action="next"]').addClass('disable');
                                    }
                                }
                            });
                        } else {
                            return;
                        }
                    } else if ( action == 'prev' ) {
                        var current_page    = parseInt($(this).attr('data-current_page'));

                        if ( current_page == 1 ) {
                            return;
                        }

                        // Check cache
                        var tab_data_index = element_id + '-' + category.toString().split(',').join('-') + '-page-' + ( current_page - 1 );
                        var tab_control_index = element_id + '-' + category.toString().split(',').join('-');

                        if ( playlist_category_data[tab_data_index] != undefined ) {
                            element.find('.playlist-category-content').remove();
                            element.find('.playlist-ajax-content').append( playlist_category_data[tab_data_index] );
                            
                            // Do something
                            element.find('.playlist-control .playlist-control-item').attr('data-current_page', current_page - 1);
                            playlist_category_control[tab_control_index] = [category, max_pages, current_page - 1];
                        }

                        // Check first page
                        element.find('.playlist-control .playlist-control-item[data-action="next"]').removeClass('disable');
                        if ( current_page - 1 <= 1 ) {
                            element.find('.playlist-control .playlist-control-item[data-action="prev"]').addClass('disable');
                        }
                    }
                });
            });
        },
        shortcodePlaylistTop: function() {
            var playlist_top_data = []; // Use this for playlist top shortcode
            var playlist_top_control = [];

            $('.playlist-top-shortcode').each(function() {
                var element         = $(this);
                var element_id      = element.attr('id');
                var atts            = element.data('atts');

                // Have Video filter
                var playlist_order_by  = element.attr('data-playlist_order_by'); // Different if have tab
                var max_pages       = parseInt(element.find('.playlist-control-item').attr('data-max_pages'));
                var current_page    = parseInt(element.find('.playlist-control-item').attr('data-current_page'));

                // Save first load to cache
                var tab_data_index = element_id + '-' + playlist_order_by.toString().split(',').join('-') + '-page-1';
                var tab_control_index = element_id + '-' + playlist_order_by.toString().split(',').join('-');

                playlist_top_data[tab_data_index] = element.find('.playlist-top-content').clone(true);
                playlist_top_control[tab_control_index] = [playlist_order_by, max_pages, current_page];

                // Next/Prev control
                element.find('.playlist-control .playlist-control-item').off().on('click', function() {
                    // Check if already click or loading
                    if ( $(this).hasClass('disable') || element.find('.playlist-ajax-content').hasClass('loading') ) {
                        return;
                    }

                    var playlist_order_by  = $(this).attr('data-playlist_order_by');
                    var max_pages       = parseInt($(this).attr('data-max_pages'));
                    var action          = $(this).attr('data-action');

                    if ( action == 'next' ) {
                        var current_page    = parseInt($(this).attr('data-current_page'));

                        if ( (current_page + 1) <= max_pages ) {
                            // Check cache
                            var tab_data_index = element_id + '-' + playlist_order_by.toString().split(',').join('-') + '-page-' + ( current_page + 1 );
                            var tab_control_index = element_id + '-' + playlist_order_by.toString().split(',').join('-');

                            if ( playlist_top_data[tab_data_index] != undefined ) {
                                element.find('.playlist-top-content').remove();
                                element.find('.playlist-ajax-content').append( playlist_top_data[tab_data_index] );
                                
                                // Do something
                                element.find('.playlist-control .playlist-control-item').attr('data-current_page', current_page + 1);
                                playlist_top_control[tab_control_index] = [playlist_order_by, max_pages, current_page + 1];
                                // Check last page
                                element.find('.playlist-control .playlist-control-item[data-action="prev"]').removeClass('disable');
                                if ( current_page + 1 >= max_pages ) {
                                    element.find('.playlist-control .playlist-control-item[data-action="next"]').addClass('disable');
                                }

                                return;
                            }
                        
                            // Load content via ajax
                            element.find('.playlist-ajax-content').addClass('loading');

                            $.ajax({
                                type : "POST",
                                timeout : 30000,
                                url : haru_vidi_ajax_url,
                                data : {
                                    action: 'haru_get_playlist_top_next', 
                                    atts: atts, 
                                    playlist_order_by: playlist_order_by,
                                    current_page: current_page
                                },
                                error: function(xhr,err) {
                                    console.log('Have something wrong! Please try again!');
                                },
                                success: function(response) {
                                    if ( response ) {
                                        element.find('.playlist-top-content').remove();
                                        element.find('.playlist-ajax-content').append( response );       

                                        // Save cache
                                        playlist_top_data[tab_data_index] = response;
                                        playlist_top_control[tab_control_index] = [playlist_order_by, max_pages, current_page + 1];
                                    }
                                    // Do something
                                    element.find('.playlist-control .playlist-control-item').attr('data-current_page', current_page + 1);
                                    element.find('.playlist-ajax-content').removeClass('loading');
                                    // Check last page
                                    element.find('.playlist-control .playlist-control-item[data-action="prev"]').removeClass('disable');
                                    if ( current_page + 1 >= max_pages ) {
                                        element.find('.playlist-control .playlist-control-item[data-action="next"]').addClass('disable');
                                    }
                                }
                            });
                        } else {
                            return;
                        }
                    } else if ( action == 'prev' ) {
                        var current_page    = parseInt($(this).attr('data-current_page'));

                        if ( current_page == 1 ) {
                            return;
                        }

                        // Check cache
                        var tab_data_index = element_id + '-' + playlist_order_by.toString().split(',').join('-') + '-page-' + ( current_page - 1 );
                        var tab_control_index = element_id + '-' + playlist_order_by.toString().split(',').join('-');

                        if ( playlist_top_data[tab_data_index] != undefined ) {
                            element.find('.playlist-top-content').remove();
                            element.find('.playlist-ajax-content').append( playlist_top_data[tab_data_index] );
                            
                            // Do something
                            element.find('.playlist-control .playlist-control-item').attr('data-current_page', current_page - 1);
                            playlist_top_control[tab_control_index] = [playlist_order_by, max_pages, current_page - 1];
                        }

                        // Check first page
                        element.find('.playlist-control .playlist-control-item[data-action="next"]').removeClass('disable');
                        if ( current_page - 1 <= 1 ) {
                            element.find('.playlist-control .playlist-control-item[data-action="prev"]').addClass('disable');
                        }
                    }
                });
            });
        },
        archiveVideoSort: function() {
            if ( $('.order-item-current').length > 0 ) {
                $('.order-item-current').off().on('click', function(e) {
                    e.stopPropagation();

                    $(this).toggleClass('active');
                    $(this).next('.order-items').toggleClass('active');
                });

                $(document).on('click', function(e) {
                    if ( e.target.className !== 'order-item-current' ) {
                        $(document).find('.order-item-current').removeClass('active');
                        $(document).find('.order-items').removeClass('active');
                    }
                })
            }
        },
        layoutToggle: function() {
            // @TODO: Add to cookie archivelayoutcookie
            $('.toggle-layout').off().on('click', function() {
                if ( $(this).hasClass('active') ) {
                    return;
                } else {
                    $(this).addClass('active').siblings('.toggle-layout').removeClass('active');

                    var active_layout = $(this).attr('data-layout');

                    $('.layout-wrap').removeClass(function (index, css) {
                       return (css.match (/(^|\s)style-\S+/g) || []).join(' ');
                    }).addClass('style-' + active_layout);

                    HaruVidi.video.videoLayoutIsotope();
                }
            });
        },
        shortcodeSingle: function() {
            $('.haru-shortcode-copy').on('click', function(){
              var share_id = $(this).data('id');
              var copyText = document.getElementsByClassName('haru-shortcode-core');
              
              copyText[0].select();
              copyText[0].setSelectionRange(0, 99999);
              document.execCommand('copy');
              console.log('Copied the text: ' + copyText[0].value);
            });
        },
        shortcodeVideoFilter: function() {
            var default_filter = [];
            var array_filter = []; // Push filter to an array to process when don't have filter

            $('.video-list-shortcode').each(function(index, value) {
                // Process filter each shortcode
                $(this).find('.video-filter li').first().find('a').addClass('selected');
                default_filter[index] = $(this).find('.video-filter li').first().find('a').attr('data-option-value');

                var self = $(this);
                var $layout_wrap = $(this).find('.layout-wrap'); // parent element of .item
                var $filter = $(this).find('.video-filter a');
                var masonry_options = {
                    'gutter': 0
                };

                array_filter[index] = $filter;

                // Add to process products layout style
                var layoutMode = 'fitRows';
                if (($(this).hasClass('masonry'))) {
                    var layoutMode = 'masonry';
                }

                for (var i = 0; i < array_filter.length; i++) {
                    if (array_filter[i].length == 0) {
                        default_filter = '';
                    }
                    $layout_wrap.isotope({
                        itemSelector: 'article', // .item
                        transitionDuration: '0.4s',
                        masonry: masonry_options,
                        layoutMode: layoutMode,
                        filter: default_filter[i]
                    });
                }

                imagesLoaded(self, function() {
                    $layout_wrap.isotope('layout');
                });

                $(window).resize(function() {
                    $layout_wrap.isotope('layout');
                });

                $filter.click(function(e) {
                    e.stopPropagation();
                    e.preventDefault();

                    var $this = $(this);
                    // Don't proceed if already selected
                    if ($this.hasClass('selected')) {
                        return false;
                    }
                    var filters = $this.closest('ul');
                    filters.find('.selected').removeClass('selected');
                    $this.addClass('selected');

                    var options = {
                            layoutMode: layoutMode,
                            transitionDuration: '0.4s',
                            packery: {
                                horizontal: true
                            },
                            masonry: masonry_options
                        },
                        key = filters.attr('data-option-key'),
                        value = $this.attr('data-option-value');
                        value = value === 'false' ? false : value;
                        options[key] = value;

                    $layout_wrap.isotope(options);
                });
            });
        },
        videoLayoutIsotope: function() {
            var $layout_wrap = $('.layout-wrap');

            if ( $layout_wrap.length > 0 ) {
                $layout_wrap.isotope({
                    itemSelector: 'article',
                    layoutMode: 'fitRows'
                });
                $layout_wrap.imagesLoaded( function() {
                    $layout_wrap.isotope('layout');
                    $layout_wrap.addClass('isotope-loaded');
                });
            }
        },
        videoLoadMore: function() {
            $('.video-load-more').off().on('click', function() {
                var $this          = $(this).addClass('loading');
                var link           = $(this).attr('data-href');
                var contentWrap    = '.layout-wrap';
                var element        = '.layout-wrap article.grid-item';

                $.get(link, function (data) {
                    var next_href = $('.video-load-more', data).attr('data-href');
                    var $newElems = $(element, data).css({ opacity: 0 });

                    $(contentWrap).append($newElems);

                    $newElems.imagesLoaded(function () {
                        // Re Init functions (@TODO: Make order archive video and playlist doesn't work)
                        HaruVidi.video.init();

                        $newElems.animate({ opacity: 1 });

                        $(contentWrap).isotope('appended', $newElems);

                        setTimeout(function() {
                            $(contentWrap).isotope('layout');
                        }, 300);
                    });

                    if ( typeof(next_href) == 'undefined' ) {
                        $this.parent().remove(); // @TODO: cause height issue
                    } else {
                        $this.removeClass('loading');
                        $this.attr('data-href', next_href);
                    }
                });
            });
        },
        videoInfiniteScroll: function() {
            var contentWrap = '.layout-wrap';
            var maxPag = $('#infinite_scroll_button').attr('data-max-page');
            var msgText = $('#infinite_scroll_button').attr('data-msgText');
            var finishedMsg = $('#infinite_scroll_button').attr('data-finishedMsg');

            if ( $(contentWrap).length ) {
                $(contentWrap).infinitescroll({
                    navSelector: '#infinite_scroll_button',
                    nextSelector: '#infinite_scroll_button a',
                    itemSelector: '.layout-wrap article.grid-item',
                    loading: {
                        'selector': '#infinite_scroll_loading',
                        'img': haru_vidi_plugin_url + '/assets/images/ajax-loader.gif',
                        'msgText': msgText,
                        'finishedMsg': finishedMsg
                    },
                    maxPage: maxPag
                }, function (newElements, data, url) {
                    var $newElems = $(newElements).css({ opacity: 0 });

                    $newElems.imagesLoaded(function () {
                        // Re Init functions
                        HaruVidi.video.init();

                        $newElems.animate({ opacity: 1 });

                        $(contentWrap).isotope('appended', $newElems);

                        setTimeout(function() {
                            $(contentWrap).isotope('layout');
                        }, 300);
                    });
                });
            }
        },
        watchLater: function() {
            var watch_later_cookie = 'haruwatchlatervideos';

            $('.video-watch-later').off().on('click', function() {
                var $later = $(this);

                if ( $later.hasClass('active') ) {
                    HaruVidi.video.processWatchLaterDeleteVideo($later, watch_later_cookie);
                } else {
                    HaruVidi.video.processWatchLaterAddVideo($later, watch_later_cookie);
                }
            });

            $('.video-watch-later-delete').off().on('click', function() {
                var $later = $(this);
                    
                HaruVidi.video.processWatchLaterDeleteVideo($later, watch_later_cookie);
            });
        },
        processWatchLaterAddVideo: function( $later, watch_later_cookie ) {
            var id = Number($later.attr('data-id'));

            // https://github.com/js-cookie/js-cookie
            if ( typeof(Cookies.get(watch_later_cookie)) !== 'undefined' ) {
                var watch_later_video_ids = Cookies.get(watch_later_cookie);
                var new_watch_later_video_ids = [];
                
                watch_later_video_ids = JSON.parse("[" + watch_later_video_ids + "]");
                
                var i;
                for ( i = 0; i < watch_later_video_ids.length; i++ ) {
                    new_watch_later_video_ids[i] = watch_later_video_ids[i];
                }

                if ( new_watch_later_video_ids.indexOf(id) === -1 ) {
                    new_watch_later_video_ids.push( id );
                    var new_watch_later_cookie = new_watch_later_video_ids.toString();

                    Cookies.set(
                        watch_later_cookie, 
                        new_watch_later_cookie, 
                        {
                            expires: 365
                        }
                    );

                    console.log( new_watch_later_video_ids );
                }

                HaruVidi.video.processWatchLaterAddVideoToList( $later, watch_later_cookie );
            } else {
                Cookies.set(
                    watch_later_cookie,
                    id,
                    {
                        expires: 365
                    }
                );

                HaruVidi.video.processWatchLaterAddVideoToList( $later, watch_later_cookie );
            }

            HaruVidi.video.watchLater(); // To make delete video work

            $(document).find('.watch-later-status').addClass('has-videos');

            $later.addClass('active');
        },
        processWatchLaterAddVideoToList: function( $later, watch_later_cookie ) {
            var id = Number($later.attr('data-id'));

            var title = $later.attr('data-title'),
                permalink = $later.attr('data-permalink'),
                thumb = $later.attr('data-thumb');

            var watch_later_item = '<div class="video-watch-later-item video-item video-' + id + '" id="video-watch-later-' + id + '">' +
                                        '<div class="video-content">' +
                                            '<div class="video-thumb">' +
                                                '<img class="video-img" src="' + thumb + '" alt="' + title + '">' +
                                            '</div>' +
                                            '<h6 class="video-title">' +
                                                '<a href="' + permalink + '" title="' + title + '">' + title + '</a>' +
                                            '</h6>' +
                                        '</div>' +
                                        '<div class="video-watch-later-delete" data-id="' + id + '"><i class="haru-icon haru-times"></i></div>' +
                                    '</div>';

            $(document).find('.haru-watch-later-videos').prepend(watch_later_item);
            $(document).find('.haru-watch-later-videos').removeClass('empty-video');
        },
        processWatchLaterDeleteVideo: function( $later, watch_later_cookie ) {
            var id = Number($later.attr('data-id'));

            if ( typeof( Cookies.get(watch_later_cookie) ) !== 'undefined' ) {
                var watch_later_video_ids = Cookies.get(watch_later_cookie);
                var new_watch_later_video_ids = [];
                
                watch_later_video_ids = JSON.parse("[" + watch_later_video_ids + "]");
                
                var i;
                for ( i = 0; i < watch_later_video_ids.length; i++ ) {
                    new_watch_later_video_ids[i] = watch_later_video_ids[i];
                }

                if ( new_watch_later_video_ids.indexOf(id) !== -1 ) {
                    new_watch_later_video_ids.pop( id );
                    var new_watch_later_cookie = new_watch_later_video_ids.toString();

                    Cookies.set(
                        watch_later_cookie, 
                        new_watch_later_cookie, 
                        {
                            expires: 365
                        }
                    );

                    console.log( new_watch_later_video_ids );

                    if ( new_watch_later_video_ids === 'undefined' || new_watch_later_video_ids.length == 0 ) {
                        $(document).find('.watch-later-status').removeClass('has-videos');
                    }
                }

                if ( $later.hasClass('active') ) {
                    $later.removeClass('active');
                }

                $(document).find('.video-watch-later[data-id="' + id + '"]').removeClass('active');                   
                
                // Process in archive watch later page
                var $watch_later_archive_parent = $later.parents('.haru-archive-watch-later');
                if ( $watch_later_archive_parent.length > 0 ) {
                    $('.video-' + id, $watch_later_archive_parent).hide(50, function(){ 
                        $(this).remove();

                        // Process layout
                        var contentWrap    = '.layout-wrap';
                            $(contentWrap).isotope('layout');

                        if ( $watch_later_archive_parent.find('.video-item').length === 0 ) {
                            $watch_later_archive_parent.find('.haru-watch-later-videos').addClass('empty-video');
                            $watch_later_archive_parent.find('.haru-watch-later-videos').empty();

                            $(document).find('.watch-later-status').removeClass('has-videos');
                        }
                    });
                }
                
                // Process in watch later element
                var $watch_later_element_parent = $(document).find('.haru-watch-later-videos');
                $('.video-' + id, $watch_later_element_parent).hide(50, function(){ 
                    $(this).remove();

                    // Process layout
                    var contentWrap    = '.layout-wrap';
                        $(contentWrap).isotope('layout');

                    if ( $watch_later_element_parent.find('.video-item').length === 0 ) {
                        $watch_later_element_parent.addClass('empty-video');

                        $(document).find('.watch-later-status').removeClass('has-videos');
                    }
                });
            }
        }
    }

    $(document).ready(function() {
        HaruVidi.init();
    });
})(jQuery);