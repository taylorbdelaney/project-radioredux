var request = require('request');
var cheerio = require('cheerio');
var fs = require('fs');

var day = 2000;
var url = 'http://www.bobborst.com/popculture/top-100-songs-of-the-year/?year=' + day;

request(url, (function (day) {
        return function (err, resp, body) {
            //initialize variables
            var index = 1;
            $ = cheerio.load(body);

            //initialize json
            var year, database, slots = [];
            var json = {
                year: "",
                database: slots
            };
            json.year = "2000";

            //loop through top 100 songs
            while (index <= 100) {
                if (err) {
                    throw err;
                }

                //get elements on DOM
                var tr = $("#pos" + index).parent();
                var pos_el = tr.children("#pos" + index);
                var artist_el = pos_el.next();
                var song_el = artist_el.next();

                //pull HTML out of elements
                var pos = pos_el.html();
                var artist = artist_el.html();
                var song = song_el.html();

                //TODO: apos-->'
                //song.replace("&apos;", "+");

                //create json structure
                var rank, artist, title,
                    data = {
                        rank: "",
                        metadata: {
                            title: "",
                            artist: ""
                        }
                    };

                //get array of data (slots), and add current data to it
                slots = json.database;
                data.rank = pos;
                data.metadata.artist = artist;
                data.metadata.title = song;
                slots.push(data);

                //re-insert the updated slots
                json.database = slots;


                var msg = "At #" + pos + " we have " + song + " by " + artist;
                console.log(msg);
                index++;
            }
            console.log("outputting json .... ");
            //console.log(JSON.stringify(json, null, 4));
            fs.writeFile('test2000.json', JSON.stringify(json, null, 4), function (err) {
                console.log('File successfully written! - Check your project directory for the test2000.json file');
            });
        }
    })
    (day)
);