(function ($) {

    var YouTubeVideo = {
        config: {
            cookies: {
                privacy: {
                    name: 'youtube-privacy',
                    value: 'auto',
                    expire: 365
                }
            },
            privacyAutoFieldName: 'youtubePrivacyAuto'
        },
        onReady: function () {
            // autoplay videos
            $('[data-media=youtube]').each(function () {
                if ($(this).data('autoplay')) {
                    YouTubeVideo.initVideo(this);
                }
            });

            // handle click event
            $('body').on('click', '[data-media=youtube]', function () {
                YouTubeVideo.initVideo(this);
            })
        },
        initVideo: function (el) {
            var $this = $(el),
                $video = $this.parent().find('.video-container'),
                $iframe = $video.find('iframe');

            // stop playing video on closing any modal window
            $('body').on('click', '[data-dismiss="modal"]', function () {
                $iframe.attr('src', $iframe.data('src'));
            })

            // stop playing video on closing any bootstrap modal
            $('body').on('hidden.bs.modal', function (e) {
                $iframe.attr('src', $iframe.data('src'));
            })

            if ($this.data('privacy')) {
                // auto load privacy videos if set within cookie
                if (YouTubeVideo.getPrivacyAuto() == YouTubeVideo.config.cookies.privacy.value) {
                    $iframe.attr('src', $iframe.data('src'));
                    showVideo();
                    return false;
                }

                var $modal = $this.parent().find('.modal.youtube-privacy');

                if ($('body').find('.youtube-privacy-backdrop').length < 1) {
                    $('body').append('<div class="youtube-privacy-backdrop modal-backdrop fade show"></div>');
                }

                $modal.addClass('show');

                $modal.on('click', '[data-dismiss="modal"]', function () {
                    $modal.removeClass('show');
                    $('body').find('.youtube-privacy-backdrop').remove();
                })

                $modal.find('form').on('submit', function (e) {
                    e.preventDefault();

                    if ($(this).find('[name=' + YouTubeVideo.config.privacyAutoFieldName + ']').is(':checked')) {
                        YouTubeVideo.setPrivacyAuto();
                    }

                    $iframe.attr('src', $iframe.data('src'));

                    showVideo();

                    $('body').find('.youtube-privacy-backdrop').remove();
                    $modal.removeClass('show');
                });

                return false;
            }

            $iframe.attr('src', $iframe.data('src'));

            showVideo();

            function showVideo() {
                $this.addClass('initialize');
                $video.addClass('initialize');
                $iframe.attr('src', $iframe.attr('src') + '&autoplay=1');
                $this.removeClass(['initialize', 'video-hidden']);
                $video.removeClass(['initialize', 'video-hidden']);
            }
        },
        setPrivacyAuto: function () {
            this.createCookie(YouTubeVideo.config.cookies.privacy.name, YouTubeVideo.config.cookies.privacy.value, YouTubeVideo.config.cookies.privacy.expire);
        },
        getPrivacyAuto: function () {
            return this.readCookie(YouTubeVideo.config.cookies.privacy.name);
        },
        createCookie: function (name, value, days) {
            var expires;

            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toGMTString();
            }
            else {
                expires = "";
            }
            document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
        },
        readCookie: function (name) {
            var nameEQ = encodeURIComponent(name) + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) === ' ') {
                    c = c.substring(1, c.length);
                }
                if (c.indexOf(nameEQ) === 0) {
                    return decodeURIComponent(c.substring(nameEQ.length, c.length));
                }
            }
            return null;
        },
        eraseCookie: function (name) {
            this.createCookie(name, "", -1);
        }
    };

    document.addEventListener('DOMContentLoaded', function () {
        YouTubeVideo.onReady();
    });

})(u);
