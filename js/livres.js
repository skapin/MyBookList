

 
function addLivre(id_livre)
{
	
};

function postId( idP, link, action )
{
	$.ajax({
		url: link,
		type: "POST",
		data: { id: idP, action: action },
		success: function(response){
			  //do action  
			   $("#notification-topbar-success").html(response);
			   $("#"+idP).remove();
		},
		error: function(){
			$("#notification-topbar-danger").html(response);
		}
	});
};
