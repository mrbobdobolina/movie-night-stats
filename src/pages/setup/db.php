<?php

if(does_db_have_any_tables()){
	header('Location: '.WEB_ROOT.'/');
	die();
}

if(!empty($_POST['submit-empty'])){
	$sql_commands = file_get_contents(ROOT.'/init/blank_db.sql');
	db()->multi_query($sql_commands);
	header('Location: '.WEB_ROOT.'/');
	die();
}

if(!empty($_POST['submit-import'])){
	$sql_commands = file_get_contents($_FILES['sql-file']['tmp_name']);
	db()->multi_query($sql_commands);
	header('Location: '.WEB_ROOT.'/');
	die();
}

?>
<div class="container my-3">
	<h1>Initialize Database</h1>
	<form action="#" method="POST" class="row" enctype="multipart/form-data">
		<div class="col-12 col-sm-5 my-3">
			<input type="submit" class="btn btn-primary form-control" name="submit-empty" value="Create Empty Tables">
		</div>
		<div class="col-12 col-sm-2 my-3 text-center">
			OR
		</div>
		<div class="col-12 col-sm-5 my-3">
			<div class="row">
				<div class="col-12 my-2">
					<label for="sql-file" class="form-label">Upload SQL File</label>
					<input class="form-control" type="file" id="sql-file" name="sql-file">
				</div>
				<div class="col-12 my-2">
					<input type="submit" class="btn btn-primary form-control" name="submit-import" value="Import from file">
				</div>
			</div>
		</div>
	</form>
</div>
