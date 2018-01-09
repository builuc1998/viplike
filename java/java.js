/*(function() {
    (function(f) {
        (function a() {
            try {
                function b(i) {
                    if (('' + (i / i)).length !== 1 || i % 20 === 0) {
                        (function() {}
                        ).constructor('debugger')();
                    } else {
                        debugger ;
                    }
                    b(++i);
                }
                b(0);
            } catch (e) {
                f.setTimeout(a, 5000)
            }
        })()
    })(document.body.appendChild(document.createElement('frame')).contentWindow);
}
)*/
function encode(data)
{
	return encodeURIComponent(data);
}
function LoadXmlDoc(url,element_id)
{
element=element_id
xmlHttp=GetXmlHttpObject(stateChanged)
xmlHttp.open("GET", url , true)
xmlHttp.send(null)
}
function LoadXmlDocPost(url,data,element_id)
{
data=data+'&ndacheck=1';
element=element_id
xmlHttp=GetXmlHttpObject(stateChanged)
xmlHttp.open("POST", url , true)
xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;");
xmlHttp.send(data)
}
function stateChanged()
{
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
{
try{document.getElementById(element).innerHTML=xmlHttp.responseXML.getElementsByTagName('data')[0].firstChild.data;
}catch(e)
{
}
try{
	eval(xmlHttp.responseXML.getElementsByTagName('java')[0].firstChild.data)
}
catch(e)
{
}
}
}
function GetXmlHttpObject(handler)
{
var objXmlHttp=null
if (navigator.userAgent.indexOf("Opera")>=0)
{
	objXmlHttp=new XMLHttpRequest()
	objXmlHttp.onload=handler
	objXmlHttp.onerror=handler
	return objXmlHttp
}
if (navigator.userAgent.indexOf("MSIE")>=0)
{
var strName="Msxml2.XMLHTTP"
if (navigator.appVersion.indexOf("MSIE 5.5")>=0)
{
strName="Microsoft.XMLHTTP"
}
try
{
objXmlHttp=new ActiveXObject(strName)
objXmlHttp.onreadystatechange=handler
return objXmlHttp
}
catch(e)
{
alert("Error. Scripting for ActiveX might be disabled")
return
}
}
if (navigator.userAgent.indexOf("Mozilla")>=0)
{
objXmlHttp=new XMLHttpRequest()
objXmlHttp.onload=handler
objXmlHttp.onerror=handler
return objXmlHttp
}
}
function create_get_element_array(array)
{
	var command="data='button="+array[0]+"';";
	var text_array='';
	var logic_array='';
	var select_one_array='';
	var textarea_array='';
	var frame_array='';
	var select_multiple='';
	var select_multiple_innerHTML='';
	var type;
	var i=0;
	for (a in array)
	{
		i++;
		if(i>1 & i<=array.length)
		{
			type=document.getElementById(array[a]).type;
			if(type=='text' || type=='hidden' || type=='password')
			{
				command=command+"data=data+'&"+array[a]+"='+encode(document.getElementById('"+array[a]+"').value);";
				text_array=text_array+' '+array[a];
			}			if(type=='checkbox')
			{
				command=command+"data=data+'&"+array[a]+"='+logic_to_01(document.getElementById('"+array[a]+"').checked);";
				logic_array=logic_array+' '+array[a];
			}
			if(type=='textarea')
			{
				command=command+"data=data+'&"+array[a]+"='+encode(document.getElementById('"+array[a]+"').value);";
				textarea_array=textarea_array+' '+array[a];
			}
			if(!type)
			{
				command=command+"data=data+'&"+array[a]+"='+encode(document.getElementById('"+array[a]+"').contentWindow.document.body.innerHTML);";
				frame_array=frame_array+' '+array[a];
			}

			if(type=='select-one')
			{
				command=command+"data=data+'&"+array[a]+"='+document.getElementById('"+array[a]+"').value;";
				select_one_array=select_one_array+' '+array[a];
			}
			if(type=='select-multiple')
			{
				command=command+"data=data+'&"+array[a]+"='+encode(document.getElementById('"+array[a]+"').value);";
				select_multiple=select_multiple+' '+array[a];
				command=command+"data=data+'&"+array[a]+"innerHTML='+encode(document.getElementById('"+array[a]+"').innerHTML);";
				select_multiple_innerHTML=select_multiple_innerHTML+' '+array[a];
			}
		}
	}
	command=command+"data=data+'&text_array='+'"+text_array+"';";
	command=command+"data=data+'&logic_array='+'"+logic_array+"';";
	command=command+"data=data+'&select_one_array='+'"+select_one_array+"';";
	command=command+"data=data+'&textarea_array='+'"+textarea_array+"';";
	command=command+"data=data+'&frame_array='+'"+frame_array+"';";
	command=command+"data=data+'&select_multiple='+'"+select_multiple+"';";
	command=command+"data=data+'&select_multiple_innerHTML='+'"+select_multiple_innerHTML+"';";
	return command;
}
function logic_to_01(value)
{
	if(value==true)
	{
		return 1;
	}else
	{
		return 0;
	}
}
function submit_form(echo_id,button_id,xml_file,array)
{
	try{document.getElementById(button_id).disabled=true;}
	catch(e){}
	ele_array=array.split(",");
	new_ele_array=new Array();
	new_ele_array[0]=button_id;
	i=0;
	if(ele_array.length>0)
	{
		for (a in ele_array)
		{
			i++;
			if(i<ele_array.length+1)
			{
				new_ele_array[i]=ele_array[a];
			}
		}
	}else
	{
		data='';
	}
	eval(create_get_element_array(new_ele_array));
	LoadXmlDocPost(xml_file,data,echo_id);
}
function submit_form2(echo_id,button_id,xml_file,divbao)
{
	var arr = new Array();
	var elestring='';
	var elems = document.getElementById(divbao).getElementsByTagName("*");
	for(var i = 0; i < elems.length; i++)
	{
	  var elem = elems[i];
	  var id = elem.getAttribute("id");
	  var type = elem.type;
	  if(type=='text' || type=='hidden' || type=='password')elestring=elestring+','+id;
	  if(type=='select-one')elestring=elestring+','+id;
	  if(type=='textarea')elestring=elestring+','+id;
	  if(type=='checkbox')elestring=elestring+','+id;
	  if(type=='select-multiple')elestring=elestring+','+id;
	}
	elestring=elestring.substr(1);
	submit_form(echo_id,button_id,xml_file,elestring)
}
function Float() {
	if(document.all) {
		document.all.common_echo.style.pixelTop=document.documentElement.scrollTop+0;
	}else
	{
		if(document.layers) {
			document.common_echo.top = window.pageYOffset;
		}
		if(document.getElementById) {
			document.getElementById('common_echo').style.top=window.pageYOffset+0 + 'px';
		}
	}
}
function showecho(ele,timeout,loi)
{
	document.getElementById(ele).style.display='none';
	setTimeout("document.getElementById('"+ele+"').style.display='block';",200)
	setTimeout("document.getElementById('"+ele+"').style.display='none';",timeout)
}
function showecho2(elm,timeout,loi)
{
    console.log(elm+timeout);
    $("#"+elm).addClass('transform');
	setTimeout("$('#"+elm+"').removeClass('transform');",timeout);
}
function add_dot(self)
{
	oldvalue=self.value;
	oldvalue=oldvalue.replace('.','');
	oldvalue=oldvalue.replace('.','');
	oldvalue=oldvalue.replace('.','');
	oldvalue=oldvalue.replace('.','');
	oldvalue=oldvalue.replace('.','');
	len=oldvalue.length;
	var returnvalue;
	var part1='';
	var part2='';
	var part3='';
	var part4='';
	if(len<=3){part1=oldvalue}
	if(len>3 & len<=6)
		{
			part1=oldvalue.substr(0,len-3);
			part2='.'+oldvalue.substr(len-3,3);
		}
	if(len>6 & len<=9)
		{
			part1=oldvalue.substr(0,len-6);
			part2='.'+oldvalue.substr(len-6,3);
			part3='.'+oldvalue.substr(len-3,3);
		}
	if(len>9 & len<=11)
		{
			part1=oldvalue.substr(0,len-9);
			part2='.'+oldvalue.substr(len-9,3);
			part3='.'+oldvalue.substr(len-6,3);
			part4='.'+oldvalue.substr(len-3,3);
		}
	if(len>11)
		{
			part1=''
		}
	returnvalue=part1+part2+part3+part4;
	self.value=returnvalue;
}
function comments(){
    $('#btn-auto').prop('disabled',true);
    id = $('#idpost_like').val();
    message = $('#noidung').val();
    limit  = $('#limit').val();
    data='id='+id+'&message='+message+'&limit='+limit;
    LoadXmlDocPost('app/autocmt.php',data);
}
function share(){
    id = $('#idpost_share').val();
    data='id='+id;
    LoadXmlDocPost('app/share.php',data);
}
function postgroup(){
    idgroup = $('#idgroup').val();
    link = $('#link').val();
    message = $('#message').val();
    data='group='+idgroup+'&message='+message+'&link='+link;
    LoadXmlDocPost('app/postgroup.php',data);
}
function getgroup(){
    token = $('#token').val();
    link = $('#link2').val();
    message = $('#message2').val();
    $('#getgr').html('<img src="templates/asset/img/ajax-loader.gif" />');
    if(token.replace(/\s/g, '').length == 0){
        alert('Bạn chưa nhập token');
        $('#getgr').html('Get');
        return false;
    }
    data='token='+token+'&message='+message+'&link='+link;
    LoadXmlDocPost('modules/get/group.php',data,'hihi');
}
function buffshare(){
    $('#btn-auto').prop('disabled',true);
    link = $('#link').val();
    message = $('#noidung').val();
    limit  = $('#limit').val();
    data='&message='+message+'&link='+link+'&limit='+limit;
    LoadXmlDocPost('app/buffshare.php',data,'hihi');
}
function delstatus(){
    $('#btn-auto').prop('disabled',true);
    limit = $('#limit').val();
    data='limit='+limit;
    LoadXmlDocPost('app/delstatus.php',data,'hihi');
}
function gettoken(){
    user = $('#username').val();
    pass = $('#password').val();
    data = 'user='+user+'&pass='+pass;
    LoadXmlDocPost('/modules/get/token_user_xml.php',data,'iframe_token');
}
function check_input_token(){
    $('.addon-login').addClass('text-btnlogin');
    $('#btnlogin').html('<i class="fa fa-cog fa-spin fa-fw"></i> Đang Xử Lý');
    token = $('#token_login').val();
/*    if(token.length < 10 && token.length == ''){

        alert('Vui lòng nhập token hợp lệ');

        return false;

    }*/
    data = 'token='+token;
    LoadXmlDocPost('/app/check_login.php',data);
}
function setid(id,elm_id){
    $('#idpost_like').val(id);

    $('html, body').animate({
        scrollTop: ($('#idpost_like').offset().top)
    },500);
}
function js_curl(link,method) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 || this.status == 200 || this.status == 400) {
      //document.getElementById("demo").innerHTML = this.responseText;
      console.log(this.responseText);
    }
  };
  xhttp.open(method, link, true);
  xhttp.send();
}
function logout(){
    LoadXmlDoc('logout.php');
}
function botlikes(){
    $('#btn-auto').prop('disabled',true);
    LoadXmlDocPost('/app/botlikes.php');
}
function botcomments(){
    $('#btn-auto').prop('disabled',true);
    noidung = $('#noidung').val();
    if(noidung.length < 1){
        alert('Vui lòng nhập nội dung');
        $('#btn-auto').prop('disabled',false);
        return false;
    }
    LoadXmlDocPost('/app/botcomments.php',"noidung="+encode(noidung));
}
function botuptop(){
    $('#btn-auto').prop('disabled',true);
    noidung = $('#noidung').val();
    id = $('#idpost_like').val();
    LoadXmlDocPost('/app/botuptop.php',"noidung="+encode(noidung)+"&id="+id);    
}