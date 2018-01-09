/*$(document).ready(function() {
 	$('#admin').owlCarousel({
		items:1,
		singleItem:true,
		autoPlay : true,
    	stopOnHover : true,
	});
});*/
$(document).ready(function() {
    //$('.sidebar-toggle').click();
    toastr.options.timeOut = 3000;
    toastr.options.progressBar = true;
    toastr.options.closeButton = true;
    $(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });
        // scroll body to 0px on click
        $('#back-to-top').click(function () {
            $('#back-to-top').tooltip('hide');
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
        
        $('#back-to-top').tooltip('show');
    $('input[name="username"]').on('change',function(){
        var username = $(this).val();
        if($(this).val().length < 6 || username.indexOf(' ') != -1){
            $(this).css({'border':'1px solid red'});
            toastr.error("Tên đăng nhập phải từ 6 ký tự trở lên và không chứa dấu cách(space)");
        }else{
            $(this).css({'border':'1px solid #d2d6de'});
            data = 'username='+username+'&check=1&elm='+$(this).attr('id');
            LoadXmlDocPost('handling/check_account.php',data);
        }
    });
    $('input[name="email"]').on('change',function(){
        var email = $(this).val();
        if(validateEmail(email) == false){
            $(this).css({'border':'1px solid red'});
            toastr.error("Vui lòng nhập Email hợp lệ");
        }else{
            $(this).css({'border':'1px solid #d2d6de'});
            data = 'email='+email+'&check=2&elm='+$(this).attr('id');
            LoadXmlDocPost('handling/check_account.php',data);
        }
    });
    $('input[name="password"]').on('change',function(){
        var password = $(this).val();
        if(password.length < 6 || password.indexOf(' ') != -1){
            $(this).css({'border':'1px solid red'});
            toastr.error("Mật khẩu phải từ 6 ký tự trở lên và không chứa dấu cách(space)");
        }else{
            $(this).css({'border':'1px solid #d2d6de'});
        }
    });
    $('input[name="repassword"]').on('change',function(){
        var password = $('#password_reg').val();
        var repassword = $(this).val();
        if(password != repassword){
            $(this).css({'border':'1px solid red'});
            toastr.error("Vui lòng nhập chính xác mật khẩu");
        }else{
            $(this).css({'border':'1px solid #d2d6de'});
        }
    });
    height = window.innerHeight;
    $('#load_post').css({
        'height': height - 115,
        'overflow-y': 'scroll',
        'max-width': '100%',
        'padding': '10px'
    });
});
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
function login_acount(){
    var username = $('#username').val();
    var password = $('#password').val();
    if(username.length < 1){
        toastr.error("Vui lòng nhập tài khoản");
        return false;
    }
    if(password.length < 1){
        toastr.error("Vui lòng nhập mật khẩu");
        return false;
    }
    data = 'username='+username+'&password='+password;
    LoadXmlDocPost('/handling/login_account.php',data);
}
function register(){
    var username = $('#username_reg').val();
    var email = $('#email_reg').val();
    var password = $('#password_reg').val();
    var re_password = $('#re_password_reg').val();
    var phone = $('#phone').val();
    var fullname = $('#fullname').val();
    var uid = $('#uid').val();
    //user
    if(username.length < 6 || username.indexOf(' ') != -1){
        $('#username_reg').css({'border':'1px solid red'});
        toastr.error("Tên đăng nhập phải từ 6 ký tự trở lên và không chứa dấu cách(space)");
        return false;
    }else{
        $('#username_reg').css({'border':'1px solid #d2d6de'});
    }
    //Email
    if(validateEmail(email) == false){
        $('#email_reg').css({'border':'1px solid red'});
        toastr.error("Vui lòng nhập Email hợp lệ");
        return false;
    }else{
        $("#email_reg").css({'border':'1px solid #d2d6de'});
    }
    //Pass
    if(password != re_password){
        $('#re_password_reg').css({'border':'1px solid red'});
        toastr.error("Vui lòng nhập chính xác mật khẩu");
        return false;
    }else{
        $('#re_password_reg').css({'border':'1px solid #d2d6de'});
    }
    if(password.length < 5){
        $('#password_reg').css({'border':'1px solid red'});
        toastr.error("Vui lòng mật khẩu");
        return false;
    }else{
        $('#password_reg').css({'border':'1px solid #d2d6de'});
    }
    if(re_password.length < 5){
        $('#re_password_reg').css({'border':'1px solid red'});
        toastr.error("Vui lòng xác nhận mật khẩu");
        return false;
    }else{
        $('#re_password_reg').css({'border':'1px solid #d2d6de'});
    }
    //phone
    if(phone.length < 5){
        $('#phone').css({'border':'1px solid red'});
        toastr.error("Vui lòng nhập số điện thoại");
        return false;
    }else{
        $('#fullname').css({'border':'1px solid #d2d6de'});
    }
    if(fullname.length < 5){
        $('#fullname').css({'border':'1px solid red'});
        toastr.error("Vui lòng nhập Họ Tên");
        return false;
    }else{
        $('#fullname').css({'border':'1px solid #d2d6de'});
    }
    //uid
    if(uid.length < 15 || uid.length > 18){
        $('#uid').css({'border':'1px solid red'});
        toastr.error("Vui lòng nhập UID Facebook");
        return false;
    }else{
        $('#uid').css({'border':'1px solid #d2d6de'});
    }
    data = 'username='+username+'&email='+email+'&password='+password+'&phone='+phone+'&fullname='+fullname+'&uid='+uid;
    LoadXmlDocPost('/handling/register.php',data);
}
function login_modal(){
    var username = $('#username_modal').val();
    var password = $('#password_modal').val();
    if(username.length < 1){
        toastr.error("Vui lòng nhập tài khoản");
        return false;
    }
    if(password.length < 1){
        toastr.error("Vui lòng nhập mật khẩu");
        return false;
    }
    data = 'username='+username+'&password='+password;
    LoadXmlDocPost('/handling/login_account.php',data);
}
function logout(){
    LoadXmlDocPost('/handling/logout.php');
}
function likes(){
    $('#btn-auto').prop('disabled',true);
    id = $('#idpost_like').val();
    type = $('#type').val();
    limit  = $('#limit').val();
    if(id.length < 14 || id == ''){
        toastr.error("Vui lòng ID cần tăng likes");
        $('#btn-auto').prop('disabled',false);
        return false;
    }
    data = 'id='+id+'&type='+type+'&limit='+limit;
    LoadXmlDocPost('app/autolikes.php',data);
}
function reactions(){
    $('#btn-auto').prop('disabled',true);
    id = $('#idpost_like').val();
    type = $('#type').val();
    limit  = $('#limit').val();
    if(id.length < 14 || id == ''){
        toastr.error("Vui lòng ID cần tăng likes");
        $('#btn-auto').prop('disabled',false);
        return false;
    }
    data = 'id='+id+'&type='+type+'&limit='+limit;
    LoadXmlDocPost('app/autoreactions.php',data);
}
function subscribe(){
    $('#btn-auto').prop('disabled',true);
    id = $('#uid_sub').val();
    limit = $('#limit').val();
    data='id='+id+'&limit='+limit;
    LoadXmlDocPost('app/subscribe.php',data);
}
function access_token(id){
    var token = $('#access_token').val();
    $.get('https://graph.facebook.com/v2.3/me?access_token=' + token + '&format=json&method=get',
        function(data2) {
            data = 'token='+token+'&id='+id;
            LoadXmlDocPost('/handling/update_access_token.php',data);
        })
    .fail(function() {
        toastr.error('Invalid Token');
    });
}
function checkToken() {
    var token = $('#token').val();
    $.get('https://graph.facebook.com/v2.3/me?access_token=' + token + '&format=json&method=get',
        function(data) {
            $('#uid').html(data.id);
            $('#name').html('Name : '+data.name);
            $('#check').val('1');
        })
    .fail(function() {
        $('#uid').html('');
        $('#name').html('');
        toastr.error('Invalid Token');
        $('#check').val('0');
    });
}
function install_botlike(){
    var token = $('#token').val();
    var check = $('#check').val();
    var uid = $('#uid').html();
    var type = $('#type').val();
    if(token == ''){
        toastr.error('Please enter a Token');
        return false;
    }else if(check == 0){
        toastr.error('The token you entered is invalid');        
        return false;
    }else{
        data = 'token='+token+'&type='+type+'&uid='+uid;
        LoadXmlDocPost('modules/bot/install_botlike.php',data);
    }
}
function get_token(){
    var user = $('#username_get').val();
    var pass = $('#password_get').val();
    if(user.length == '' || pass.length == ''){
        toastr.error('Please enter your account and password');
        return false;
    }else{
        data = 'username='+user+'&password='+pass;
        LoadXmlDocPost('handling/get_token.php',data,'result');
    }
}
function active_bot(uid){
    LoadXmlDoc('modules/bot/active.php?uid='+uid);
}
function check_token_account(token){
    var id = $('#id_user').val();
    $.get('https://graph.facebook.com/v2.3/me?access_token=' + token + '&format=json&method=get',
        function(data) {
        console.log(321);
        })
    .fail(function() {
        $("#input_token").html("<label>Access Token:</label><input type='text' onchange='access_token("+id+")' placeholder='Paste Access Token : EAAAAUaZA8jlABAFkkpnWcP8ZAHXNd8Dd1W2tZAxp5ljHE2EUspZBwSHqy0urrruGKIiknNoOF9af34WK' class='form-control add_token' id='access_token'>");
        $('#btn-auto').prop('disabled',true);
        toastr.options.timeOut = 30000;
        toastr.error('Bạn cần nhập Access Token để sử dụng chức năng này');
    });
}
function delete_bot(uid){
    data = 'uid='+uid;
    var confim = confirm('คุณแน่ใจว่าต้องการลบข้อมูลทิ้ง');
    if(confim == true){
        LoadXmlDocPost('modules/bot/delete.php',data);        
    }else{
        return false;
    }
}