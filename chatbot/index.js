var login = require("facebook-chat-api");
var request = require('request');
var answeredThreads = {};
// Create simple echo bot
login({email: "builuc1998", password: "29917668"}, function callback (err, api) {
    if(err) return console.error(err);
    api.listen(function callback(err, message) {
        var uid = message.threadID;
        request('http://sandbox.api.simsimi.com/request.p?key=3ec619b3-a256-4547-96b7-3333e18b28e0&lc=vn&ft=1.0&text='+message.body, function (error, response, hihi) {
        if (!error && response.statusCode == 200) {
            var text = JSON.parse(hihi);
            console.log(hihi);
            if(text.response){
                api.sendMessage(text.response,uid);
            }else if(text.result){
                api.sendMessage('Cút mẹ đi hỏi lằm hỏi lốn...',uid);
            }
            else{
                api.sendMessage('Mày bị ngu à tao bảo tao không hiểu mà.',uid);
            }

          }else{
            api.sendMessage('Khó quá e đéo trả lời đâu. lêu lêu...',uid);
          }
        });
   });
});