$(document).ready(function() {
    $('.header_search__btn i').on('click', function(e) {
        e.preventDefault();
        $('.header_search').toggleClass('active');
    });
    $('.player_btm__open').on('click', function(e) {
        e.preventDefault();
        $('body, .player_modal').addClass('player_active');
    });
    $('.player_btm__toggle').on('click', function(e) {
        e.preventDefault();
        $('body, .player_modal').addClass('player_active');
    });
    $('.player_modal__toggle').on('click', function(e) {
        e.preventDefault();
        $('body, .player_modal').removeClass('player_active');
    });
    $('.player_modal__listtoggle').on('click', function(e) {
        e.preventDefault();
        $('.player_modal__list').toggleClass('d-none');
        $(this).toggleClass('active');
    });
    $('.player_modal__share').on('click', function(e) {
        e.preventDefault();
        $('.player_modal__social').toggleClass('active');
        $(this).toggleClass('active');
    });
});
$(document).ready(function() {

    let play_buttons = '.post_player .fa-play, .post_player .fa-play';
    let top_player = '.player_btm';
    let top_player_play_buttons = '.player_btm__play .fa-play';
    let top_player_episode = '.player_btm__inn .episode-number:first';
    let top_player_subtitle = '.player_btm__inn p:first';
    let top_player_title = '.player_btm__inn h4:first';
    let episode_player = '.episode_player, .post_player';
    let top_player_timer = '.player_btm__inn .player_btm__time';
    let top_player_duration = '.player_btm__inn .player_btm__duration';
    let top_player_button = '.player_btm__play';
    let top_player_button_icon = '.player_btm__play .fas';

    let modal_title = '#mPlayTitle';
    let modal_subtitle = "#mPlaySubtitle";
    let modal_description = '#mPlayDescription';
    let modal_thumbnail = '#mPlayThumb';
    let modal_player_previous = "#mPlayPrevious";
    let modal_player_next = "#mPlayNext";
    let modal_player_ff = '#mPlayForward';
    let modal_player_rw = '#mPlayRewind';
    let modal_player_button = '#mPlayButton';
    let modal_player_button_icon = modal_player_button + " i.fas";
    let modal_player_bar_seek = '#mPlaySeek';
    let modal_player_bar_starttimer = '#mPlayCurTime';
    let modal_player_bar_endtimer = '#mPlayTime';
    let modal_close = '#mPlayClose';
    let modal_open = '#mPlayOpen';
    let modal_player_bar = "#mPlayBar";

    let $modal_title = $('#mPlayTitle');
    let $modal_subtitle = $('#mPlaySubtitle');
    let $modal_description = $('#mPlayDescription');
    let $modal_thumbnail = $('#mPlayThumb');
    let $modal_player_previous = $("#mPlayPrevious");
    let $modal_player_next = $("#mPlayNext");
    let $modal_player_ff = $('#mPlayForward');
    let $modal_player_rw = $('#mPlayRewind');
    let $modal_player_button = $(modal_player_button);
    let $modal_player_bar_seek = $('#mPlaySeek');
    let $modal_player_bar_starttimer = $('#mPlayCurTime');
    let $modal_player_bar_endtimer = $('#mPlayTime');
    let $modal_close = $('#mPlayClose');
    let $modal_open = $('#mPlayOpen');

    let getSeekBarPosition = function(e) {
        var rect = e.target.getBoundingClientRect();
        var x = e.clientX - rect.left;
        var y = e.clientY - rect.top;
        return {
            x,
            y
        }
    }

    $(modal_player_bar).click(function(e) {
        console.log("attempting to seek location");
        let position = getSeekBarPosition(e);
        console.log(position);
        console.log(100 * position.x / e.target.clientWidth );
        seekPercent = position.x / e.target.clientWidth;
        console.log( "seekPercent: " + seekPercent);
        global_audio_player.currentTime = global_audio_player.duration * seekPercent;
    })

    

    
    var global_audio_player;
    var global_current_podcast = {};
    var global_player_type = "";

    var global_howler_player;

    
    let initGlobalPlayer = function() {
        debugInfo('INITGLOBALPLAYER', 'initialize triggers for global player');
        global_player_type = "web";

        global_audio_player.onplaying = function() {
            console.log("Event Listener: " + "global audio player");
            console.log(this);
            console.log("A short player");
            console.log('start show metadata');
            console.log(global_audio_player.metadata);
            console.log('end show metadata');
            $('.player_btm__inn .player_btm__timer , ' + top_player_timer).removeClass("d-none");
            $(top_player_duration).text(getDuration(global_audio_player.duration));
        }

        global_audio_player.ontimeupdate = function() {
            let cur_time = this.currentTime;
            var seconds = Math.floor(cur_time % 60);
            seconds = ('0' + seconds).substr(-2);
            var minutes = Math.floor( cur_time / 60);
            minutes = ('0' + minutes).substr(-2);
            updateGlobalTimer(minutes + ':' + seconds, cur_time, global_audio_player.duration );
        }
        global_audio_player.onpause = function() {
            console.log("PAUSED");
            $(top_player_button_icon + ', ' + modal_player_button_icon).addClass('fa-play');
            $(top_player_button_icon + ', ' + modal_player_button_icon).removeClass('fa-paused');
        }

        global_audio_player.onplay = function() {
            console.log("PLAYING");
            $(top_player_button_icon + ', ' + modal_player_button_icon).addClass('fa-pause');
            $(top_player_button_icon + ', ' + modal_player_button_icon).removeClass('fa-play');
            $(top_player_duration).removeClass("d-none");
            $(top_player_duration).text(getDuration(global_audio_player.duration));
        }

        global_audio_player.onprogress = function() {
            console.log('loading');
            updatePlayStatus('loading');
        }
        global_audio_player.playing = function() {
            updatePlayStatus('playing');
        }

        global_audio_player.playing = function() {
            console.log("Event Listener: " + "global audio player is playing");
            console.log(this);
            console.log("Playing current global player");
        }

        global_audio_player.timeupdate = function() {
            console.log("Event Listener: " + "global audio player has ended");
            console.log(this);
            console.log("Player has ended");
        }
    }


    let getDuration = function(audio_time) {
        sec = Math.floor( audio_time );    
        min = Math.floor( sec / 60 );
        min = min >= 10 ? min : '0' + min;    
        sec = Math.floor( sec % 60 );
        sec = sec >= 10 ? sec : '0' + sec;    
        return min + ':' + sec;
    }

    $top_player = $(top_player);
    $top_player_play_buttons = $(top_player_play_buttons);
    $episode_player = $(episode_player);
    $top_player_episode = $(top_player_episode);
    $top_player_title = $(top_player_title);
    $top_player_timer = $(top_player_timer);
    $top_player_button = $(top_player_button);
    $top_player_subtitle = $(top_player_subtitle);

    $modal_player_ff.click(function(e) {
        e.preventDefault();
        if( global_audio_player.duration > 0 ) {
            console.log("Fast Forward by 15 secs");
            let currentTime = global_audio_player.currentTime;
            global_audio_player.currentTime = currentTime + 15;
        }
    });

    $modal_player_rw.click(function(e) {
        e.preventDefault();
        if( global_audio_player.duration > 0 ) {
            console.log("Rewind by 15 secs");
            let currentTime = global_audio_player.currentTime;
            global_audio_player.currentTime = currentTime - 15;
        }
    });

    let debugInfo = function(name, description) {
        console.log('********************************');
        console.log(name + ' : ' + 'FUNCTION');
        console.log(description);
        console.log('********************************');
    }

    let isNumeric = function(num) {
        if( typeof num === "string" ) {
            if(num.match(/^-{0,1}\d+$/)){
                return true;
            }else if(num.match(/^\d+\.\d+$/)){
                return true;
            }else{
                return false;
            }
        } else {
            return true;
        }
        
        return false;
    }

    let buttonsResetToPlay = function(element_class) {

    }
    
    let togglePause = function(element_class) {

    };

    let initializeEpisodeButtons = function(type) {
        switch (type) {
            case "web":
            $('.post_player .fa-play').click( function(e) { triggerGlobalPlay(e, this, "page") } );
            $('.player_btm__play').click( function(e) { triggerGlobalTopPlay(e, this, "bottom"); });
            break;
            default: 
            break;
        }
        console.log("Configured Single Episode Buttons")
    }

    let showTopBar = function() {
        $top_player.removeClass('d-none');
    }

    let togglePlayButtons = function(play_button_elements) {
        play_button_elements.toggleClass('fa-play');
        play_button_elements.toggleClass('fa-pause');
    }

    let updateGlobalTimer = function(currentTimeString, current_time, duration) {
        $top_player_timer.text(currentTimeString);
        $modal_player_bar_endtimer.text(getDuration(global_audio_player.duration));
        $modal_player_bar_starttimer.text(currentTimeString);
        updateSeek(current_time, duration);
    }

    let updateSeek = function(current_time, duration) {
        $modal_player_bar_seek.css('left', 100 * current_time / duration + '%');
    }

    let updatePlayStatus = function(status) {
        switch(status) {
            case 'loading': $top_player_button.toggleClass('loading');
            case 'playing': $top_player_button.toggleClass('loading');
        }
    }
    let updateTopPlayerMeta = function(episode, title, subtitle, metadata) {

        if( !(typeof metadata.prev === "undefined" || metadata.prev === undefined) && !(typeof metadata.next === "undefined" || metadata.next === undefined)) {
            console.log('next: ' + metadata.next);
            console.log('prev: ' + metadata.prev);
        }
        
        console.log('Updating player meta: ' + 'ep: ' + episode + ' title: ' + title);
        if( isNumeric(episode) ) {
            $top_player_episode.text("Episode " + episode);
        } 
        else {
            $top_player_episode.text(episode);
        }
        
        $top_player_title.text(title);
        $top_player_subtitle.text(subtitle);
        $top_player.data('subtitle', subtitle);
        $top_player.data('episode', episode);
        $top_player.data('title', title);

        $top_player.data('episode', metadata.episode);
        $top_player.data('guest', metadata.guest);
        $top_player.data('company', metadata.company);
        $top_player.data('position', metadata.position);
        $top_player.data('title', metadata.title);
        $top_player.data('podcasturl', metadata.podcasturl);
        $top_player.data('shortdesc', metadata.shortdesc);
        $top_player.data('thumb', metadata.thumb);

        updateModal(episode, title, subtitle, metadata);
    }

    let updateModal = function( episode, title, subtitle, metadata ) {
        console.log("Updating Modal Window for : " + episode + " title: " + title);
        $modal_title.text(title);
        $modal_subtitle.text(subtitle);
        $modal_thumbnail.attr('src', metadata.thumb);
        $modal_thumbnail.attr('alt', title);
        $modal_description.text(metadata.description);
        debugInfo("updateModal", "Completed Updating Modal");
    }

    let showTopPlayer = function(top_player_el) {
        console.log('displaying top player');
        $(top_player_el).removeClass('d-none');
    }

    let hideTopPlayer = function(top_player_el) {
        console.log('hiding top player'); 
        $(top_player_el).addClass('d-none');
    }

    let getEpisodeMeta = function(episode_player) {
        debugInfo('getEpisodeMeta', 'get the episode meta data and return an object if found');
        $this_player = episode_player;
        console.log('Getting meta data');
        console.log('title: ' + $this_player.data('title') );
        console.log('episode: ' + $this_player.data('episode'));
        console.log('subtitle: ' + $this_player.data('guest') + ', ' + $this_player.data('title') + ' at ' + $this_player.data('company'));
        console.log('guest: ' + $this_player.data('guest'));
        console.log('company: ' + $this_player.data('company'));
        console.log('====');
        console.log($this_player.data);
        console.log('====');
        return { title: $this_player.data('title'), subtitle: $this_player.data('guest') + ', ' + $this_player.data('position') + ' at ' + $this_player.data('company'), episode: $this_player.data('episode'), position: $this_player.data('position'), guest: $this_player.data('guest'), company: $this_player.data('company'), episode_url: $this_player.data('podcasturl'), thumb: $this_player.data('thumb'), description: $this_player.data('shortdesc') };
    }

    let isGlobalPlayerPaused = function() {
        debugInfo('isGlobalPlayerPaused', 'Checks to make sure if the global player is paused');
        let audio = global_audio_player;
        if(typeof audio === "undefined" || audio === undefined)  {
            console.log('isGlobalPlayerPaused: Cannot stop global_audio_player: undefined player');
            return false;
        }
        else if (audio.duration > 0 && audio.paused) {
            console.log('isGlobalPlayerPaused: Player Status: Paused');
            return true;
        }
        console.log('isGlobalPlayerPaused: Player Status: Not Paused');
        return false;
    }

    let setGlobalPodcast = function(el) {
        console.log("Set Podcast");
        if( !(typeof global_current_podcast.el === "undefined" || global_current_podcast.el === undefined) ) {
            if(global_current_podcast.el != el) {
                console.log('not the same podcast');
                console.log('changing states');
                console.log(global_current_podcast.el);
                if( !isGlobalPlayerPaused() ) {
                    console.log('Triggering toggle play buttons for previous podcast.')
                    togglePlayButtons(global_current_podcast.el);
                } 
            }
            else {
                console.log('same podcast');
                console.log('Do nothing');
            }
        }
        global_current_podcast.el = el;
    }

    let loadGlobal = function playSound( url) {
        console.log('loading new player');
        console.log('url: ');
        console.log(url);
        global_audio_player = new Audio(url);
        if( hasSonixPlayer() === false ) {
            initGlobalPlayer();
            console.log(global_audio_player);
        }
    }

    let stopGlobal = function() {
        if(typeof global_audio_player === "undefined" || global_audio_player === undefined)  {
            console.log('Cannot stop global_audio_player: undefined player');
            return 'Undefined player';
        }
        global_audio_player.pause();
    }

    let pauseGlobal = function(player) {
        if(typeof global_audio_player === "undefined" || global_audio_player === undefined)  {
            console.log('Cannot pause player: undefined player');
            return 'Undefined player';
        }
        console.log("Pausing player");
        global_audio_player.pause();
    }

    let playGlobal = function(player) {
        if(typeof global_audio_player === "undefined" || global_audio_player === undefined)  {
            console.log('Cannot play player: undefined player');
            return 'Undefined player';
        }
        showTopBar();
        global_audio_player.play();
    }

    let playEpisodePodcast = function(url) {
        loadGlobal(url);
        playGlobal(global_audio_player);
    }

    let isPodcastPlaying = function(audio) {
        debugInfo("Is Audio Playing", "Given an audio instance, check and see if its playign");

        if(typeof audio === "undefined" || audio === undefined)  {
            console.log('Cannot stop global_audio_player: undefined player');
            return false;
        }
        else if (audio.duration > 0 && !audio.paused) {
            return true;
        }
        return false;
    }
    
    let getPlayer = function(type, _this) {
        switch(type) {
            case 'home':
            return $(_this).closest('.epidoes_list__links');
            case 'page':
            return $(_this).closest('.post_player');
            case 'modal':
            return $('.player_btm');
            case 'bottom':
            return $('.player_btm');
            default:
            console.log('Error returning type');
            return '';
        }
        return '';
    }

    let triggerGlobalPlay = function(e, _this, type) {
        e.preventDefault();
        
        debugInfo('clickEvent HomePage Podcast Play' , 'triggers when the user clicks on a podcast play button. returns nothing, serves as the trigger point for playing podcast');
        
        $this = $(_this);
        $this_player = getPlayer(type, _this);

        togglePlayButtons($(_this));

        if( !isPodcastPlaying(global_audio_player) ) {
            togglePlayButtons($top_player_play_buttons);
        }

        let episode_meta = getEpisodeMeta($this_player);
        episode_meta.next = "next";
        episode_meta.prev = "previous";
        let podcastUrl = episode_meta.episode_url;

        if( (typeof global_audio_player === "undefined" || global_audio_player === undefined ) ) {
            console.log("Playing a podcast from an empty state");
        }
        else {
            console.log('Podcast is currently loaded');
            if( global_audio_player.currentTime > 0 && global_audio_player.getAttribute('src') == podcastUrl) {
                console.log("There's a podcast playing");
                console.log("attempting to pause podcast now");
                console.log(global_audio_player);
                if( global_audio_player.paused ) {
                    playGlobal();
                    return '';
                } else {
                    pauseGlobal();
                    return '';
                }
            }
        }

        console.log('Playing episode: ' );
        console.log( $(_this).parents('.epidoes_list__links').data('title') );
        console.log('Episode Number:' );
        console.log($(_this).parents('.epidoes_list__links').data('episode'));
        console.log('Podcast URL');
        console.log($(_this).parents('.epidoes_list__links').data('podcasturl'));
        
        setGlobalPodcast( $(_this) );

        stopGlobal();
        updateTopPlayerMeta("Episode: " + episode_meta.episode + ", " + episode_meta.guest + " at " + episode_meta.company, episode_meta.title, episode_meta.subtitle, episode_meta );
        if( !hasSonixPlayer() ) {
            playEpisodePodcast(podcastUrl);
        }
    };

    let getDedicatedPagePlayerEl = function(episode_title) {
        let elSelector;

        if( $('body').hasClass('single-post') ) {
            elSelector = ".post_player .play_btn .fas";
        }
        else {
            return '.epidoes_list__links[data-title="' + episode_title  + '"] .fas, .post_player[data-title="' + episode_title + '"] .fas ';
        }
        return elSelector;
    }
    let triggerGlobalTopPlay = function(e, _this, type) {
        e.preventDefault();
        console.log('Homepage Podcast Play Button');

        if( (typeof global_audio_player === "undefined" || global_audio_player === undefined) )  {
            console.log("Playing a podcast from an empty state");

            $this = $(e.target);
            $this_player = getPlayer(type, e.target);
            let episode_meta = getEpisodeMeta($this_player);
            let episode_title = $top_player.data('title');
            let episode_el_play = getDedicatedPagePlayerEl(episode_title);
            let podcastUrl = episode_meta.episode_url;
            setGlobalPodcast( $(episode_el_play) );
            updateTopPlayerMeta("Episode: " + episode_meta.episode + ", " + episode_meta.guest + " at " + episode_meta.company, episode_meta.title, episode_meta.subtitle, episode_meta );
            
            togglePlayButtons( $(episode_el_play  ) );
            stopGlobal();
            playEpisodePodcast(podcastUrl);

        }
        else {
            console.log('Podcast is currently loaded');
            console.log("There's a podcast playing");
            console.log("attempting to pause podcast now");
            console.log(global_audio_player);
            let episode_title = $top_player.attr('title');
            let episode_el_play = '.epidoes_list__links[data-title="' + episode_title  + '"] .fas, .post_player[data-title="' + episode_title + '"] .fas ';
            console.log(episode_el_play);
            if( global_audio_player.paused ) {
                togglePlayButtons( $('.player_btm__play .fas, ' + episode_el_play  ) );
                playGlobal();
                return '';
            } else {
                togglePlayButtons( $(episode_el_play + ', .player_btm__play .fa-pause') );
                pauseGlobal();
                return '';
            }
        }
        
    };

    var site_ajax_url = "/wp-json/wp/v3/podcast-list";
    var data = {
        'action': 'load_podcasts_by_ajax',
        'page': 1,
        'security': '<?php echo wp_create_nonce("load_more_posts"); ?>'
    };
    let latestEpisodeList, playlistIDs;
    
    let updatePodcastList = function() {
        console.log("Updating the episode list on modal");
    }
    let findEpisodeByID = function(id) {
        return latestEpisodeList.filter(
            function(episode){ return episode.ID == id }
            );
    }

    $.get(site_ajax_url, data, function(response) {
        updatePodcastList(response);
        latestEpisodeList = response;
        console.log(response);
        latestEpisodeList = arrayToObject(latestEpisodeList, "ID");
        playlistIDs = Object.keys(latestEpisodeList);
    });

    let hasSonixPlayer = function() {
        if( $(sonix_player_button).length > 0 || $(sonix_embed_class).length > 0 ) {
            return false;
        }
        return false; 
    };

    const arrayToObject = (array, keyField) =>
    array.reduce((obj, item) => { 
        obj[item[keyField]] = item
        return obj;
    }, {});

    let noSonixPlayerWarning = function() {
        console.log("Warning, we're not using SonixPlayer on this page");
    };

    console.log("Configuring palyer");
    let page_player_query = '.post_player .fa-play';
    $page_player_button = $('.post_player .fa-play');
    var sonix_player_button = '.sonix--player-button-playpause-play';
    var sonix_embed_class = '.sonix--embed-container';

    let playPageEpisode = function() {
        let episode_meta = getEpisodeMeta($episode_player);
        episode_meta.next = "next";
        episode_meta.prev = "previous";
        updateTopPlayerMeta(episode_meta.episode, episode_meta.title, episode_meta.subtitle,  episode_meta);
        $('.sonix--player-button-playpause-play').click();
        showTopPlayer();
    }
    
    let initializePlayer = function() {    
        console.log('initializing player');

        $( window ).on( "load", function() {
            console.log('Items have been loaded');
            let episode_meta = getEpisodeMeta($('.post_player'));
            episode_meta.next = "next";
            episode_meta.prev = "previous";

            updateTopPlayerMeta(episode_meta.episode, episode_meta.title, episode_meta.subtitle,  episode_meta);

            if(hasSonixPlayer() ) {
                console.log("This player is using Sonix Player");
                global_player_type = "sonix";
                $play_buttons = $(play_buttons);

                $play_buttons.click(function(e) {
                    console.log('Player on Page clicked, starting to play podcast.');
                    e.preventDefault();
                    togglePlayButtons($play_buttons);
                    playPageEpisode();
                });

            } else {
                console.log("This player isn't using Sonix Player");
                global_player_type = "web";
                noSonixPlayerWarning();
                initializeEpisodeButtons("web");
                $(modal_player_button).click( function(e) {
                    triggerGlobalTopPlay(e, this, "modal")
                });

                
            }
        } );
    }

    
    if( $('body').hasClass('single-post') ) {
        console.log('Inintializing player from a podcast page.');
        initializePlayer();
    } else {
        let component_play = '.epidoes_list__links i';
        $(component_play).click( function(e) { triggerGlobalPlay(e, this, "home") } );
        $(modal_player_button).click( function(e) {
            triggerGlobalTopPlay(e, this, "modal")
        });

        $('.post_player .play_btn i:first').click( function(e) {
            triggerGlobalPlay(e, this, 'page');
        });

        $('.player_btm__play').click( function(e) { 
            triggerGlobalTopPlay(e, this, "bottom");
        });
    }
});