<div class="container">
	<div class="row">
		<ul class="breadcrumb">
			<li><a href="<?= site_url('/account') ?>">アカウント管理</a></li>
			<li class="active"><?= empty($account) ? '登録' : '更新' ?></li>
		</ul>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?php 
				if($this->session->flashdata('error_message')):
			 ?>
			<div class="alert alert-dismissable alert-danger">
				
				<h4>エラー</h4>
				<p>
					<?= $this->session->flashdata('error_message')?>	
				</p>
				<?php $this->session->unmark_flash('error_message') ?>

			</div>

		<?php endif; ?>
			<form class="form-horizontal" action="<?=site_url( (empty($account['id'])) ? '/account/insert' : 'account/update' )  ?>" method="POST">
				<fieldset class="well" style="border-radius: 5px;">
					<div class="form-group">
						<div class="col-md-2 text-right">
							<label for="login_id" class="col-md-offset-6 control-label">ID</label>
						</div>
						<div class="col-md-8">
						<?php if($account['login_id']): ?>
							<input type="hidden" name="id" class="  form-control" required="true" readonly="true" value="<?=$account['id']?>">
							<input type="text" name="login_id" class="  form-control" required="true" readonly="true" value="<?=$account['login_id']?>">
						
					<?php else: ?>
							<input type="text" name="login_id" class="  form-control" required="true">
					<?php endif; ?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-2 text-right">
							<label for="password" class="col-md-offset-6 control-label">Password</label>
						</div>
						<div class="col-md-5">
							<?php if($account['login_id']): ?>
								<input type="text" name="password" id="password" class=" form-control">
							<?php else: ?>
								<input type="text" name="password" id="password" class=" form-control" required="true">
							<?php endif; ?>
						</div>
						<div class="col-md-3">
							<a href="" data-url="<?= site_url('/api/generate_password') ?>" class="btn btn-block btn-default js-generate-password">パスワード生成</a>
						</div>

					</div>
					<?php if($account['login_id']):?>
					<div class="col-md-offset-2 col-md-9">
							<p class="text-warning">※ パスワードを変更する場合のみ入力してください。</p>
					</div>
				<?php endif; ?>
					<div class="form-group">
						<div class="col-md-2 text-right">
							<label for="type" class="col-md-offset-6 control-label">Type</label>
						</div>
						<div class="col-md-2">
						<?php if ($this->session->userdata('type') == 1): ?>
							<?php if($account['login_id']): ?>
									<?php if($account['type'] == 1): ?>
									   <div class="radio">
								      		<label ><input type="radio" name="type" value="1" checked="true">Admin</label>
								  		</div>
							   			<div class="radio">
									      <label><input type="radio" name="type" value="0" >User</label>
									   </div>
									<?php else: ?>
										 <div class="radio">
								      		<label ><input type="radio" name="type" value="1" >Admin</label>
								  		</div>
							   			<div class="radio">
									      <label><input type="radio" name="type" value="0" checked="true">User</label>
									   </div>
								    <?php endif; ?>
							<?php else: ?>
								  <div class="radio">
								      <label ><input type="radio" name="type" value="1" class="">Admin</label>
								  </div>
								   <div class="radio">
								      <label><input type="radio" name="type" value="0" checked="true">User</label>
								   </div>
							<?php endif; ?>	
						<?php else: ?>
							<div class="radio">
								      <label><input type="hidden" name="type" value="0" checked="true">User</label>
								   </div>
						<?php endif ?>
												
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-2 text-right">
							<label for="type" class="col-md-offset-6 control-label">Brands</label>
						</div>
						<div class="col-md-8">
						<?php if ($list_brands): ?>
							<?php if ($this->session->userdata('type') == 1): ?>

								<?php foreach ($list_brands as $value): ?>
									<?php if(!empty($account['brands'])): ?>
										<?php if((in_array($value,$account['brands']))):?>
											<label class="checkbox-inline"><input type="checkbox" value="<?=$value['id']  ?>" name="brands[]" checked="true"><?=$value['brand_name']  ?></label>
										<?php else: ?>
											<label class="checkbox-inline"><input type="checkbox" value="<?=$value['id']  ?>" name="brands[]"><?=$value['brand_name']  ?></label>
										<?php endif; ?>
									<?php else: ?>
										<label class="checkbox-inline"><input type="checkbox" value="<?=$value['id']  ?>" name="brands[]"><?=$value['brand_name']  ?></label>
									<?php endif; ?>
								<?php endforeach; ?>
							<?php else: ?>
								<?php foreach ($list_brands as $value): ?>
									<?php if(!empty($account['brands'])): ?>
										<?php if((in_array($value,$account['brands']))):?>
											<label class="checkbox-inline"><?=$value['brand_name']  ?></label>
										<?php endif; ?>
									<?php endif; ?>
								<?php endforeach; ?>
							<?php endif ?>
						<?php else: ?>
							<?php echo "Empty";  ?>
						<?php endif; ?>
						</div>
					</div>

				</fieldset>
				<?php if(empty($account['id'])): ?>
					<button type="submit" class="col-md-offset-2 col-md-8 btn btn-info">create</button>
				<?php else: ?>
					<button type="submit" class="col-md-offset-2 col-md-8 btn btn-info">update</button>
					<br>
					<br>
					<?php if ($this->session->userdata('type') == 1 &&
						 $this->session->userdata('login_id') !=  $account['login_id'] ): ?>
						<div class="col-md-offset-2 col-md-8 btn btn-default" style="background-color:#ED8A80; " data-toggle="modal" data-target="#delete-modal">Delete</div>
						<div class="col-md-10 col-md-offset-2">
							<p class="text-warning">※ 一度削除したアカウントは元に戻すことはできません。</p>
						</div>
					<?php endif ?>
					

				<?php endif; ?>

			</form>
		</div>
	</div>
	<!-- Modal -->
	<?php if ($this->session->userdata('type') == 1): ?>
		<div class="modal fade" id="delete-modal" tabindex="0" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">削除確認</h4>
					</div>
					<div class="modal-body">
						削除してよろしいですか。<br>
						一度削除したアカウントは元に戻すことはできません。
					</div>

					<form class="form-horizontal" method="post" action="<?= site_url('/account/delete') ?>">
						<input type="hidden" name="id" value="<?= $account['id'] ?>">
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
							<button type="submit" class="btn btn-danger">削除する</button>
						</div>

					</form>
				</div>
			</div>
		</div>
	<?php endif ?>


</div>