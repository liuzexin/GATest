/**
 * Created by xin on 2017/1/18.
 */
/**
 * Created by xin on 2017/1/12.
 */
(function( $ ) {
    $.fn.marque = function(options) {

        // 插件的具体内容放在这里
        var sArr = [
            '.first-img',
            '.second-img',
            '.third-img',
            '.4th-img',
            '.5th-img',
            '.6th-img',
            '.7th-img',
            '.8th-img'
        ], currentRound=0,currentIndex=1, roundTotal= 4, currentTime=1500,totalTime=1500, timer=null,minTime=100,reduceStepTime=200,addTimeStep=50,desIndex= 0;
        var sArrCount = sArr.length;
        var defaultSettings = {
            ele:sArr,
            desIndex:desIndex,
            roundTotal:roundTotal,
            currentTime:currentTime,
            totalTime:totalTime,
            minTime:minTime,
            addTimeStep:addTimeStep,
            reduceTimeStep:reduceStepTime
        };
        var settings = $.extend(defaultSettings, options);


        function callback() {
            if (currentIndex > sArrCount - 1) {
                currentIndex = 0;
            }
            $(sArr[currentIndex]).addClass('active-gift');
            var beforeIndex = currentIndex - 1 < 0 ? sArrCount - 1 : currentIndex - 1;
            $(sArr[beforeIndex]).removeClass('active-gift');
            currentIndex++;

            if (currentIndex == sArrCount) {
                currentRound++;
            }
            if (currentRound == roundTotal + 1) {
                if (currentIndex - 1 == desIndex) {
                    clearTimeout(timer);
                    setTimeout(function () {
                        showGift(desIndex)
                        //finish
                    }, 2500);
                    return;
                }
            }

            if (currentRound > roundTotal - 1) {
                currentTime = currentTime + addTimeStep > totalTime ? totalTime : currentTime + addTimeStep;
            } else {
                currentTime = currentTime - reduceStepTime < minTime ? minTime : currentTime - reduceStepTime;
            }
            timer = setTimeout(callback, currentTime);
        }
    }
})( jQuery );
$.fn.marquee = function (){



};
$(function(){


});
