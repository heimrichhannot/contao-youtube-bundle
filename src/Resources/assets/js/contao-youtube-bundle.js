import u from './node_modules/umbrellajs';

class YouTubeBundle {
    static getConfig() {
        return {
            cookies: {
                privacy: {
                    name: 'youtube-privacy',
                    value: 'auto',
                    expire: 365
                }
            },
            privacyAutoFieldName: 'youtubePrivacyAuto'
        };
    }

    static onReady() {
        // autoplay videos
        u('[data-media="youtube"]').each(function (node,i) {
            if (u(node).data('autoplay')) {
                YouTubeBundle.initVideo(node);
            }
        });

        // handle click event
        u('body').on('click', '[data-media="youtube"]', function () {
            YouTubeBundle.initVideo(this);
        });
    }

    static initVideo(el) {
        let $this = u(el),
            $video = $this.parent().find('.video-container'),
            $iframe = $video.find('iframe');

        // stop playing video on closing any modal window
        u('body').on('click', '[data-dismiss="modal"]', function () {
            $iframe.attr('src', $iframe.data('src'));
        });

        // stop playing video on closing any bootstrap modal
        u('body').on('hidden.bs.modal', function (e) {
            $iframe.attr('src', $iframe.data('src'));
        });

        if ($this.data('privacy')) {
            // auto load privacy videos if set within cookie
            if (YouTubeBundle.getPrivacyAuto() == YouTubeBundle.getConfig().cookies.privacy.value) {
                $iframe.attr('src', $iframe.data('src'));
                showVideo();
                return false;
            }

            // import(/* webpackChunkName: "bootbox" */ 'bootbox').then(bootbox => {
            //     var dialog = bootbox.dialog({
            //         message: $this.data('privacy-html').replace(/\\"/g, '"')
            //     });
            //
            //     dialog.init(function () {
            //         dialog.find('form').on('submit', function (e) {
            //             e.preventDefault();
            //
            //             if (u(this).find('[name=' + YouTubeBundle.getConfig().privacyAutoFieldName + ']').is(':checked')) {
            //                 YouTubeBundle.setPrivacyAuto();
            //             }
            //
            //             $iframe.attr('src', $iframe.data('src'));
            //
            //             showVideo();
            //
            //             dialog.modal('hide');
            //         });
            //     });
            // });

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
    }

    static setPrivacyAuto() {
        this.createCookie(YouTubeBundle.getConfig().cookies.privacy.name, YouTubeBundle.getConfig().cookies.privacy.value, YouTubeBundle.getConfig().cookies.privacy.expire);
    }

    static getPrivacyAuto() {
        return this.readCookie(YouTubeBundle.getConfig().cookies.privacy.name);
    }

    static createCookie(name, value, days) {
        let expires;

        if (days) {
            let date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = '; expires=' + date.toGMTString();
        }
        else {
            expires = '';
        }
        document.cookie = encodeURIComponent(name) + '=' + encodeURIComponent(value) + expires + '; path=/';
    }

    static readCookie(name) {
        let nameEQ = encodeURIComponent(name) + '=';
        let ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') {
                c = c.substring(1, c.length);
            }
            if (c.indexOf(nameEQ) === 0) {
                return decodeURIComponent(c.substring(nameEQ.length, c.length));
            }
        }
        return null;
    }

    static eraseCookie(name) {
        this.createCookie(name, '', -1);
    }
}

document.addEventListener('DOMContentLoaded', YouTubeBundle.onReady);