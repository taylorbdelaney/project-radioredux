var express = require('express');
var app = express();
var request = require('request');
var cheerio = require('cheerio');
var day = 2000;
var url = 'http://www.bobborst.com/popculture/top-100-songs-of-the-year/?year=' + day;

app.use(express.static('public'));

app.get('/index.htm', function (req, res) {
    res.sendFile(__dirname + "/" + "index.htm");
})

app.get('/process_get', function (req, res) {

    // Prepare output in JSON format
    response = {
        first_name: req.query.first_name,
        last_name: req.query.last_name
    };
    console.log(response);
    request(url, (function (day) {
            return function (err, resp, body) {
                var index = 1;
                $ = cheerio.load(body);
                while (index <= 100) {
                    if (err) {
                        throw err;
                    }
                    var tr = $("#pos" + index).parent();
                    var pos_el = tr.children("#pos" + index);
                    var artist_el = pos_el.next();
                    var song_el = artist_el.next();

                    var pos = pos_el.html();
                    var artist = artist_el.html();
                    var song = song_el.html();
                    song.replace("&apos;", "+");
                    var msg = "At #" + pos + " we have " + song + " by " + artist;
                    // p.innerHTML += msg;
                    console.log(msg);
                    index++;
                }
            }
        })
        (day)
    );
    res.end(JSON.stringify(response));
});

var server = app.listen(8081, function () {

    var host = server.address().address
    var port = server.address().port

    console.log("Example app listening at http://%s:%s", host, port)

})