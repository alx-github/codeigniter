<div class="container">
	

	<div class="row">
		<ul class="breadcrumb">
			<li><a href="<?= site_url('/account') ?>">アカウント管理</a></li>
			<li class="active">一覧</li>
		</ul>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?php if ($this->session->flashdata('message')): ?>
				<div class="alert alert-dismissible alert-info">
									<button type="button" class="close" data-dismiss="alert">×</button>
									<strong>メッセージ</strong>
									<p><?= $this->session->flashdata('message') ?></p>
								</div>
			<?php $this->session->unmark_flash('message'); ?>
			<?php endif; ?>
			<?php if ($this->session->flashdata('error_message')): ?>
				<div class="alert alert-dismissible alert-danger">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>エラー</strong>
					<p><?= $this->session->flashdata('error_message') ?></p>
				</div>
				<?php $this->session->unmark_flash('error_message'); ?>
			<?php endif; ?>
			<?php if($this->session->userdata('type') ==1 ): ?>
			<div class="pull-right"> 
				<a href="<?= site_url('/account/create') ?>">
					<div class="btn btn-info">
						新しいアカウントを登録する
					</div>
				</a>
			</div>
		<?php endif; ?>
		</div>
	</div>
	<div class="row">
		<?php if($list_accounts) ?>
		<div class="table-responsive col-md-12">
			<table class="table" cell-border="0">
				<thead>
					<tr style="font-weight: bold;">
						<th>アカウンID</th>
						<th>権限</th>
						<th>管理ブランド</th>
						<th>最終ログイン日時</th>
						<th></th>
					</tr>
				</thead>
				<tbody style="background-color: white; ">
					<?php foreach ($list_accounts as $account): ?>
							<tr>
								<td><?= $account->login_id   ?></td>
								<td><?= ( $account->type == 1 ) ? '管理者' :'一般';       ?></td>
								<td>
									<?php if ($account->list_brands)
									{
										$list =$account->list_brands;
										foreach($list as $brand)
										{
											echo $brand['brand_name'];
											echo '<br>';
										}
									} ?>
								</td>
								<td><?= $account->last_login ?></td>
								<td>
									<a href="<?= site_url('/account/edit/')?>?id=<?=$account->id?>">編集</a>
								</td>
							</tr>
					 <?php endforeach; ?>	
				</tbody>
			</table>
			<?php if($this->session->userdata('type') ==1 ): ?>
			<nav aria-label="Page navigation" class="pull-right">
				<ul class="pagination">
				    <?php if($pagination['showFirstPage']): ?>
						<li>
							<a id="pageFirst" href="?page=<?=1?>" aria-label="">
	                         <span aria-hidden="true">First</span>
	                     	</a>
						</li>
					<?php endif; ?>
					<?php if($pagination['showPrePage']): ?>
						<li>
							<a id="pagePre" href="?page=<?=$pagination['prePage']  ?>" aria-label="Previous">
	                         <span aria-hidden="true"><</span>
	                     	</a>
						</li>
					<?php endif; ?>
					<?php foreach ($pagination['pages'] as $key => $value): ?>
							<?php if ($value['isActive']): ?>
								<li class="active">
		                       	 	<a href="/account?page=<?=$value['key'] ?>"><?php echo $value['key']  ?></a>
		                    	</li>
	                   		<?php else: ?>
	           					<li>
	                       	 		<a href="/account?page=<?=$value['key']; ?>"><?php echo $value['key']  ?></a>
	                    		</li>
	                    	<?php endif; ?>
					<?php endforeach; ?>
					<?php if($pagination['showNextPage']): ?>
						<li>
							<a id="pageNext" href="?page=<?=$pagination['nextPage']  ?>" aria-label="Next">
	                         <span aria-hidden="true">></span>
	                     	</a>
						</li>
					<?php endif; ?>
					 <?php if($pagination['showLastPage']): ?>
						<li>
							<a id="pageFirst" href="?page=<?=$pagination['totalPage']?>" aria-label="">
	                         <span aria-hidden="true">Last</span>
	                     	</a>
						</li>
					<?php endif; ?>
				</ul>
			</nav>
		<?php endif ?>
		</div>
	</div>

</div>