<?php
// FONCTION INTERNAUTE AUTHENTIFIER

function connect()
{
    /*Si l'indice 'user' n'est pas défénit dans la session cela veut dire que l'internaute n'est pas 
    passé par la page connexion, donc n'est pas authentifié sur le site*/
    if(!isset($_SESSION['user']))
    {
        return false;
    }
    else /* Sinon l'indice 'user' est défénit dans la session, l'internaute est passé
          par */
    {
        return true;
    }
}


// FONCTION INTERNAUTE AUTHENTIFIE ET ADMINISTRATEUR DU SITE

function adminConnect()
{
    if(connect() && $_SESSION['user']['statut'] == 'admin')
    {
        return true;
    }
    else
    {
        return false;
    }
}