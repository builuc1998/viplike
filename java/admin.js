$(document).ready(function() {
    $('#package,#time').on('change',function(){
        var package2 = $('#package').val();
        var time = $('#time').val();
        var total = package2 * time; 
        $('#total').val(total + '$');
    });
});
function setting_menu(){
    $('#btn-auto').prop('disabled',true);
    var name = $('#name_menu').val();
    var link  = $('#link_menu').val();
    var icon  = $('#icon_menu').val();
    if(name.length == '' ||link.length == '' ||icon.length == ''){
        toastr.error('Please enter full information');
        $('#btn-auto').prop('disabled',false);
        return false;
    }else{
        data = 'name='+name+'&link='+link+'&icon='+icon;
        LoadXmlDocPost('modules/menu/add_menu.php',data);
    }
}
function addvip(){
    var type = $('#type').val();
    var uid = $('#uid').val();
    var total = $('#total').val();
    var time = $('#time').val();
    var package2 = $('#package').val();
    var username = $('#username').val();
    var goi = $('#package option:selected').attr('goi');
    if(uid  == '' || time  == '' || username  == '' || package2 == 0){
        toastr.error('Please enter full information');
        return false;
    }else{
        data = 'uid='+uid+'&total='+total+'&time='+time+'&username='+username+'&type='+type+'&goi='+goi;
        LoadXmlDocPost('modules/vip/addvip_likes.php',data);
    }
}
function addmonney(id){
    var monney = $('#monney_'+id).val();
    LoadXmlDocPost('modules/member/add_monney.php','id='+id+'&monney='+monney);
}
function active_vip(uid){
    data = 'uid='+uid;
    LoadXmlDocPost('modules/vip/active.php',data);
}
function active_admin(id){
    data = 'id='+id;
    LoadXmlDocPost('modules/admin/active.php',data);
}
function active_menu(id){
    data = 'id='+id;
    LoadXmlDocPost('modules/menu/active.php',data);
}
function active_slide(id){
    data = 'id='+id;
    LoadXmlDocPost('modules/slidebar/active.php',data);
}
function delete_vip(id){
    data = 'id='+id;
    var confim = confirm('คุณแน่ใจว่าต้องการลบข้อมูลทิ้ง');
    if(confim == true){
        LoadXmlDocPost('modules/vip/delete.php',data);        
    }else{
        return false;
    }
}
function addadmin(){
    var username = $('#username').val();
    var email = $('#email').val();
    var password = $('#password_reg').val();
    var repassword = $('#repassword').val();
    console.log(username+email+password+repassword);
    if(username  == '' || email  == '' || password  == '' || repassword == 0){
        toastr.error('Please enter full information');
        return false;
    }
    if(username.length < 6 || username.indexOf(' ') != -1){
        $('#username').css({'border':'1px solid red'});
        toastr.error("Tên đăng nhập phải từ 6 ký tự trở lên và không chứa dấu cách(space)");
        return false;
    }else{
        $('#username').css({'border':'1px solid #d2d6de'});
    }
    if(email.length < 6 || email.indexOf(' ') != -1){
        $('#email').css({'border':'1px solid red'});
        toastr.error("Tên đăng nhập phải từ 6 ký tự trở lên và không chứa dấu cách(space)");
        return false;
    }else{
        $('#email').css({'border':'1px solid #d2d6de'});
    }
    if(password.length < 6 || password.indexOf(' ') != -1){
        $('#password_reg').css({'border':'1px solid red'});
        toastr.error("Tên đăng nhập phải từ 6 ký tự trở lên và không chứa dấu cách(space)");
        return false;
    }else{
        $('#password_reg').css({'border':'1px solid #d2d6de'});
    }
    if(password != repassword){
        $('#repassword').css({'border':'1px solid red'});
        toastr.error("Vui lòng nhập chính xác mật khẩu");
        return false;
    }else{
        $('#repassword').css({'border':'1px solid #d2d6de'});
    }
    data = 'username='+username+'&email='+email+'&password='+password;
    LoadXmlDocPost('modules/admin/add_admin.php',data);
}
function logout_admin(){
    LoadXmlDocPost('logout.php');
}
function edit_meta(type){
    var value = $('#'+type).val();
    LoadXmlDoc('modules/meta/edit.php?type='+type+'&value='+value);
}
function edit_slide(id,ten){
    var value = $('#'+ten+id).val();
    LoadXmlDoc('modules/slidebar/edit.php?ten='+ten+'&id='+id+'&value='+value);
}
function addslide(){
    var name = $('#name').val()
    var link = $('#link').val()
    var icon = $('#icon').val()
    if(name.length < 6 || link.length < 6 || icon.length < 6){
        toastr.error('Please enter full information');
        return false;
    }
    LoadXmlDoc('modules/slidebar/add.php?name='+name+'&link='+link+'&icon='+icon);
}
function changepass(id){
    var pass = $('#pass_'+id).val();
    LoadXmlDoc('modules/admin/changepass.php?pass='+encode(pass)+'&id='+id);
}