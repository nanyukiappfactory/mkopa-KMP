<!-- Modal -->
<div class="modal fade" id="singleResponse<?php echo $response_id; ?>" tabindex="-1" role="dialog" aria-labelledby="singleResponseLabel"
 aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="singleResponseLabel">
					<?php echo $responder_name; ?> Responses</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body table-responsive">
				<table class="table table-bordered table-hover">
					<thead class="thead-light">
						<tr>
							<th scope="col">QuestionType</th>
							<th scope="col">Questions</th>
							<th scope="col">Answers</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($action_responses as $key => $action_response) 
                        {?>
						<tr>
							<td>
								<?php echo $action_response->action_question_type;?>
							</td>
							<td>
								<?php echo $action_response->action_question;?>
							</td>
							<td>
								<?php 
                                if($action_response->action_question_type == 'Location')
                                {
                                    echo $action_response->response_location;
                                }
                                else
                                {
                                    echo $action_response->action_answer;
                                }
                                ?>
							</td>
						</tr>
						<?php } ?>

					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
