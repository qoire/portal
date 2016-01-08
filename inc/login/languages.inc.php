<?php

/*---------------------------------------------------------------------*
**  Language Dictionary                                                *
**---------------------------------------------------------------------*/

/*---------------------------------------------------------------------*
**  translator's credits here                                          *
**	Mathieu Masseboeuf	- french                                       *
**	Navico Wiesbaden	- german                                       *
**	per Inge Mathisen	- norweigan                                    *
**---------------------------------------------------------------------*/

/*---------------------------------------------------------------------*
** General Notes for Translators                                       *
** ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^                                       *
** the format for this file should be fairly straightforward. trans-   *
** lations of the english go in the quotes adjacent to the two-letter  *
** language code.                                                      *
** 1. if you do not have a two letter language code entry for your     *
** language you'll have to add them yourself. sorry.                   *
** 2. try and keep translations as short as possible. text often has   *
** to fit into tight spots. where text has to fit on a button i've     *
** made a note                                                         *
** 3. there are translator's notes for each entry. i hope they help    *
** 4. the variable $this_site is the name of the website that is       *
** running php_lib_login. for some strings it will be necessarry to    *
** use it. details are in the notes.                                   *
** 5. if you have a version that has an entry for "tx" don't worry,    *
** it's just there for testing purposes                                *
** 6. if you need non-roman characters (like accented letters) use the *
** ascii escape code for it if you know it. there's a good ascii table *
** at                                                                  *
** http://www.geocities.com/electronic_ed/tae/appd/ascii.htm           *
** the format should be ampersand-pound-number-semicolon               *
** ie:                                                                 *
** &#126;                                                              *
** for the ~ character. you get the idea.                              *
** 7. if anyone knows how to implement non-ascii text (ie cyrillic or  *
** any of the pictographic languages) i'd like to know!                *
** 8. thanks for taking the time to do this!                           *
**                                                                     *
** finished translations should be emailed to:                         *
** frymaster@ihateclowns.com                                           *
**---------------------------------------------------------------------*/


/*---------------------------------------------------------------------*
** Licensing:                                                          *
** ^^^^^^^^^                                                           *
** php_lib_login - php web login/password implementation for the lazy  *.
** Copyright (C) 2001  grant "frymaster" horwood                       *
**                                                                     *
** This library is free software; you can redistribute it and/or       *
** modify it under the terms of the GNU Lesser General Public          *
** License as published by the Free Software Foundation; either        *
** version 2.1 of the License, or (at your option) any later version.  *
**                                                                     *
** This library is distributed in the hope that it will be useful,     *
** but WITHOUT ANY WARRANTY; without even the implied warranty of      *
** MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU   *
** Lesser General Public License for more details.                     *
**                                                                     *
** You should have received a copy of the GNU Lesser General Public    *
** License along with this library; if not, write to                   *
** the Free Software Foundation, Inc.,                                 *
** 59 Temple Place, Suite 330,                                         *
** Boston, MA                                                          *
** 02111-1307  USA                                                     *
**---------------------------------------------------------------------*/


