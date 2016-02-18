	<!-- Container -->
	<div class="container">

		<!-- INCLUDE: partials.notification -->
		@include('partials.notification')
		<!-- ./ notifications -->

		<div class="page-header">
			<h3>
				{{ $title }}
				<div class="pull-right">
					<button class="btn btn-default btn-small btn-inverse close_popup"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</button>
				</div>
			</h3>
		</div>

		<!-- Content -->
		@yield('window')
		<!-- ./ content -->

	</div>
	<!-- ./ container -->

	<!-- Javascripts -->


 <script type="text/javascript">
$(document).ready(function(){
$('.close_popup').click(function(){
parent.oTable.fnReloadAjax();
parent.jQuery.fn.colorbox.close();
return false;
});
$('#deleteForm').submit(function(event) {
var form = $(this);
$.ajax({
type: form.attr('method'),
url: form.attr('action'),
data: form.serialize()
}).done(function() {
parent.jQuery.colorbox.close();
parent.oTable.fnReloadAjax();
}).fail(function() {
});
event.preventDefault();
});
});
$('.wysihtml5').wysihtml5();
$(prettyPrint)
</script>