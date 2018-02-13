<div class="modal fade" id="messageModal{{ $section->id }}" tabindex="-1" 
	role="dialog" aria-labelledby="messageModalLabel{{ $section->id }}" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="messageModalLabel{{ $section->id }}">
					{{ $section->contents->where('type', 'name')->first()->content }}
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				{{ $section->contents->where('type', 'message')->first()->content}}
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>