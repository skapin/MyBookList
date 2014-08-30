<?php
require_once ('include.php');

class Bouton  { 
    
    public function __construct()
    {
		
    }
	
	static public function hiddenButton($class)
	{
		return '<button class="'.$class.'" style="visibility: hidden;"></button>';
	}
	
	static public function addLecture( $livre )
	{
		
		 return '<button id="ajouterlecture" 
				name="ajouterlecture" 
				class="btn btn-info col-md-2 col-md-offset-1" 
				onclick="TINY.box.show(
				{	url:\'popupadd_lecture.php\',
					post:\'id='.$livre['id'].'&titre='.$livre['titre'].'&auteur='.$livre['auteur'].'\',
					width:700,height:520,opacity:20,topsplit:3,top:100
				})"><span class="glyphicon glyphicon-eye-open"></span></button>';
		
	}
	
	static public function addLivre( $livre )
	{
		return '<button id="ajouterlivre" 
							name="ajouterlivre" 
							class="btn btn-success col-md-2" 
							onclick="TINY.box.show(
							{	url:\'popupadd_livre.php\',
								post:\'id='.$livre['id'].'&titre='.$livre['titre'].'&auteur='.$livre['auteur'].'\',
								width:700,height:600,opacity:20,topsplit:3,top:100
							})">
							<span class="glyphicon glyphicon-plus"></span>
						</button>';
	}
	static public function addWish( $livre )
	{
		return '<button id="vouluLivre" 
									name="vouluLivre" 
									class="btn btn-wish col-md-2 col-md-offset-1" 
									onclick="TINY.box.show(
									{	url:\'popupadd_wish.php\',
										post:\'id='.$livre['id'].'&titre='.$livre['titre'].'&auteur='.$livre['auteur'].'\',
										width:700,height:520,opacity:20,topsplit:3,top:100
									})"><span class="glyphicon glyphicon-inbox"></span></button>' ;
									
	}
	
	static public function validerLivre( $livre )
	{
		return '<a href="process_add_biblio.php?titre='.$livre['titre']
							.'&auteur='.$livre['auteur']
							.'&date='.$livre['date']
							.'&commentaire='.$livre['commentaire'].'" >
					<button id="addAnyway" 
						name="addAnyway" 
						class="btn btn-info col-md-4 col-md-offset-2">Ajouter quand même
						<span class="glyphicon glyphicon-plus"></span>
					</button>
				</a>';
	}
	
	
}
