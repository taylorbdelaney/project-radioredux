var request = require('request');
var cheerio = require('cheerio');
var fs = require('fs');

var start = 1960,
    finish = 2015,
    top = 100; // number of songs per year (MAX==100)
var json_all = {
    alldata: []
};
var incomplete = true;

while (start <= finish) {
    var url = 'http://www.bobborst.com/popculture/top-100-songs-of-the-year/?year=' + start;
    var req = request(url, (function (start, json_all) {
            return function (err, resp, body) {
                //initialize variables
                var index = 1;
                $ = cheerio.load(body);

                //initialize json
                var database, slots = [];
                var json = {
                    year: "",
                    database: slots
                };
                json.year = start;

                //loop through top 100 songs
                while (index <= top) {
                    if (err) {
                        throw err;
                    }

                    //get elements on DOM
                    var tr = $("#pos" + index).parent();
                    var pos_el = tr.children("#pos" + index);
                    if (pos_el === undefined) {
                        console.log("RAN OUT OF SONGS ON WEBPAGE. Breaking now.");
                        break;
                    }
                    var artist_el = pos_el.next();
                    var song_el = artist_el.next();

                    //pull HTML out of elements
                    var pos = pos_el.html();
                    var artist = artist_el.html();
                    var song = song_el.html();


                    //trim unicode stuff (&apos;)
                    song = trim(song);
                    artist = trim(artist);
                    var msg = "At #" + pos + " we have " + song + " by " + artist;
                    //console.log(msg);
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




                    //TODO: Put all this shit in a trim(str) method that takes
                    //a string and takes out all quotations/apos's
                    //trim both artist and title track.

                    index++;
                } //end loop

                //if we're finished, allow the file to output
                //console.log("year: " + start + ". finish: " + finish);
                //print to test top 100 json
                //console.log("printing current json(little)...");
                //console.log(JSON.stringify(json, null, 4));

                //get slots of alldata and add the current year's top 100 to it.
                var alldata_slots = json_all.alldata;
                alldata_slots.push(json);
                json_all.alldata = alldata_slots;

                //post-insert check
                //console.log("printing current json_all post-insert...");
                //console.log(JSON.stringify(json_all, null, 4));

                //console.log("outputting...");
                //console.log("********************");
                var outfile = "./json/test/data" + start + ".json"
                fs.writeFile(outfile, JSON.stringify(json_all, null, 4), function (err) {
                    console.log('File successfully written! - Check ' + outfile + ' for file');
                });
            }
        })
        (start, json_all)
    );
    console.log("done: " + start);
   //console.log("**********************");
    //console.log(req.incomplete);

    start++;
}

function trim(str) {
    var apos = "&apos;",
        quot = "&quot;";
    var apos_index = str.indexOf(apos),
        quot_index = str.indexOf(quot);

    //trim for apos
    while (apos_index !== -1) {
        //console.log("look for " + apos + " at " + apos_index);
        str = str.replace(apos, "'");
        apos_index = str.indexOf(apos);
    }

    //trim for quot
    while (quot_index !== -1) {
        //console.log("look for " + quot + " at " + quot_index);
        str = str.replace(quot, '"');
        quot_index = str.indexOf(quot);
    }
    
    //console.log("...finished trimming");
    return str;

}
//console.log("hey we're at the end...");
//console.log("year: " + start + ". finish: " + finish);
//console.log(JSON.stringify(json_all, null, 4));
//    console.log("outputting json .... ");
//    console.log(JSON.stringify(json_all, null, 4));
//
//    var outfile = start + ".json"
//    fs.writeFile(outfile, JSON.stringify(json_all, null, 4), function (err) {
//        console.log('File successfully written! - Check your project directory for the ' + outfile + ' file');
//    });