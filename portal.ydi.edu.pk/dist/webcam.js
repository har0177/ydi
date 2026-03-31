// WebcamJS v2.0.0 - Modern replacement using native getUserMedia API
// Drop-in replacement for jhuckaby/webcamjs - same API (set, attach, snap, on, off, reset)
// Works on desktop and mobile browsers (Android Chrome, iOS Safari 14.5+)
// Requires HTTPS (except localhost)

(function(window) {
    'use strict';

    var Webcam = {
        version: '2.0.0',

        // state
        loaded: false,
        live: false,
        stream: null,
        video: null,
        container: null,
        preview_active: false,
        preview_canvas: null,

        // default params
        params: {
            width: 320,
            height: 240,
            dest_width: 0,
            dest_height: 0,
            image_format: 'jpeg',
            jpeg_quality: 90,
            flip_horiz: false,
            facingMode: 'user',
            constraints: null,
            unfreeze_snap: true,
            user_callback: null,
            user_canvas: null
        },

        hooks: {},

        // set one or more params
        set: function() {
            if (arguments.length === 1 && typeof arguments[0] === 'object') {
                for (var key in arguments[0]) {
                    if (arguments[0].hasOwnProperty(key)) {
                        this.params[key] = arguments[0][key];
                    }
                }
            } else if (arguments.length === 2) {
                this.params[arguments[0]] = arguments[1];
            }
        },

        // register event callback
        on: function(name, callback) {
            name = name.replace(/^on/i, '').toLowerCase();
            if (!this.hooks[name]) this.hooks[name] = [];
            this.hooks[name].push(callback);
        },

        // remove event callback
        off: function(name, callback) {
            name = name.replace(/^on/i, '').toLowerCase();
            if (this.hooks[name]) {
                if (callback) {
                    var idx = this.hooks[name].indexOf(callback);
                    if (idx > -1) this.hooks[name].splice(idx, 1);
                } else {
                    this.hooks[name] = [];
                }
            }
        },

        // fire event
        dispatch: function() {
            var name = arguments[0].replace(/^on/i, '').toLowerCase();
            var args = Array.prototype.slice.call(arguments, 1);

            if (this.hooks[name] && this.hooks[name].length) {
                for (var i = 0; i < this.hooks[name].length; i++) {
                    var hook = this.hooks[name][i];
                    if (typeof hook === 'function') {
                        hook.apply(this, args);
                    }
                }
                return true;
            } else if (name === 'error') {
                var message = (args[0] && args[0].message) ? args[0].message : String(args[0]);
                alert('Webcam Error: ' + message);
            }
            return false;
        },

        // detect if running on mobile
        _isMobile: function() {
            return /Android|iPhone|iPad|iPod|Mobile|webOS|BlackBerry|Opera Mini|IEMobile/i.test(navigator.userAgent);
        },

        // build video constraints
        _getConstraints: function() {
            if (this.params.constraints) {
                return {
                    audio: false,
                    video: this.params.constraints.video || this.params.constraints
                };
            }

            if (this._isMobile()) {
                return {
                    audio: false,
                    video: {
                        facingMode: this.params.facingMode || 'user'
                    }
                };
            }

            return {
                audio: false,
                video: {
                    facingMode: this.params.facingMode || 'user',
                    width: { ideal: this.params.dest_width },
                    height: { ideal: this.params.dest_height }
                }
            };
        },

        // start the camera stream (called after user gesture on mobile)
        _startCamera: function() {
            var self = this;
            var elem = this.container;

            // clear container
            elem.innerHTML = '';

            // create video element
            var video = document.createElement('video');
            video.setAttribute('autoplay', '');
            video.setAttribute('playsinline', '');
            video.setAttribute('muted', '');
            video.muted = true;
            video.style.width = this.params.width + 'px';
            video.style.height = this.params.height + 'px';
            video.style.objectFit = 'cover';

            if (this.params.flip_horiz) {
                video.style.transform = 'scaleX(-1)';
            }

            elem.appendChild(video);
            this.video = video;

            var constraints = this._getConstraints();

            navigator.mediaDevices.getUserMedia(constraints)
            .then(function(stream) {
                self.stream = stream;
                video.srcObject = stream;

                video.onloadedmetadata = function() {
                    video.play().then(function() {
                        self.loaded = true;
                        self.live = true;
                        self.dispatch('load');
                        self.dispatch('live');
                    }).catch(function() {
                        video.muted = true;
                        video.play().then(function() {
                            self.loaded = true;
                            self.live = true;
                            self.dispatch('load');
                            self.dispatch('live');
                        }).catch(function(err2) {
                            self.dispatch('error', err2);
                        });
                    });
                };
            })
            .catch(function(err) {
                self.dispatch('error', err);
            });
        },

        // attach webcam to DOM element
        attach: function(elem) {
            if (typeof elem === 'string') {
                elem = document.getElementById(elem.replace(/^#/, '')) || document.querySelector(elem);
            }
            if (!elem) {
                return this.dispatch('error', new Error('Could not locate DOM element to attach to.'));
            }

            this.container = elem;
            elem.innerHTML = '';

            // set width/height from element if not set
            if (!this.params.width) this.params.width = elem.offsetWidth || 320;
            if (!this.params.height) this.params.height = elem.offsetHeight || 240;
            if (!this.params.dest_width) this.params.dest_width = this.params.width;
            if (!this.params.dest_height) this.params.dest_height = this.params.height;

            // check for getUserMedia support
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                return this.dispatch('error', new Error(
                    'getUserMedia is not supported. Please use HTTPS and a modern browser.'
                ));
            }

            var self = this;

            // on mobile, show a tap-to-start button (user gesture required for camera permission)
            if (this._isMobile()) {
                var btn = document.createElement('div');
                btn.style.cssText = 'width:' + this.params.width + 'px;height:' + this.params.height + 'px;'
                    + 'display:flex;align-items:center;justify-content:center;cursor:pointer;'
                    + 'background:#f0f0f0;border:2px dashed #999;border-radius:8px;text-align:center;';
                btn.innerHTML = '<div style="font-size:14px;color:#333;">'
                    + '<div style="font-size:32px;margin-bottom:8px;">📷</div>'
                    + '<b>Tap to start camera</b></div>';

                btn.addEventListener('click', function() {
                    self._startCamera();
                });

                elem.appendChild(btn);
            } else {
                // on desktop, start camera immediately
                this._startCamera();
            }
        },

        // take a snapshot
        snap: function(user_callback, user_canvas) {
            if (!user_callback) user_callback = this.params.user_callback;
            if (!user_canvas) user_canvas = this.params.user_canvas;

            if (!this.loaded || !this.video) {
                return this.dispatch('error', new Error('Webcam is not loaded yet'));
            }
            if (!user_callback) {
                return this.dispatch('error', new Error('Please provide a callback function to snap()'));
            }

            // if preview is active, use that
            if (this.preview_active && this.preview_canvas) {
                var pc = this.preview_canvas;
                var pctx = pc.getContext('2d');
                if (user_canvas) {
                    var uctx = user_canvas.getContext('2d');
                    uctx.drawImage(pc, 0, 0);
                }
                user_callback(
                    user_canvas ? null : pc.toDataURL('image/' + this.params.image_format, this.params.jpeg_quality / 100),
                    pc,
                    pctx
                );
                if (this.params.unfreeze_snap) this.unfreeze();
                return null;
            }

            // create canvas and capture frame
            var canvas = document.createElement('canvas');
            canvas.width = this.params.dest_width;
            canvas.height = this.params.dest_height;
            var context = canvas.getContext('2d');

            if (this.params.flip_horiz) {
                context.translate(this.params.dest_width, 0);
                context.scale(-1, 1);
            }

            context.drawImage(this.video, 0, 0, this.params.dest_width, this.params.dest_height);

            // render to user canvas if provided
            if (user_canvas) {
                var user_context = user_canvas.getContext('2d');
                user_context.drawImage(canvas, 0, 0);
            }

            // fire callback
            user_callback(
                user_canvas ? null : canvas.toDataURL('image/' + this.params.image_format, this.params.jpeg_quality / 100),
                canvas,
                context
            );

            return null;
        },

        // freeze preview
        freeze: function() {
            if (this.preview_active) this.unfreeze();

            var canvas = document.createElement('canvas');
            canvas.width = this.params.dest_width;
            canvas.height = this.params.dest_height;
            var context = canvas.getContext('2d');

            if (this.params.flip_horiz) {
                context.translate(this.params.dest_width, 0);
                context.scale(-1, 1);
            }

            context.drawImage(this.video, 0, 0, this.params.dest_width, this.params.dest_height);

            canvas.style.width = this.params.width + 'px';
            canvas.style.height = this.params.height + 'px';
            canvas.style.objectFit = 'cover';

            // hide video, show canvas
            if (this.video) this.video.style.display = 'none';
            this.container.appendChild(canvas);

            this.preview_canvas = canvas;
            this.preview_active = true;
        },

        // unfreeze and resume live video
        unfreeze: function() {
            if (this.preview_active) {
                if (this.preview_canvas && this.preview_canvas.parentNode) {
                    this.preview_canvas.parentNode.removeChild(this.preview_canvas);
                }
                this.preview_canvas = null;
                this.preview_active = false;
                if (this.video) this.video.style.display = '';
            }
        },

        // stop webcam and clean up
        reset: function() {
            if (this.preview_active) this.unfreeze();

            if (this.stream) {
                var tracks = this.stream.getTracks();
                for (var i = 0; i < tracks.length; i++) {
                    tracks[i].stop();
                }
                this.stream = null;
            }

            if (this.video) {
                this.video.srcObject = null;
                this.video = null;
            }

            if (this.container) {
                this.container.innerHTML = '';
                this.container = null;
            }

            this.loaded = false;
            this.live = false;
        },

        // upload image data to server via AJAX
        upload: function(image_data_uri, target_url, callback) {
            var form_elem_name = this.params.upload_name || 'webcam';
            var image_fmt = '';
            if (image_data_uri.match(/^data:image\/(\w+)/)) {
                image_fmt = RegExp.$1;
            } else {
                throw 'Cannot locate image format in Data URI';
            }

            var raw_image_data = image_data_uri.replace(/^data:image\/\w+;base64,/, '');
            var binary = atob(raw_image_data);
            var array = new Uint8Array(binary.length);
            for (var i = 0; i < binary.length; i++) {
                array[i] = binary.charCodeAt(i);
            }

            var blob = new Blob([array], { type: 'image/' + image_fmt });
            var form = new FormData();
            form.append(form_elem_name, blob, form_elem_name + '.' + image_fmt.replace(/e/, ''));

            var http = new XMLHttpRequest();
            http.open('POST', target_url, true);

            if (http.upload && http.upload.addEventListener) {
                http.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        Webcam.dispatch('uploadProgress', e.loaded / e.total, e);
                    }
                }, false);
            }

            var self = this;
            http.onload = function() {
                if (callback) callback.apply(self, [http.status, http.responseText, http.statusText]);
                Webcam.dispatch('uploadComplete', http.status, http.responseText, http.statusText);
            };

            http.send(form);
        }
    };

    // clean up on page unload
    window.addEventListener('beforeunload', function() {
        Webcam.reset();
    });

    // export
    if (typeof define === 'function' && define.amd) {
        define(function() { return Webcam; });
    } else if (typeof module === 'object' && module.exports) {
        module.exports = Webcam;
    } else {
        window.Webcam = Webcam;
    }

}(window));
