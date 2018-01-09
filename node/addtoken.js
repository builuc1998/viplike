var sqlite3 = require('sqlite3').verbose();
var db = new sqlite3.Database('/var/www/html/data/liker.db');	//':memory:'
var request = require('request');

/*db.serialize(function() {
	db.each("SELECT * FROM token limit 1000", function(error, row) {
        request('https://graph.facebook.com/100004520190007_840134952813837/reactions?type=LOVE&method=post&access_token='+row.token, function (error, response, body) {
        if (!error && response.statusCode == 200) {
            console.log(body) // Print the google web page.
          }
        })
	});
	
});*/