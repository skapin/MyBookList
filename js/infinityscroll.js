
offset = 15;
scroll_service_url = 'ajaxGetLivres.php';
scroll_service_action = 'liste_livres';

function setInfiniteScrollService( action )
{
	scroll_service_action = action;
};

function resetListeLivre()
{
	offset = 0;
	$(window).data('ajaxready', true);
	
};

function loadLivre( )
{
    var offset_incr = 15;
	if ($(window).data('ajaxready') == false) 
		return;
	if(($(window).scrollTop() + $(window).height())+400 > $(document).height()
		|| agentID && ($(window).scrollTop() + $(window).height()) + 150 > $(document).height())
	{
		$(window).data('ajaxready', false);
		// puis on fait la requête pour demander les nouveaux éléments
		$.get( scroll_service_url+'?offset=' + offset + '&action='+scroll_service_action, function(data)
		{
			//s'il y a des données
			if (data != '')
			{
				$('.infinityscroll tbody').append(data);
				 
				// on les affiche avec un fadeIn
				$('.infinityscroll tbody tr').fadeIn("slow");
				$('.hidden').removeClass("hidden");
				/* enfin on incrémente notre offset de 20
				* afin que la fois d'après il corresponde toujours
				*/
				$(window).data('ajaxready', true);
				offset += offset_incr;
			}
		});
	}
};

function infiniteScroll( )
{
    $(window).data('ajaxready', true);
    // ici on ajoute un petit loader gif qui fera patienter pendant le chargement
    var deviceAgent = navigator.userAgent.toLowerCase();
    var agentID = deviceAgent.match(/(iphone|ipod|ipad)/);
    $(window).scroll(function()
    {
		loadLivre( );
    });
};
