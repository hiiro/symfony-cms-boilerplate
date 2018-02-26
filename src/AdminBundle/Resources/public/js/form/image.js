$(function () {
    $.fn.imageUploadable = function(options) {
        options = $.extend({}, {
            accept: function (file, done) {
                return done();
            },
            debug: false,
            url: '/admin/file/upload',
            clickable: false,
            acceptedFiles: '.jpg,.jpeg,.png,.gif',
        }, options);
        return this.each(function () {
            var $widget, defaultClickable;
            var dzParams = {};
            $widget = $(this);
            defaultClickable = options.clickable;
            if ($widget.find('.image-fallback').size() > 0 && $widget.find('.image-fallback').attr('id')) {
                defaultClickable = '#' + $widget.find('.image-fallback').attr('id');
            }
            return $(this).dropzone({
                url: options.url,
                uploadprogress: function (file, percent, bytes) {
                    return $widget.find('.upload-progress').css('width', percent + '%');
                },
                sending: function () {
                    $widget.find('.progress').show();
                    return $widget.find('.upload-progress').css('width', 0);
                },
                success: function (file, json) {
                    setTimeout(function () {
                        $widget.find('.progress').hide();
                        return $widget.find('.upload-progress').css('width', 0);
                    }, 500);
                    return $widget.trigger('success', json);
                },
                accept: options.accept || function (file, done) {
                    return done();
                },
                clickable: defaultClickable,
                acceptedFiles: options.acceptedFiles,
            });
        });
    };

    $.fn.imageWidget = function() {
        return $(this).each(function() {
            var $uploadable, filter, success;
            $uploadable = $(this).find('.image-uploadable');
            $uploadable.imageUploadable();
            filter = $uploadable.data('filter');
            success = function(e, json) {
                if (typeof json.errors !== 'undefined') {
                    if (json.errors.length) {
                        alert(json.errors.join('\n'));
                        return false;
                    }
                }
                var $img, path;
                path = json.thumbnails[filter] || 'contents';
                path = json.path || 'contents';
                $img = $("<img class=\"img-responsive\" src=\"" + path + "\"></img>");
                $uploadable.find('.preview').html($img);
                $uploadable.find('.preview').removeClass('empty');
                $uploadable.find(':hidden').val(json.path);
                $uploadable.find('.image-fallback').hide();
                return $uploadable.find('.buttons-container').show();
            };
            $uploadable.on('success', success);
            $uploadable.find('.image-remove').click(function() {
                $uploadable.find('.preview').empty();
                $uploadable.find('.preview').addClass('empty');
                $uploadable.find('input:hidden').val('');
                $uploadable.find('.image-fallback').show();
                $uploadable.find('.buttons-container').hide();
                return false;
            });
        });
    };

    $('.image-widget').imageWidget();

});