function build_vocab($language, $this_site)
{
	$index = 0;

	$vocab = array();

	//---- "login" used as a prompt
	$string[0] 	= array(	"en" => "login",
							"de" => "login",
							"no" => "innlogging",
							"fr" => "Ouvrir une session",
							"tx" => "LOGIN"
						);
	
	//---- "logout" used as a prompt			
	$string[1] 	= array(	"en" => "logout",
							"de" => "logout",
							"no" => "logg ut",
							"fr" => "Fermer votre session",
							"tx" => "LOGOUT"
						);
	
	//---- "username" used as a noun ie "enter your username"			
	$string[2] 	= array(	"en" => "username",
							"de" => "Benutzername",
							"no" => "Brukernavn",
							"fr" => "Login",
							"tx" => "USERNAME"
						);		
	
	//---- "password" used as a noun ie "enter your password"
	$string[3] = array(		"en" => "password",
							"de" => "Passwort",
							"no" => "Passord",
							"fr" => "Mot de Passe",
							"tx" => "PASSWORD"
						);
	
	//---- "FAILED LOGIN" is a phrase used in log files to indicated a 
	//---- login has failed	for a regular user
	$string[4] = array(		"en" => "FAILED LOGIN",
							"de" => "LOGIN FEHLGESCHLAGEN",
							"no" => "INNLOGGING FEILET",
							"fr" => "LOGIN REFUS&Eacute;",
							"tx" => "FAILED LOGIN"
						);
	
	//---- "FAILED LOGIN UBER" is a phrase used in log files to indicate a
	//---- failed login for the uber user	
	$string[5] = array(		"en" => "FAILED LOGIN UBER",
							"de" => "LOGIN UEBERUSER FEHLGESCHLAGEN",
							"no" => "SUPERBRUKER INNLOGGING FEILET",
							"fr" => "LOGIN ADMINISTRATEUR REFUS&Eacute;",
							"tx" => ""
						);
	
	//---- "UBER USER VIOLATION" is a phrase used in logs to indicate that
	//---- someone other than the uber user has tried to access an uber user's page
	$string[6] = array(		"en" => "UBER USER VIOLATION",
							"de" => "UEBERUSER UNBERECHTIGTER ZUGRIFF",
							"no" => "KUN FOR SUPERBRUKER",
							"fr" => "VIOLATION D'ACC&Egrave;S ADMINISTRATEUR",
							"tx" => ""
						);	
						
	//---- "change password" used as verb-noun ie "click here to change password"
	$string[7] = array(		"en" => "change password",
							"de" => "Passwort verändern",
							"no" => "Endre passord",
							"fr" => "Changer votre Mot de Passe",
							"tx" => "CHANGE PASSWORD"
						);
	
	//---- "mailback password" used as a verb-noun ie "click here to mailback password"
	$string[8] = array(		"en" => "mailback password",
							"de" => "Passwort per Rückmail anfordern",
							"no" => "Send passord",
							"fr" => "Recevoir son Mot de Passe",
							"tx" => "MAILBACK PASSWORD"
						);
	
	//---- "create account" used as a verb-noun ie "click here to create account"
	$string[9] = array(		"en" => "create account",
							"de" => "Account erstellen",
							"no" => "Lag konto",
							"fr" => "Nouveau compte",
							"tx" => "CREATE ACCOUNT"
						);
	
	//---- "this" refers to the viewer's ip address. could also read "your ip address
	//---- has been banned"				
	$string[10] = array(	"en" => "this ip address has been banned",
							"de" => "Diese IP Adresse ist gesperrt",
							"no" => "Denne IP-adressen er forbudt",
							"fr" => "Votre adresse IP a &eacute;t&eacute; exclue",
							"tx" => ""
						);
	
	//---- "continue" is text for a link to move to the next page. a verb.
	$string[11] = array(	"en" => "continue",
							"de" => "weiter",
							"no" => "Videre",
							"fr" => "Suite",
							"tx" => "CONTINUE"
						);
						
	$string[12] = array(	"en" => "there are no users logged in",
							"de" => "Es sind keine Benutzer angemeldet",
							"no" => "Ingen brukere innlogget",
							"fr" => "Aucun utilisateur n'est connect&eacute;",
							"tx" => "THERE ARE NO USERS LOGGED IN"
						);
						
	$string[13] = array(	"en" => "there is one user logged in",
							"de" => "Ein Benutzer ist angemeldet",
							"no" => "En bruker innlogget",
							"fr" => "Un utilisateur est connect&eacute;",
							"tx" => "THERE IS ONE USER LOGGED IN"
						);
	
	//---- "there are" as in "there are 3 users logged in"
	$string[14] = array(	"en" => "there are",
							"de" => "es sind",
							"no" => "Det er",
							"fr" => "Il y a",
							"tx" => "THERE ARE"
						);
						
	//---- "logged in" as in "there are 3 users logged in"
	$string[15] = array(	"en" => "logged in",
							"de" => "angemeldet",
							"no" => "innlogget",
							"fr" => "connect&eacute;s",
							"tx" => "LOGGED IN"
						);
	
	//---- "logged in as" could be translated as "you are logged in as"				
	$string[16] = array(	"en" => "logged in as ",
							"de" => "Sie sind angemeldet als",
							"no" => "Du er innlogget som",
							"fr" => "Connect&eacute; en tant que ",
							"tx" => "LOGGED IN AS"
						);
	
	//---- error message. could be translated as "your session has timed out"
	$string[17] = array(	"en" => "session has timed out",
							"de" => "Diese Sitzung ist abgelaufen",
							"no" => "Logget ut pga inaktivitet",
							"fr" => "Votre session a expir&eacute;",
							"tx" => "SESSION HAS TIMED OUT"
						);
						
	//---- error message. literally "either the username or password you have supplied
	//---- is invalid"
	$string[18] = array(	"en" => "invalid username or password",
							"de" => "Falscher Benutzername oder falsches Passwort",
							"no" => "Ugyldig brukernavn eller passord",
							"fr" => "Mauvais Login ou Mot de Passe",
							"tx" => "INVALID USERNAME OR PASSWORD"
						);
						
	//---- question: literally "have you forgotten your password?"
	$string[19] = array(	"en" => "forgot your password?",
							"de" => "Passwort vergessen?",
							"no" => "Glemt passordet?",
							"fr" => "Avez-vous oubli&eacute; votre Mot de Passe ?",
							"tx" => "FORGOT YOUR PASSWORD?"
						);
	
	//---- followed by a number ie "password reminder step 2". it may be difficult
	//---- to translate this so that the number comes last in the sentence.
	$string[20] = array(	"en" => "password reminder step ",
							"de" => "Passworterinnerung Schritt ",
							"no" => "Passordpåminnelse, steg ",
							"fr" => "Aide n&deg; ",
							"tx" => "PASSWORD REMINDER STEP"
						);
						
	$string[21] = array(	"en" => "enter your username",
							"de" => "Bitte Benutzername eingeben",
							"no" => "Tast inn ditt brukernavn",
							"fr" => "Entrez votre Login",
							"tx" => "ENTER YOUR USERNAME"
						);
	
	//---- "this feature" means the email password reset.
	$string[22] = array(	"en" => "you did not supply a question when you created your account. you canot take advantage of this feature!",
							"de" => "Sie haben keine Erinnerungsfrage bei der Erstellung des Accounts eingegeben. Sie können darum diese Funktion nicht nutzen!",
							"no" => "Du oppga ikke noe spørsmål når du lagde denne kontoen, og kan derfor ikke gjøre bruk avn denne funksjonen!",
							"fr" => "Vous n'avez pas fourni de question lors de la cr&eacute;ation de votre compte. Vous ne pouvez pas utiliser cette fonctionnalit&eacute;.",
							"tx" => "YOU DIDN'T SUPPLY A QUESTION"
						);
	
	//---- used as first part of a sentence ie "question for bob"	
	$string[23] = array(	"en" => "question for ",
							"de" => "Frage für ",
							"no" => "Spørsmål for ",
							"fr" => "Question pour ",
							"tx" => "QUESTION FOR"
						);
						
	//---- "answer" used as a noun	
	$string[24] = array(	"en" => "answer",
							"de" => "Antwort",
							"no" => "Svar",
							"fr" => "r&eacute;ponse",
							"tx" => "ANSWER"
						);
						
	//---- literally "the answer is wrong"	
	$string[25] = array(	"en" => "wrong answer!",
							"de" => "falsche Antwort!",
							"no" => "feil svar!",
							"fr" => "Mauvaise r&eacute;ponse !",
							"tx" => "WRONG ANSWER"
						);
						
	//---- literally "would you like to try again?"					
	$string[26] = array(	"en" => "try again?",
							"de" => "nochmal eingeben?",
							"no" => "prøve en gang til?",
							"fr" => "Nouvel essai ?",
							"tx" => "TRY AGAIN?"
						);
	
	//---- $this_site is the name of the website using php_lib_login
	//---- this phrase will go befor a password ie "your new password for foo.com is F4x5TT"
	$string[27] = array(	"en" => "your new password for $this_site is ",
							"de" => "Ihr neues Passwort für $this_site ist",
							"no" => "Ditt nye passord for $this_site er",
							"fr" => "Votre nouveau Mot de Passe pour $this_site est ",
							"tx" => "YOUR NEW PASSWORD FOR THIS SITE IS"
						);
						
	//---- this phrase is the subject line for password resetting email
	//---- ie "new password for foo.com"
	//---- literally "this email contains your new password for foo.com"		
	$string[28] = array(	"en" => "new password for $this_site",
							"de" => "Neues Passwort für $this_site",
							"no" => "Nytt passord for $this_site",
							"fr" => "Nouveau Mot de Pass pour $this_site",
							"tx" => "NEW PASSWORD FOR $this_site"
						);
	
	$string[29] = array(	"en" => "your new password has been emailed to you",
							"de" => "Ihr neues Passwort wurde Ihnen per aMail geschickt",
							"no" => "Nytt passord sendt",
							"fr" => "Votre nouveau Mot de Passe vous a &eacute;t&eacute; transmis par m&egrave;le",
							"tx" => "YOUR NEW PASSWORD HAS BEEN EMAILED TO YOU"
						);
	
	//---- error message indicating a password could not be changed in the database			
	$string[30] = array(	"en" => "error in updating password on the local database.",
							"de" => "FEHLER: das Passwort konnte in der Datenbank nicht geändert werden",
							"no" => "Databasefeil",
							"fr" => "Erreur lors de la mise &agrave; jour du Mot de Passe dans la base de donn&eacute;es.",
							"tx" => "ERROR IN UPDATING PASSWORD ON DB"
						);
						
	//---- literally "an error has occurred"
	$string[31] = array(	"en" => "error.",
							"de" => "fehler",
							"no" => "feil",
							"fr" => "erreur.",
							"tx" => "ERROR"
						);
	
	
	//---- prompt to type password in a second time				
	$string[32] = array(	"en" => "repeat password",
							"de" => "Passwort wiederholen",
							"no" => "Gjenta passord",
							"fr" => "Resaisissez votre Mot de Passe.",
							"tx" => "REPEAT PASSWORD"
						);
	
	//---- "email" used as noun				
	$string[33] = array(	"en" => "email",
							"de" => "eMail",
							"no" => "e-post",
							"fr" => "m&egrave;le",
							"tx" => "EMAIL"
						);
						
	$string[34] = array(	"en" => "if you lose or forget your password, a new one can be emailed to you. for security reasons you will be asked as question before being given a new password. enter that question and its answer here",
							"de" => "Wenn Sie Ihr Passwort vergessen haben können Sie sich ein neues Passwort per eMail zusenden lassen. Aus Sicherheitsgründen müssen Sie vorher eine Frage beantworten. Geben Sie diese Frage und die entsprechende Antwort nun ein. ",
							"no" => "Hvis du mister eller glemmer passordet ditt, kan du få et nytt tilsendt per e-post. For sikkerhets skyld må du svare på et spørsmål før du får et nytt passord. Oppgi dette spørsmål og svaret her:",
							"fr" => "Si vous perdez ou oubliez votre Mot de Passe, un nouveau peut vous &ecirc;tre retransmis. Pour des raisons de s&eacute;curit&eacute;, une question vous sera pos&eacute;e avant que l'on vous fournisse un nouveau Mot de Passe. Entrez la question ainsi que sa r&eacute;ponse ici",
							"tx" => "IF YOU LOSE OR FORGET YATTA YATTA"
						);
	
	//---- "question" as a noun
	$string[35] = array(	"en" => "question",
							"de" => "Frage",
							"no" => "Spørsmål",
							"fr" => "question",
							"tx" => "QUESTION"
						);
						
	//---- "success" as a verb. literally "you have succeeded"
	$string[36] = array(	"en" => "success",
							"de" => "erfolgreich",
							"no" => "Fungerte",
							"fr" => "r&eacute;ussi",
							"tx" => "SUCCESS"
						);
						
	//---- 
	$string[37] = array(	"en" => "your password has been updated",
							"de" => "Ihr Passwort wurde aktualisiert",
							"no" => "Passord oppdatert",
							"fr" => "Votre Mot de Passe a &eacute;t&eacute; mis &agrave; jour.",
							"tx" => "YOUR PASSWORD HAS BEEN UPDATED"
						);
						
	//---- literally "enter your new password here"
	$string[38] = array(	"en" => "new password",
							"de" => "Neues Passwort",
							"no" => "Nytt passord",
							"fr" => "Nouveau Mot de Passe",
							"tx" => "NEW PASSWORD"
						);
	
	//---- literally "re-enter your new password here"
	$string[39] = array(	"en" => "repeat password",
							"de" => "Passwort wiederholen",
							"no" => "Gjenta passord",
							"fr" => "Resaisissez le Mot de Passe",
							"tx" => "REPEAT PASSWORD"
						);
						
	//---- 
	$string[40] = array(	"en" => "user has been deleted",
							"de" => "Benutzer wurde gelöscht",
							"no" => "Bruker slettet",
							"fr" => "L'utilisateur a &eacute;t&eacute; edffac&eacute;.",
							"tx" => "USER HAS BEEN DELETED"
						);
						
	//---- literally "select the user to delete"
	$string[41] = array(	"en" => "delete user",
							"de" => "Benutzer löschen",
							"no" => "Slett bruker",
							"fr" => "Effacer l'utilisateur ...",
							"tx" => "DELETE USER"
						);
						
	//---- literally "for which time would you like the logs shown for"
	$string[42] = array(	"en" => "show logs for",
							"de" => "zeige Logs für",
							"no" => "Vis logg for",
							"fr" => "Afficher les logs pour ...",
							"tx" => "SHOW LOGS FOR"
						);
						
	//---- 
	$string[43] = array(	"en" => "today",
							"de" => "heute",
							"no" => "i dag",
							"fr" => "Aujourd'hui",
							"tx" => "TODAY"
						);
						
	//---- 
	$string[44] = array(	"en" => "yesterday",
							"de" => "gestern",
							"no" => "i går",
							"fr" => "Hier",
							"tx" => "YESTERDAY"
						);
	
	//---- literally "how many days previous to today?" context
	//---- "show logs for the _last_ 5 days"
	$string[45] = array(	"en" => "last",
							"de" => "letzten",
							"no" => "siste",
							"fr" => "derniers",
							"tx" => "LAST"
						);
						
	//---- an alert that the user has done something bad, but not very bad.
	$string[46] = array(	"en" => "warning",
							"de" => "Achtung",
							"no" => "Advarsel",
							"fr" => "avertissement",
							"tx" => "WARNING"
						);
						
	//---- 
	$string[47] = array(	"en" => "no days selected for viewing, defaulting to today",
							"de" => "Keine Tage für die Anzeige ausgewählt. Vorgabe: heute",
							"no" => "Antall dager valgt for visning (ingen betyr i dag)",
							"fr" => "Aucun jour s&eacute;lectionn&eacute;, les logs du jour seront affich&eacute;s",
							"tx" => "NO DAYS SELECTED"
						);
						
	//---- used as text for a link to return to the previous page.
	//---- literally "go back to where you came from"
	$string[48] = array(	"en" => "go back",
							"de" => "gehe zurück",
							"no" => "Tilbake",
							"fr" => "Retour",
							"tx" => "GO BACK"
						);
						
	//---- meaning a UNIX timestamp
	$string[49] = array(	"en" => "timestamp",
							"de" => "Zeitstempel",
							"no" => "Tidsstempel",
							"fr" => "Timestamp",
							"tx" => "TIMESTAMP"
						);
						
	//---- meaning an internet ip address
	$string[50] = array(	"en" => "ip address",
							"de" => "Internet IP Adresse",
							"no" => "Internett IP-adresse",
							"fr" => "Adresse IP",
							"tx" => "IP ADDRESS"
						);
						
	//---- "message" as a noun. could also be translated as
	//---- "more information" or "detailed information"
	$string[51] = array(	"en" => "message",
							"de" => "Detailinformation",
							"no" => "beskjed",
							"fr" => "informations",
							"tx" => "MESSAGE"
						);
						
	//---- literally "add the ip you click on to the list of banned ip's"
	$string[52] = array(	"en" => "ban this ip",
							"de" => "IP sperren",
							"no" => "Forby denne IP-adressen",
							"fr" => "Exclure cette adresse IP",
							"tx" => "BAN THIS IP"
						);
						
	//---- literally "form to use for banning ip addresses"
	$string[53] = array(	"en" => "ip banning",
							"de" => "IP ist gesperrt",
							"no" => "IP-sperring",
							"fr" => "Exclusion d'IP",
							"tx" => "IP BANNING"
						);
						
	//---- literally "these ip addresses are in the log"
	$string[54] = array(	"en" => "logged ips",
							"de" => "diese IPs werden aufgezeichnet",
							"no" => "Loggede IP-adresser",
							"fr" => "IPs logu&eacute;es",
							"tx" => "LOGGED IPS"
						);
						
	//---- literally "these ip addresses are currently banned"
	$string[55] = array(	"en" => "banned ips",
							"de" => "gesperrte IPs",
							"no" => "Sperrede IP-adresser",
							"fr" => "IPs exclues",
							"tx" => "BANNED IPS"
						);
						
	//---- literally "add to ban list" please keep this SHORT if you can
	//---- as it must fit on a button
	$string[56] = array(	"en" => "ban",
							"de" => "sperren",
							"no" => "Forby",
							"fr" => "Exclure",
							"tx" => "BAN"
						);
						
	//---- literally "remove from ban list" please keep this SHORT if you can
	//---- as it must fit on a button
	$string[57] = array(	"en" => "unban",
							"de" => "entsperren",
							"no" => "Tillat",
							"fr" => "Autoriser",
							"tx" => "UNABN"
						);
						
	//---- literally "enter the ip address you want to ban"
	$string[58] = array(	"en" => "ip to ban",
							"de" => "IP sperren",
							"no" => "Forby IP",
							"fr" => "Adresse IP &agrave; exclure",
							"tx" => "IP TO BAN"
						);
						
	//---- literally "you did not select any ip addresses"
	$string[59] = array(	"en" => "no ips selected",
							"de" => "keine IPs ausgewählt",
							"no" => "ingen IP valgt",
							"fr" => "Aucune adresse IP s&eacute;lectionn&eacute;e.",
							"tx" => "NO IPS SELECTED"
						);
						
	//---- error message displayed if a user enters a password twice for
	//---- confirmation and the two passwords are not the same.
	$string[60] = array(	"en" => "passwords do not match",
							"de" => "Passwort ist falsch",
							"no" => "Passord ikke like",
							"fr" => "Les Mots de Passe ne correspondent pas !",
							"tx" => "PASSWORDS DO NOT MATCH"
						);
						
	//---- literally "the password you entered does not have enough characters"
	$string[61] = array(	"en" => "password too short",
							"de" => "Passwort zu kurz",
							"no" => "Passord for kort",
							"fr" => "Mot de Passe trop court !",
							"tx" => "PASSWORD TOO SHORT"
						);
						
	//---- literally "the password you entered is the same as the 
	//---- username you entered"
	$string[62] = array(	"en" => "password same as username",
							"de" => "Passwort und Benutzername sind gleich",
							"no" => "Passord og brukernavn må være ulike",
							"fr" => "Vos Login et Mot de Passe sont identiques !",
							"tx" => "PASSWORD SAME AS USERNAME"
						);

	//---- error message shown if lib_login could not update the password
	//---- in the database.
	$string[63] = array(	"en" => "failed updating password",
							"de" => "Passwortaktualisierung fehlgeschlagen",
							"no" => "Feil ved passordoppdatering",
							"fr" => "Mise &agrave; jour du Mot de Passe impossible.",
							"tx" => "FAILED UPDATING PASSWORD"
						);
						
	//---- error message shown if uber user account could not be created.
	$string[64] = array(	"en" => "a serious error has ocurred in creating the uber user account",
							"de" => "Ein Fehler ist bei der Erstellung des UEBERUSER Accounts aufgetreten",
							"no" => "Alvorlig feil ved dannelse av superbrukerkonto",
							"fr" => "Une erreur grave est survenue lors de la crŽation du compte d'administration.",
							"tx" => "A SERIOUS ERROR HAS OCCURRED"
						);
						
	//---- "thrown" here may mean "generated". "thrown" is used in the sense of "throwing an exception" in Java
	$string[65] = array(	"en" => "php_lib_login was unable to create the uber user account with the data given. the following exception has been thrown:",
							"de" => "php_lib_login konnte mit den erhaltenen Angaben keinen UEBERUSER Account anlegen. Die folgende Ausgabe wird angezeigt:",
							"no" => "feil ved laging av superbrukerkonto:",
							"fr" => "php_lib_login n'a pu cr&eacute;er le compte d'administration avec les donn&eacute;es fournies. L'exception suivante a &eacute;t&eacute; lev&eacute;e :",
							"tx" => "UNABLE TO CREATE ACCOUNT WITH DATA GIVEN"
						);
						
	//---- 
	$string[66] = array(	"en" => "please consult your configuration and try again. this system is completely insecure",
							"de" => "Bitte sehen Sie sich Ihre Konfiguration an und versuchen es erneut. Ihr System ist vollkommen ungeschützt",
							"no" => "Sjekk konfigurasjonen - dette systemet er fullstendig usikkert!",
							"fr" => "Veuillez v&eacute;rifier la configuration et r&eacute;essayer. Le syst&egrave; est non s&eacute;curis&eacute;.",
							"tx" => "PLEASE CONSULT CONFIGURATION AND TRY AGAIN"
						);
						
	//---- in the context of "bob is already taken". warning message 
	//---- displayed if a new user chooses a username that is already taken
	$string[67] = array(	"en" => "is already taken",
							"de" => "ist bereits vergeben",
							"no" => "er allerede i bruk",
							"fr" => "est d&eacute;j&agrave; utilis&eacute;.",
							"tx" => "IS ALREADY TAKEN"
						);
						
	//---- literally "the uber user account cannot be deleted"
	$string[68] = array(	"en" => "cannot delete the uber user account",
							"de" => "Der UBERUSER Account kann nicht gelöscht werden",
							"no" => "Kan ikke slette superbruker",
							"fr" => "Effacement du compte d'administration impossible !",
							"tx" => "CANNOT DELETE UBERUSER ACCOUNT"
						);
						
	//---- 
	$string[69] = array(	"en" => "unable to delete this user",
							"de" => "Dieser Benutzer kann nicht gelöscht werden",
							"no" => "Klarer ikke å slette denne brukeren",
							"fr" => "Effacement de cet utilisateur impossible !",
							"tx" => "UNABLE TO DELTE THIS USER"
						);
						
	//---- error message if user selects a password that is too short. a number
	//---- will come after this sentence ie "minimum length is 7"
	$string[70] = array(	"en" => "password is too short. minimum length is ",
							"de" => "Passwort ist zu kurz. Die Mindestlänge ist",
							"no" => "Passord for kort, minste lengde er ",
							"fr" => "Mot de Passe trop court, la taille minimum est de ",
							"tx" => "PASSWORD IS TOO SHORT MINIMUM LENGTH IS"
						);
						
	
	//---- 
	$string[71] = array(	"en" => "localhost is not a valid domain for email ",
							"de" => "Localhost ist keine gültige eMail Adresse",
							"no" => "Localhost er ikke et gyldig e-postdomene",
							"fr" => "locelhost n'est pas un domaine m&egrave;le valide.",
							"tx" => "LOCALHOST NOT A VALID DOMAIN FOR EMAIL"
						);
						
	//---- 
	$string[72] = array(	"en" => "email is a mandatory field ",
							"de" => "eMail muss ausgefüllt werden",
							"no" => "må fylle ut e-postfeltet",
							"fr" => "M&egrave; est un champ obligatoire.",
							"tx" => "EMAIL IS A MANDATORY FIELD"
						);
						
	//---- literally "the email address you have entered is invalid"
	$string[73] = array(	"en" => "invalid email address ",
							"de" => "ungültige eMail Adresse",
							"no" => "ugyldig e-postadresse",
							"fr" => "L'adresse m&egrave;le a l'air invalide",
							"tx" => "INVALID EMAIL ADDRESS"
						);
						
	//---- 
	$string[74] = array(	"en" => "only administrator can ban ips ",
							"de" => "Nur der Administrator kann IPs sperren",
							"no" => "Bare administrator kan forby IP-adresser",
							"fr" => "Seul l'administrateur peut exclure des IPs",
							"tx" => "ONLY ADMINISTRATOR CAN BAN IPS"
						);
	
	//---- 
	$string[75] = array(	"en" => "there was an error banning this ip ",
							"de" => "Es gab einen Fehler beim Sperren der IP",
							"no" => "Feil i sperring av IP",
							"fr" => "Une erreur est survenue lors de l'exclusion de cette adresse IP : ",
							"tx" => "THERE WAS AN ERROR BANNING THIS IP"
						);
						
	//---- 
	$string[76] = array(	"en" => "this ip has been un-banned ",
							"de" => "Diese IP wurde entsperrt",
							"no" => "Denne IP-adressen er nå tillatt",
							"fr" => "Cette adresse IP a &eacute;t&eacute; r&eacute;autoris&eacute;e : ",
							"tx" => "THIS IP HAS BEEN UN-BANNED"
						);
						
	//---- 
	$string[77] = array(	"en" => "there was an error un-banning this ip ",
							"de" => "Es gab einen Fehler beim Entsperren dieser IP",
							"no" => "Feil ved avsperring av IP",
							"fr" => "erreur: Cette adresse IP a n'&eacute;t&eacute; pas r&eacute;autoris&eacute;e : ",
							"tx" => "THERE WAS AN ERROR UNBANNING THISIP"
						);
						
	//---- success message displayed when account creation is successful			
	$string[78] = array(	"en" => "the account has been created.",
							"de" => "Der Account wurde angelegt.",
							"no" => "Konto opprettet.",
							"fr" => "Une erreur est survenue lors de la r&eacute;autorisation de cette adresse IP : ",
							"tx" => "THE ACCOUNT HAS BEEN CREATED"
						);	
						
	//---- $this_site is a variable with the name of the site			
	$string[79] = array(	"en" => "an account has been created for you at $this_site with the following details:",
							"de" => "Es wurde ein Account für Sie bei $this_site mit den folgenden Angaben angelegt:",
							"no" => "En konto har blitt lagd til deg på $this_site med følgende detaljer:",
							"fr" => "Un compte a &eacute;t&eacute; cr&eacute;&eacute; pour vous ˆ $this_site avec les informations suivantes : ",
							"tx" => "AN ACCOUNT HAS BEEN CREATED AT $this_site"
						);					
	
	//---- literally "the question below is the question you will need to answer to get a
	//---- new password"			
	$string[80] = array(	"en" => "your password reset question is:",
							"de" => "Ihre Passwort Erinnerungsfrage ist:",
							"no" => "Ditt spørsmål for å få nytt passord",
							"fr" => "Votre question pour la r&eacute;initialisation de votre Mot de Passe est : ",
							"tx" => "YOUR PASSWORD RESET QUESTION IS"
						);	
						
	//---- literally "this is the answer to your password resetting question"			
	$string[81] = array(	"en" => "with the answer:",
							"de" => "Dies ist die Antwort auf Ihre Passwort Erinnerungsfrage:",
							"no" => "med svaret",
							"fr" => "Avec la r&eacute;ponse suivante : ",
							"tx" => "WITH THE ANSWER"
						);
						
	//---- 			
	$string[82] = array(	"en" => "if you have not requested this account or have done so in error please contact the administrator by email",
							"de" => "Wenn Sie diesen Account nicht angelegt haben oder er irrtümlich erstellt wurde benachrichtigen Sie bitte den Administrator per eMail",
							"no" => "Hvis dette ikke stemmer, kontakt administrator per e-post",
							"fr" => "Si vous n'avez pas demand&eacute; la cr&eacute;ation de ce compte ou l'avez fait par erreur, merci de contacter l'administrateur par m&egrave;le.",
							"tx" => "IF YOU HAVE NOT REQUESTED..."
						);
						
	//---- 			
	$string[83] = array(	"en" => "too many failed logins. please wait and try again.",
							"de" => "",
							"no" => "For mange feilinnlogginger, vent og prøv på nytt",
							"fr" => "trop erreurs. esayez plus tard.",
							"tx" => "YOU'RE PUNISHED!"
						);
						
	$string[84] = array(	"en" => "group management",
							"de" => "",
							"no" => "",
							"fr" => "",
							"tx" => "GROUP MANAGEMENT"
						);
						
	$string[85] = array(	"en" => "new group id",
							"de" => "",
							"no" => "",
							"fr" => "",
							"tx" => "NEW GROUP ID"
						);
						
	$string[86] = array(	"en" => "group id must be an integer",
							"de" => "",
							"no" => "",
							"fr" => "",
							"tx" => "GROUP ID MUST BE AN INTEGER"
						);
						
	// build the appropriate array for the language and return it		
	while(true)
	{
		if(isset($string[$index]))
			{array_push($vocab, $string[$index][$language]);}
		else
			{break;}
		$index++;
	}
					
				
	return $vocab;
}



?>
