import '@hundh/contao-utils-bundle';
import alertify from 'alertifyjs';

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
        document.querySelectorAll('[data-media="youtube"]').forEach(function(item) {
            if (item.getAttribute('data-autoplay')) {
                YouTubeBundle.initVideo(item);
            }
        });

        // handle click event
        utilsBundle.event.addDynamicEventListener('click', '[data-media="youtube"]', function(target) {
            YouTubeBundle.initVideo(target);
        });
    }

    static initVideo(el) {
        let video = el.parentNode.querySelector('.video-container'),
            iframe = video.querySelector('iframe');

        // stop playing video on closing any modal window
        utilsBundle.event.addDynamicEventListener('click', '[data-dismiss="modal"]', function(target) {
            if (null !== iframe) {
                iframe.setAttribute('src', iframe.getAttribute('data-src'));
            }
        });

        // stop playing video on closing any bootstrap modal
        document.addEventListener('hidden.bs.modal', function(e) {
            if (null !== iframe) {
                iframe.setAttribute('src', iframe.getAttribute('data-src'));
            }
        });

        if (el.getAttribute('data-privacy')) {
            // auto load privacy videos if set within cookie
            if (YouTubeBundle.getPrivacyAuto() == YouTubeBundle.getConfig().cookies.privacy.value) {
                iframe.setAttribute('src', iframe.getAttribute('data-src'));
                showVideo();
                return false;
            }

            let dialog = alertify.confirm().set({
                labels: {
                    ok: el.getAttribute('data-btn-privacy-ok') !== null ? el.getAttribute('data-btn-privacy-ok') : 'OK' ,
                    cancel: el.getAttribute('data-btn-privacy-cancel') !== null ? el.getAttribute('data-btn-privacy-cancel') : 'Cancel'
                },
                onshow: function() {
                    document.dispatchEvent(new CustomEvent('huh.youtube.event.alertify.onshow', {
                        bubbles: true,
                        cancelable: true,
                        detail: {
                            elements: dialog.elements
                        }
                    }));
                },
                defaultFocusOff: true,
                onfocus: function() {
                    document.dispatchEvent(new CustomEvent('huh.youtube.event.alertify.onfocus', {
                        bubbles: true,
                        cancelable: true,
                        detail: {
                            elements: dialog.elements
                        }
                    }));
                }
            });

            alertify.confirm('&nbsp;',
                el.getAttribute('data-privacy-html').replace(/\\"/g, '"'),
                function() {
                    if (dialog.elements.content.querySelector('[name=' + YouTubeBundle.getConfig().privacyAutoFieldName + ']').checked) {
                        YouTubeBundle.setPrivacyAuto();
                    }

                    iframe.setAttribute('src', iframe.getAttribute('data-src'));

                    showVideo();
                },
                function() {
                });

            return false;
        }

        if (null !== iframe) {
            iframe.setAttribute('src', iframe.getAttribute('data-src'));
        }

        showVideo();

        function showVideo() {
            el.classList.add('initialize');
            video.classList.add('initialize');
            if (null !== iframe) {
                iframe.setAttribute('src', iframe.getAttribute('src') + '&autoplay=1');
            }
            el.classList.remove('initialize');
            el.classList.remove('video-hidden');
            video.classList.remove('initialize');
            video.classList.remove('video-hidden');
        }
    }

    static setPrivacyAuto() {
        YouTubeBundle.createCookie(YouTubeBundle.getConfig().cookies.privacy.name, YouTubeBundle.getConfig().cookies.privacy.value, YouTubeBundle.getConfig().cookies.privacy.expire);
    }

    static getPrivacyAuto() {
        return YouTubeBundle.readCookie(YouTubeBundle.getConfig().cookies.privacy.name);
    }

    static createCookie(name, value, days) {
        let expires;

        if (days) {
            let date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = '; expires=' + date.toGMTString();
        } else {
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
        YouTubeBundle.createCookie(name, '', -1);
    }
}

export {YouTubeBundle};