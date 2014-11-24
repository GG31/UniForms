e-formulaire

	Avec le développement du web, l’envie ou le besoin de créer et d’utiliser des formulaires sur le web 
	se développe. L’exemple le plus célèbre vient certainement de Google, solution utilisable par tous gratuitement. 
	Cette solution n’est cependant pas sans défaut. Outre un évident souci de confidentialité et donc de sécurité 
	(google peut voir les questionnaires, et Google se doit de montrer des données à la demande du gouvernement), 
	il y a un souci d’apparence. Les formulaires que Google permet de construire peuvent certes être très jolis, 
	très colorés, mais ils conservent l’apparence d’une succession de questions. 
	On ne peut retrouver l’apparence d’un formulaire papier.

L’objectif de ce projet est donc de fournir un concurrent au service de google, 
concurrent qui corrige les défauts cités précédemment : 
	
	stockage des données sur un serveur personnel et construction, graphique, simple, 
	d’un formulaire pouvant ressembler à un formulaire papier et être imprimable si besoin.

Compétences Requises

	HTML5, CSS, JavaScript, PHP

Besoins Clients

Il s’agit dans ce projet de créer un concurrent aux formulaires de Google, qui devra permettre :

		La construction graphique des e-formulaires, semblables à des formulaires papiers
		L’utilisation de base par des non-informaticiens
		Le stockage des informations recueillies non seulement dans un format tableur
		L’accès protégé par login et mot de passe aux e-formulaires
		La sauvegarde et la modification des e-formulaires en construction
		L’éventuelle modification des données saisies par l’utilisateur d’un e-formulaire
		L’intégration dans un e-formulaires de données provenant de sources externes

Résultats Attendus

	Un package permettant d’installer FACILEMENT sur un serveur web les “pages” nécessaires 
	à la création et à la gestion de e-formulaires. 
	
	Une documentation permettant de comprendre le fonctionnement et la programmation du site 
	fourni

Informations Administratives

	Contact : Michel Gautero Michel.Gautero@unice.fr
	Identifiant sujet : Y1415-S027
	Type : Engineering
	Parcours Recommandés : WEB
	
Participants :

	BENATHMANE, Ayoub, benathmane.ab@gmail.com, M2 IFI (WEB)
	TRUCHI, Romain, romain.truchi.06@gmail.com, M2 IFI (WEB)
	POLO, Luis Philipe, luisfelipepolo@hotmail.com, SI 5 (WEB)
	CIRERA, Geneviève,  genevieve.cirera@gmail.com, SI 5 (WEB)
	
	
vous trouverez ci-joint un truc basique : formulaire d'authentification avec login et password stocker dans une base de données, qui nous raméne dans une page (de création de formulaire qui n'est pas implémenter encore :P), l'idée c'est de concevoir une template pour notre application (cette feuille de style que j'ai développé dans le cadre de mon stage).

pour tester, il faut importer le script SQL uniforms.sql dans base de donnée, et pour se logger : login => ScoTTisH et password => admin.

Dans mon cas j'ai utilisé wampserver avec une bd mysql phpmyadmin.
