var fs = require('fs');
var path = './json/test';
var files = fs.readdirSync(path);

console.log("start picking...");
var max = 0,
    picked;

for (var i in files) {
    console.log(files[i]);
    var file = files[i];
    console.log("! file: " + file);
    var obj = JSON.parse(fs.readFileSync(path + "/" + file, 'utf8'));
    var str = JSON.stringify(obj, null, 4);
    var length = str.length;
    if (length > max) {
        picked = file;
        max = length;
        console.log("new max! : " + file + " w/ length=" + max);
    }

    console.log("final pick! : " + file + " w/ length=" + max);

}
