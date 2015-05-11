<!-- Modal -->
<div id="myModal" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">削除確認</h3>
	</div>
	<div class="modal-body">
		<p class="text-error">この処理をすると、データは削除され戻りません。<br />本当に削除しますか？</p>
	</div>
	<div class="modal-footer">
		<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">やめる</button>
		<button class="btn btn-danger" id="do_delete">削除する</button>
	</div>
</div>
<script type="text/javascript">
$(function(){
	$('body').on('click','[data-toggle="modal"]',function(e){
			id = $(this).data('id');
			alert(id);
	});
	$('#do_delete').click(function(){
		location.href="?m=delete&id="+id;
	});
});
</script>