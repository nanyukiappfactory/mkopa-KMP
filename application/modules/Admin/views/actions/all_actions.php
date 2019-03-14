<div class="card shadow mb-4">
	<!-- <div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Kaizala Groups</h6>
	</div> -->

	<div class="card-body">
        <div class="d-lg-flex align-items-center justify-content-between">
            <div class="alert alert-dark" role="alert">
                Action Cards
            </div>
		</div>
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>#</th>
						<th>
							<?php echo anchor(base_url() . 'administration/all-actions/action_card_package/' . $order_method, 'Action Package'); ?>
						</th>
						<th>
							<?php echo anchor(base_url() . 'administration/all-actions/group_name/' . $order_method, 'Group Name'); ?>
						</th>
						<th>
							<?php echo anchor(base_url() . 'administration/all-actions/created_at/' . $order_method, 'Created Date'); ?>
						</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php if (count($action_cards) > 0) {
    $count = $counter + 1;
    foreach ($action_cards as $row) {?>
					<tr>
						<td>
							<?php echo $count++ ?>
						</td>
						<td>
							<?php echo $row->action_card_package; ?>
							<button type="button" class="btn btn-warning btn-sm float-right" data-toggle="modal" data-target="#editPackageName<?php echo $row->action_card_id; ?>">
								Edit
							</button>
							<?php 
							$v_edit_data['action_package'] = $row->action_card_package;
							$v_edit_data['action_id'] = $row->action_card_id;
							$this->load->view('actions/edit_package_name', $v_edit_data) ?>
						</td>
						<td>
							<?php echo $row->group_name; ?>
						</td>
						<td>
							<?php echo date('d M Y H:i', strtotime($row->created_at)); ?>
						</td>
						<td>
							<a href="<?php echo base_url(); ?>administration/all-responses/<?php echo $row->action_card_id; ?>" class="btn btn-success btn-sm">Responses</a>
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
