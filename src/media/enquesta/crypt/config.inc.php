<?php

// -----------------------------------------------
// Cryptographp v1.3
// (c) 2006 Sylvain BRISON 
//
// www.cryptographp.com 
// cryptographp@alphpa.com 
//
// Licence CeCILL (Voir Licence_CeCILL_V2-fr.txt)
// -----------------------------------------------


// -------------------------------------
// Configuration du fond du cryptogramme
// -------------------------------------

$cryptwidth  = 120;  // Largeur du cryptogramme (en pixels)
$cryptheight = 40;   // Hauteur du cryptogramme (en pixels)

$bgR  = 255;         // Couleur du fond au format RGB: Red (0->255)
$bgG  = 255;         // Couleur du fond au format RGB: Green (0->255)
$bgB  = 255;         // Couleur du fond au format RGB: Blue (0->255)

$bgclear = true;     // Fond transparent (true/false)
                     // Uniquement valable pour le format PNG

$bgimg = '';          // Le fond du cryptogramme peut-�tre une image  
                             // PNG, GIF ou JPG. Indiquer le fichier image
                             // Exemple: $fondimage = 'photo.gif';
				                     // L'image sera redimensionn�e si n�cessaire
                             // pour tenir dans le cryptogramme

$bgframe = false;    // Ajoute un cadre de l'image (true/false)


// ----------------------------
// Configuration des caract�res
// ----------------------------

// Couleur de base des caract�res

$charR = 0;     // Couleur des caract�res au format RGB: Red (0->255)
$charG = 0;     // Couleur des caract�res au format RGB: Green (0->255)
$charB = 0;     // Couleur des caract�res au format RGB: Blue (0->255)

$charcolorrnd = false;      // Choix al�atoire de la couleur.
$charcolorrndlevel = 1;    // Niveau de clart� des caract�res si choix al�atoire (0->4)
                           // 0: Aucune s�lection
                           // 1: Couleurs tr�s sombres (surtout pour les fonds clairs)
                           // 2: Couleurs sombres
                           // 3: Couleurs claires
                           // 4: Couleurs tr�s claires (surtout pour fonds sombres)

$charclear = 60;   // Intensit� de la transparence des caract�res (0->127)
                  // 0=opaques; 127=invisibles
	                // interessant si vous utilisez une image $bgimg
	                // Uniquement si PHP >=3.2.1

// Polices de caract�res

//$tfont[] = 'Alanden_';       // Les polices seront al�atoirement utilis�es.
//$tfont[] = 'bsurp___';       // Vous devez copier les fichiers correspondants
//$tfont[] = 'ELECHA__.TTF';       // sur le serveur.
$tfont[] = 'luggerbu.ttf';     // Ajoutez autant de lignes que vous voulez   
//$tfont[] = 'RASCAL__';     
//$tfont[] = 'SCRAWL.ttf';  
//$tfont[] = 'WAVY.ttf';



// Caracteres autoris�s
// Attention, certaines polices ne distinguent pas (ou difficilement) les majuscules 
// et les minuscules. Certains caract�res sont faciles � confondre, il est donc
// conseill� de bien choisir les caract�res utilis�s.

$charel = 'ABCDEFGHKLMNPRTWXYZ234569';       // Caract�res autoris�s

$crypteasy = false;       // Cr�ation de cryptogrammes "faciles � lire" (true/false)
                         // compos�s alternativement de consonnes et de voyelles.

$charelc = 'BCDFGHKLMNPRTVWXZ';   // Consonnes utilis�es si $crypteasy = true
$charelv = 'AEIOUY';              // Voyelles utilis�es si $crypteasy = true

$difuplow = false;          // Diff�rencie les Maj/Min lors de la saisie du code (true, false)

$charnbmin = 4;         // Nb minimum de caracteres dans le cryptogramme
$charnbmax = 4;         // Nb maximum de caracteres dans le cryptogramme

$charspace = 22;        // Espace entre les caracteres (en pixels)
$charsizemin = 18;      // Taille minimum des caract�res
$charsizemax = 18;      // Taille maximum des caract�res

$charanglemax  = 0;     // Angle maximum de rotation des caracteres (0-360)
$charup   = false;      // D�placement vertical al�atoire des caract�res (true/false)

// Effets suppl�mentaires

$cryptgaussianblur = true; // Transforme l'image finale en brouillant: m�thode Gauss (true/false)
                            // uniquement si PHP >= 5.0.0
$cryptgrayscal = true;     // Transforme l'image finale en d�grad� de gris (true/false)
                            // uniquement si PHP >= 5.0.0

// ----------------------
// Configuration du bruit
// ----------------------

$noisepxmin = 0;       // Bruit: Nb minimum de pixels al�atoires
$noisepxmax = 0;       // Bruit: Nb maximum de pixels al�atoires

$noiselinemin = 0;     // Bruit: Nb minimum de lignes al�atoires
$noiselinemax = 0;     // Bruit: Nb maximum de lignes al�atoires

$noisecolorchar  = false;  // Bruit: La couleur est celle du caract�re (true) sinon celle du fond (false)


// --------------------------------
// Configuration syst�me & s�curit�
// --------------------------------

$cryptformat = "png";   // Format du fichier image g�n�r� "GIF", "PNG" ou "JPG"
				                // Si vous souhaitez un fond transparent, utilisez "PNG" (et non "GIF")
				                // Attention certaines versions de la bibliotheque GD ne gerent pas GIF !!!

$cryptsecure = "md5";    // M�thode de crytpage utilis�e: "md5", "sha1" ou "" (aucune)
                      // "sha1" seulement si PHP>=4.2.0
                         // Si aucune m�thode n'est indiqu�e, le code du cyptogramme est stock� 
                         // en clair dans la session.
                       
$cryptusetimer = 0;        // Temps (en seconde) avant d'avoir le droit de reg�n�rer un cryptogramme
$cryptusertimererror = 3;  // Action � r�aliser si le temps minimum n'est pas respect�:
                           // 1: Ne rien faire, ne pas renvoyer d'image.
                           // 2: L'image renvoy�e est "images/erreur2.png" (vous pouvez la modifier)
                           // 3: Le script se met en pause le temps correspondant (attention au timeout
                           //    par d�faut qui coupe les scripts PHP au bout de 30 secondes)
                           //    voir la variable "max_execution_time" de votre configuration PHP

$cryptusemax = 1000;  // Nb maximum de fois que l'utilisateur peut g�n�rer le cryptogramme
                      // Si d�passement, l'image renvoy�e est "images/erreur1.png"
                      // PS: Par d�faut, la dur�e d'une session PHP est de 180 mn, sauf si 
                      // l'hebergeur ou le d�veloppeur du site en on d�cid� autrement... 
                      // Cette limite est effective pour toute la dur�e de la session. 
?>