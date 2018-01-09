function getid(){
    var link = $('#link_getid').val();
    if(link.indexOf('photo.php?fbid=') !== -1){
        var id = link.match(/fbid=([0-9]{10,})(.*)/);
    }else if(link.indexOf('story_fbid') !== -1){
        var id = link.match(/fbid=([0-9]{10,})(.*)/);
    }else if(link.indexOf('posts') !== -1){
        var id = link.match(/posts\/([0-9]{10,})(.*)/);
    }else if(link.indexOf('photos') !== -1 && link.indexOf('permalink') !== -1){
        var id = link.match(/\/([0-9]{10,})(.*)/);
    }else{
        toastr.error("Link không hợp lệ.");
        return false;
    }
    $('#result_id').val(id[1]);
}
function getuid(){
    var link = $('#link_getuid').val();
    var patt1 = /https:\/\/www.facebook.com\/[a-zA-z0-9]{0,}(.*)/;
    var result = patt1.test(link);
    if(result == true){
        const proxyurl = "https://cors-anywhere.herokuapp.com/";
        const url = link; // site that doesn’t send Access-Control-*
        fetch(proxyurl + url) // https://cors-anywhere.herokuapp.com/https://example.com
        .then(response => response.text())
        .then(contents => $('#result_uid').val(contents.match(/entity_id":"([0-9]{12,18})/)[1]))
        .catch($('#result_uid').val("Waiting..."));        
    }else{
        toastr.error('Invalid Link');
    }

    
}