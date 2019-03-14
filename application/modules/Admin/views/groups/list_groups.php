<div class="card shadow mb-4">
	<!-- <div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Kaizala Groups</h6>
	</div> -->

	<div class="card-body">
		<div class="d-sm-flex align-items-center justify-content-between">
			<!-- <p><?php echo $links; ?></p> -->
			<a href="<?php echo base_url(); ?>administration/fetch-groups" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-3"><i class="fas fa-download fa-sm text-white-50"></i> Fetch Groups</a>
		</div>

		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>#</th>
						<th>
							<?php echo anchor(base_url() . 'administration/all-groups/group_type/' . $order_method, 'Group Name'); ?>
						</th>
						<th>
							<?php echo anchor(base_url() . 'administration/all-groups/group_type/' . $order_method, 'Group Type'); ?>
						</th>
						<th>
							<?php echo anchor(base_url() . 'administration/all-groups/group_type/' . $order_method, 'Created Date'); ?>
						</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($kaiza_groups->num_rows() > 0) {
					$count = $counter + 1;
					foreach ($kaiza_groups->result() as $row) {
						$group_name = preg_replace('/\s/', '-', $row->group_name);?>
					<tr>
						<td>
							<?php echo $count++ ?>
						</td>
						<td>
							<?php echo $row->group_name; ?>
						</td>
						<td>
							<?php echo $row->group_type; ?>
						</td>
						<td>
							<?php echo date('d M Y H:i', strtotime($row->created_at)); ?>
						</td>
						<td>
							<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#groupActions<?php echo $row->group_id; ?>">
								Action Cards
							</button>
							<?php 
							$s_group['group_name'] = $row->group_name;
							$s_group['group_id'] = $row->group_id;
							$s_group['group_unique_id'] = $row->group_unique_id;
							$this->load->view('groups/group_action_cards', $s_group);
							?>
							<a href="<?php echo base_url(); ?>administration/group-users/<?php echo $group_name; ?>/<?php echo $row->group_id; ?>" class="btn btn-secondary btn-sm"><i class="fa fa-users"></i></a>
						</td>
					</tr>
					<?php }}?>
				</tbody>
			</table>
		</div>

		<p>
			<?php echo $links; ?>
		</p>
	</div>
</div>
