function viewRec(opts) {
    var record,
        play,
        fn = {};
    var cache = {};
    var data = [];
    var timeCache;
    var index = 0;
    var config = $.extend({ interval: 500, mark_classname: "vr-mark", pointer_idname: "vr-pointer", target: window }, opts);
    var jquery = $(config.target);
    var _construct = function () {
        cache.btn = 0;
        cache.pointer = { x: 0, y: 0 };
        jquery.mousemove(function (e) {
            cache.pointer = { x: e.pageX, y: e.pageY };
        });
        jquery.mousedown(function (e) {
            if (e.which !== 0) {
                switch (e.button) {
                    case 0:
                        cache.btn = 1;
                        break;
                    case 1:
                        cache.btn = 2;
                        break;
                    case 2:
                        cache.btn = 3;
                        break;
                    default:
                        cache.btn = "N/A";
                        break;
                }
            }
        });
    };
    fn.version = "1.1";
    fn.startRecord = function () {
        fn.clearMark();
        fn.clearData();
        timeCache = new Date();
        record = setInterval(_updateData, config.interval);
        return this;
    };
    fn.stopRecord = function () {
        jquery.trigger("stop_record");
        clearInterval(record);
        return this;
    };
    var _updateData = function () {
        jquery.trigger("recording");
        var newTime = new Date();
        cache.scroll = { y: $(window).scrollTop(), x: $(window).scrollLeft() };
        cache.time = newTime - timeCache;
        cache.id = index;
        timeCache = newTime;
        data.push([cache.pointer.x, cache.pointer.y, cache.scroll.x, cache.scroll.y, cache.btn, cache.time, cache.id]);
        index++;
        cache.btn = 0;
        jquery.trigger("update");
    };
    fn.clearMark = function () {
        $("." + config.mark_classname).remove();
        return this;
    };
    fn.play = function () {
        if (!$("#" + config.pointer_idname).length) {
            $("body").after('<div id="' + config.pointer_idname + '" style="position:absolute;top:0;"></div>');
        }
        var i = 0;
        fn.clearMark();
        if (!play) {
            if (typeof data[i] !== "undefined") {
                play = setInterval(function () {
                    if (typeof data[i] !== "undefined") {
                        jquery.trigger("play");
                        $("#" + config.pointer_idname).animate({ top: data[i][1], left: data[i][0] }, data[i][5]);
                        $(window).scrollTop(data[i][3]);
                        $(window).scrollLeft(data[i][2]);
                        if (data[i][4] != 0) {
                            var btn = data[i][4] + " Click";
                            $("body").after('<div class="' + config.mark_classname + " " + btn + '" style="position:absolute;top:' + data[i][1] + "px;left:" + data[i][0] + 'px;">' + btn + "</div>");
                        }
                        i++;
                        console.log(data[i]);
                    } else {
                        fn.stop();
                    }
                }, data[i][5]);
            } else {
                fn.stop();
                console.log("No data");
            }
        }
        return this;
    };
    fn.stop = function () {
        clearInterval(play);
        jquery.trigger("stop");
        play = "";
        return this;
    };
    fn.getData = function () {
        return data;
    };
    fn.setData = function (d) {
        data = d;
        return this;
    };
    fn.clearData = function () {
        data = [];
        console.log("Data Cleared");
        return this;
    };
    fn.on = function (a, b) {
        return jquery.on(a, b);
    };
    _construct();
    return fn;
}
