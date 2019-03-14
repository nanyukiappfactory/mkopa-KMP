<div class="card shadow mb-4">
	<!-- <div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Kaizala Groups</h6>
	</div> -->

	<div class="card-body">
		<div class="d-lg-flex align-items-center justify-content-between">
			<div class="alert alert-dark" role="alert">
				Action Card Responses : <?php echo $count_response; ?> submitted!!
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>#</th>
						<th>
							<?php echo anchor(base_url() . 'administration/all-responses/' . $action_id . '/action_package/' . $order_method, 'ActionPackage'); ?>
						</th>
						<th>
							<?php echo anchor(base_url() . 'administration/all-responses/' . $action_id . '/group_name/' . $order_method, 'GroupName'); ?>
						</th>
						<th>
							<?php echo anchor(base_url() . 'administration/all-responses/' . $action_id . '/responder_name/' . $order_method, 'Responder'); ?>
						</th>
						<th>
							<?php echo anchor(base_url() . 'administration/all-responses/' . $action_id . '/responder_phone/' . $order_method, 'ResponderPhone'); ?>
						</th>
						<th>
							<?php echo anchor(base_url() . 'administration/all-responses/' . $action_id . '/created_at/' . $order_method, 'Created Date'); ?>
						</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php if (count($action_responses) > 0) {
    $count = $counter + 1;
    $duplicates = array();
    $single_data['action_responses'] = $action_responses;
    foreach ($action_responses as $row) {
        if ((count($duplicates) == 0) || !(in_array($row->response_id, $duplicates))) {
            $single_data['response_id'] = $row->response_id;
            $single_data['responder_name'] = $row->responder_name;?>
					<tr>
						<td>
							<?php echo $count++ ?>
						</td>
						<td>
							<?php echo $row->action_package; ?>
						</td>
						<td>
							<?php echo $row->group_name; ?>
						</td>
						<td>
							<?php echo $row->responder_name; ?>
						</td>
						<td>
							<?php echo $row->responder_phone; ?>
						</td>
						<td>
							<?php echo date('d M Y H:i', strtotime($row->created_at)); ?>
						</td>
						<td>
							<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#singleResponse<?php echo $row->response_id; ?>">
								Q&As
							</button>
							<?php $this->load->view('actions/single_response', $single_data);?>
						</td>
					</tr>
					<?php }

        array_push($duplicates, $row->response_id);}}?>
				</tbody>
			</table>
		</div>

		<p>
			<?php echo $links; ?>
		</p>
	</div>
</div>
