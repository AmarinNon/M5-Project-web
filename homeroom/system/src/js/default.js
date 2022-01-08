$(document).ready(function(){
	// tooltip
	$('[data-toggle="tooltip"]').tooltip();

	// data table
	$('.table-data').dataTable({
		"bStateSave": true,
        "pagingType": "full_numbers"
	});

	$('.table-data').on('draw.dt', function () {
		$('[data-toggle-popover="true"]').popover({
			'placement': 'top',
			'trigger': 'hover'
		});
	} );

	// table row clickable
	$("tr[data-link]").click(function() {
		window.location = this.dataset.link;
	});

	// select
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
		$('.live').selectpicker('mobile');
	}
	else {
		$('.live').selectpicker({
			liveSearch: true
		});
	}

	$('.select2').select2();
	
	// focus first input
	$('.modal').on('shown.bs.modal', function() {
		document.activeElement.blur();
		$(this).find(".modal-body :input:visible").first().focus();
	});

	// confirm dialog
	$('form').not('[name*="noconfirm"]').submit(function() {
		var c = confirm("Click OK to continue?");
		if(c)
		{
			$(this).find('input[type="submit"]').not('.nohide').addClass('hidden');
			$(this).find('button[type="submit"]').not('.nohide').addClass('hidden');
		}
		return c;
	});

	$('form[name="noconfirm"]').submit(function() {
		$(this).find('input[type="submit"]').not('.nohide').addClass('hidden');
		$(this).find('button[type="submit"]').not('.nohide').addClass('hidden');
	});

	// save scroll position
	if (typeof $.cookie("scroll") !== undefined ) {
		$(document).scrollTop( $.cookie("scroll") );
	}
	$(window).on("scroll", function() {
		$.cookie("scroll", $(document).scrollTop() );
	});

	// css animated
	$('#logo').addClass('animated flash');
	$('#logo').on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
		$('#logo').removeClass('animated flash');

		setTimeout(function () {
			$('#logo').addClass('animated flash');
		}, 2000);
	});

	function imgPreview(elm) {

		var input = elm.get(0);
		
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$(elm).parents('.img-previewable').find('img').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}

	$('.img-previewable').on('change', 'input[type="file"]', function () {
		imgPreview($(this));
	});
});