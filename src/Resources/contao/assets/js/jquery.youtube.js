(function($)
{

    YouTubeVideo = {
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
        onReady: function()
        {
            // autoplay videos
            $('[data-media=youtube]').each(function()
            {
                if ($(this).data('autoplay'))
                {
                    YouTubeVideo.initVideo(this);
                }
            });

            // handle click event
            $('body').on('click', '[data-media=youtube]', function()
            {
                YouTubeVideo.initVideo(this);
            })
        },
        initVideo: function(el)
        {
            var $this = $(el),
                $video = $this.parent().find('.video-container'),
                $iframe = $video.find('iframe');

            if ($this.data('privacy'))
            {
                // auto load privacy videos if set within cookie
                if (YouTubeVideo.getPrivacyAuto() == YouTubeVideo.config.cookies.privacy.value)
                {
                    $iframe.attr('src', $iframe.data('src'));
                    showVideo();
                    return false;
                }

                var $modal = $this.parent().find('.modal.youtube-privacy');

                $modal.modal('show');

                $modal.find('form').on('submit', function(e)
                {
                    e.preventDefault();

                    if ($(this).find('[name=' + YouTubeVideo.config.privacyAutoFieldName + ']').is(':checked'))
                    {
                        YouTubeVideo.setPrivacyAuto();
                    }

                    $iframe.attr('src', $iframe.data('src'));

                    showVideo();

                    $modal.modal('hide');
                });

                return false;
            }

            $iframe.attr('src', $iframe.data('src'));

            showVideo();

            function showVideo()
            {
                $video.css('height', 0);
                $video.css('padding', 0);
                $iframe.css('height', 0);
                $video.show();
                $iframe.attr('src', $iframe.attr('src') + '&autoplay=1');

                $iframe.queue(function(next)
                {
                    $this.hide();
                    $video.css('height', '0');
                    $video.css('padding-bottom', '56.25%');
                    $video.css('padding-top', '0');
                    $(this).css({'opacity': '0', 'height': '100%'}).animate({'opacity': 1}, 1500); // use transition to hide youtube start image
                    next();
                });
            }
        },
        setPrivacyAuto: function()
        {
            this.createCookie(YouTubeVideo.config.cookies.privacy.name, YouTubeVideo.config.cookies.privacy.value, YouTubeVideo.config.cookies.privacy.expire);
        },
        getPrivacyAuto: function()
        {
            return this.readCookie(YouTubeVideo.config.cookies.privacy.name);
        },
        createCookie: function(name, value, days)
        {
            var expires;

            if (days)
            {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toGMTString();
            }
            else
            {
                expires = "";
            }
            document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
        },
        readCookie: function(name)
        {
            var nameEQ = encodeURIComponent(name) + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++)
            {
                var c = ca[i];
				while (c.charAt(0) === ' ')
				{
					c = c.substring(1, c.length);
				}
				if (c.indexOf(nameEQ) === 0)
				{
					return decodeURIComponent(c.substring(nameEQ.length, c.length));
				}
            }
            return null;
        },
        eraseCookie: function(name)
        {
            this.createCookie(name, "", -1);
        }
    };

    $(document).ready(function()
    {
        YouTubeVideo.onReady();
    });
})(jQuery);