<!-- Modal -->
<div class="modal fade" id="groupActions<?php echo $group_id; ?>" tabindex="-1" role="dialog" aria-labelledby="groupActionsLabel"
 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="groupActionsLabel">
					<?php echo $group_name; ?> Action Cards</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body table-responsive">
				<table class="table table-bordered table-hover">
					<thead class="thead-light">
						<tr>
							<th scope="col">#</th>
							<th scope="col">AtionCards</th>
						</tr>
					</thead>
					<tbody>
                        <?php 
						$count = 0;
                        foreach ($action_cards as $key => $action_card) 
                        {
						if($group_unique_id == $action_card->group_unique_id){
                            $count++;?>
						<tr>
							<td>
								<?php echo $count;?>
							</td>
							<td>
								<?php echo $action_card->action_card_package;?>
							</td>
						</tr>
						<?php }} 
						if($count == 0){?>
						<div class="alert alert-danger" role="alert">
							No Action Cards Found for this group!!
						</div>
						<?php }?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
