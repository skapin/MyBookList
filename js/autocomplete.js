$('#rechercheLivreTitre').autocomplete({
    serviceUrl: 'services/AC_titre.php',
    onSearchComplete: function (query, suggestions) {
        $.post( "services/changeOrder.php",{ filter: "%"+query, order: "titre" }, function( data ) {
				$('.infinityscroll tbody').empty();
				resetListeLivre();
				loadLivre();
				});
    },
    onInvalidateSelection: function()
    {
	},
    onSelect: function (suggestion) {
		$.post( "services/changeOrder.php",{ filter: "%"+suggestion.value, order: "titre" }, function( data ) {
				$('.infinityscroll tbody').empty();
				resetListeLivre();
				loadLivre();
				});
		
        
    }
});


$('#rechercheLivreAuteur').autocomplete({
    serviceUrl: 'services/AC_auteur.php',
    onSearchComplete: function (query, suggestions) {
        $.post( "services/changeOrder.php",{ filter: "%"+query, order: "auteur" }, function( data ) {
				$('.infinityscroll tbody').empty();
				resetListeLivre();
				loadLivre();
				});
    },
    onInvalidateSelection: function()
    {
	},
    onSelect: function (suggestion) {
		$.post( "services/changeOrder.php",{ filter: "%"+suggestion.value, order: "auteur" }, function( data ) {
				$('.infinityscroll tbody').empty();
				resetListeLivre();
				loadLivre();
				});
		
        
    }
});


$('#ADDrechercheLivreTitre').autocomplete({
    serviceUrl: 'services/AC_titre.php',
    onSelect: function (suggestion) {
        
    }
});


$('#ADDrechercheLivreAuteur').autocomplete({
    serviceUrl: 'services/AC_auteur.php',
    onSelect: function (suggestion) {
        
    }
});
