<?php
if(isset($_POST['submit'])){
    $user = htmlentities($_POST['user']);
    $pass = md5($_POST['pass']);
    $check = $page->sqlite_single_row('select * from admin where username = "'.$user.'" and password = "'.$pass.'" and active = 1');
    if(sizeof($check) > 0){
        $_SESSION['thanhvien_admin'] = $check['id'];
        $_SESSION['admin'] = $check;
        header('location: /panel');
    }else{
        $err = 'Valid account or password';
    }
    
}
?>
<div class="container">
    <div class="row vertical-offset-100">
    	<div class="col-md-4 col-md-offset-4">
    		<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">Please sign in</h3>
			 	</div>
			  	<div class="panel-body">
			    	<form method="POST" role="form">
                    <fieldset>
			    	  	<div class="form-group">
			    		    <input class="form-control" placeholder="Username" name="user" type="text" />
			    		</div>
			    		<div class="form-group">
			    			<input class="form-control" placeholder="Password" name="pass" type="password" value="" />
			    		</div>
                        <p style="color: red;"><?=$err?></p>
			    		<input class="btn btn-lg btn-success btn-block" type="submit" name="submit" />
			    	</fieldset>
			      	</form>
			    </div>
			</div>
		</div>
	</div>
</div>
<style>
    .vertical-offset-100{
        padding-top:100px;
    }
</style>