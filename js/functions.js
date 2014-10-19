
function MaxLengthTextarea(objettextarea,maxlength){
  if (objettextarea.value.length > maxlength) {
    objettextarea.value = objettextarea.value.substring(0, maxlength);
    alert('Votre texte ne doit pas dépasser '+maxlength+' caractères!');
   }
};


$(document).ready(function(){
    $('.combobox').combobox();
});

$('#triLivre').on('change', function() 
{
	$.ajax({
		url: './services/changeOrder.php',
		type: "POST",
		data: { order: this.value, name: 'livre' },
		success: function(response){
			$('.infinityscroll tbody').empty();
			resetListeLivre();
			loadLivre();
		},
		error: function(){
			alert( 'Error Change List' );
			$("#notification-topbar-danger").html(response);
		}
	});
});

$( ".filter-letter" ).click(function() {
	var filter_value = $(this).html();
	if ( filter_value == "Reset"  )
	{
		filter_value = '%';
	}
	$.ajax({
		url: './services/changeOrder.php',
		type: "POST",
		data: { filter: filter_value, name: 'livre' },
		success: function(response){
			$('.infinityscroll tbody').empty();
			resetListeLivre();
			loadLivre();
		},
		error: function(){
			alert( 'Error Change List' );
			$("#notification-topbar-danger").html(response);
		}
	});
});
