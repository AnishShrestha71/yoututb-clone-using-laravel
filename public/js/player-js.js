// const { default: axios } = require("axios");

var player = videojs('video')
var viewLogged = false
    player.on('timeupdate', function(){
        var percentagePlayed = Math.ceil((player.currentTime() / player.duration())* 100);
        
        
        if(percentagePlayed > 10 && !viewLogged)
        {

            axios.put('/video/' + window.CURRENT_VIDEO)
            viewLogged = true;
        }
    })