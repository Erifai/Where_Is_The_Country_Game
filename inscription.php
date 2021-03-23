<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

if(isset($_POST['sss']))
   {

    $pseudo = htmlspecialchars($_POST['pseudo']);
    $mail1 = htmlspecialchars($_POST['mail1']);
    $mail2 = htmlspecialchars($_POST['mail2']);
    $mdp1 = sha1($_POST['mdp1']);
    $mdp2 = sha1($_POST['mdp2']);

      if(!empty($_POST['pseudo']) AND!empty($_POST['mail1']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp1']) AND !empty($_POST['mdp2']))
        {
            $pseudolength = strlen($pseudo);
             if($pseudolength <= 255)
                
                {
                    if($mail1 == $mail2)
                      {
                          if(filter_var($mail1, FILTER_VALIDATE_EMAIL))
                           {
                               $reqmail = $bdd->prepare("SELECT * FROM membres WHERE  mail = ?");
                               $reqmail->execute(array($mail1));
                               $mailexist = $reqmail->rowCount();
                               if($mailexist == 0)
                                 {
                         
                                       if($mdp1 == $mdp2)
                                         {   
                                          
                                             $insertmbr = $bdd->prepare("INSERT INTO membres(pseudo, mail, motdepasse) VALUES(?, ?, ?)");
                                             $insertmbr->execute(array($pseudo, $mail1, $mdp1));
                                             $erreur = "Votre compte a bien été créé !";   
                                            
                                         }

                                       else
                                          {
                                             $erreur = "Vos mots de passes ne correspondent pas !";
                                          }
                                 }  
                                else 
                                 {
                                     $erreur = "Adresse mail déjà utilisée !";
                                 }   
                            }
                            else {
                                $erreur = "Votre adresse mail n'est pas valide !";
                            }   
                      }
                    else {
                         $erreur = "Vos adresses mail ne correspondent pas !";
                    }  
                }
            else {
                $erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
            }    
        }
        else {
            $erreur = "tous les champs doivent etre remplis ! (A modifier) ";
        }
   }
   if(isset($_POST['rrr']))
    {
        $mail = htmlspecialchars($_POST['mail']);
        $mdp = sha1($_POST['mdp']);

        if(!empty($_POST['mail']) AND !empty($_POST['mdp']))
         {
            $requser = $bdd->prepare("SELECT * FROM membres WHERE mail = ? AND motdepasse = ?");
            $requser->execute(array($mail,$mdp));
            $userexist = $requser->rowCount();
              if($userexist == 1)
               {
                  $userinfo = $requser->fetch();
                  $_SESSION['id'] = $userinfo['id'];
                  $_SESSION['pseudo'] = $userinfo['pseudo'];
                  $_SESSION['mail'] = $userinfo['mail'];
                  if($userinfo['mail'] == "admin")
                  {
                      header("Location: admin.php?id=".$_SESSION['id']);   
                  }
                else
                 {
                      header("Location: profil.php?id=".$_SESSION['id']);
                 }       
               }
               else 
                {
                    $erreur = "Mauvais mail ou mot de passe !";
                }
         }
         else 
          {
              $erreur = "tous les champs doivent etre complétés !";
          }
    }

    ?>   