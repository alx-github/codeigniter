	<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
	<form class="form-signin" action="<?= site_url('/auth/login') ?>" method="POST">
		<h2 class="form-signin-heading text-center">フォーム投稿管理システム</h2>
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div>
			<?php 
				if($this->session->has_userdata('error_message')):
			 ?>
			<div class="alert alert-dismissable alert-danger">
				<button type="btn" class="close" data-dismiss="alert">x</button>
				<h4>エラー</h4>
				<p>
					<?= $this->session->flashdata('error_message')?>	
				</p>
				<?php $this->session->unmark_flash('error_message') ?>

			</div>

		<?php endif; ?>
				<div class="form-group">
					<label for="login_id" class="sr-only">ログインID</label>
					<input id="login_id" name="login_id" class="form-control" placeholder="ログインID" value="<?= isset($login_id) ? $login_id : '' ?>" required autofocus>
				</div>
			</div>
			<div>
				<div class="form-group">
					<label for="password" class="sr-only">パスワード</label>
					<input type="password" name="password" class="form-control" placeholder="パスワード" value="" required="true">
				</div>
			</div>
			<button class="btn btn-lg btn-primary btn-block" type="submit">ログインする</button>
		</div>
		
	</div>
	</form>
</div>