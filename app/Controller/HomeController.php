<?php
namespace App\Controller;

use App;

use Core\ { 
            Controller\Controller, // Appel pour la méthode render(); 
            Tools\Tools,
            Login\Login
            };

//use Core\Auth\ApiAuthUser;


/**
 * Description of HomeController
 *
 * @author EmmCall
 */
class HomeController extends AppController
{

    private static $_instanceTools;

    public function __construct()
    {
        parent::__construct();
        //$this->loadModel('Nom_table');
    }


    /**
     * La methode render envoie la partie HTML, 
     * cette methode se trouve dans le controller situé dans le core
     * $this->Post et $this->category sont initialisé dans le constructeur avec $this->loadModel
     */
    public function index()
    {
     
     // Afficher les erreurs à l'écran
     ini_set('display_errors', 1);
     
     
        if(is_null(self::$_instanceTools)){ self::$_instanceTools = new Login(); }
        $token = self::$_instanceTools->getToken();



        print($token);

        // Meta donnée
        $metaTitle = App::getInstance()->title;
        $metaDescription = App::getInstance()->description;

        // Form Contact
        //$form = new BootstrapForm($_POST);

        // Appel des script JS et CSS
        $scripts = $this->scripts([ 
		'main.css', 
		'upjs.js', 
		'jquery.easing.min.js', 
		'paralax.js', 
		'simple-lightbox.js', 
		'contact.js']);
	    
        $data = array_merge($scripts, compact( 'metaTitle', 'metaDescription', 'token'));

        // On envoi un tableau créé avec compact()
        $this->render('home.index', $data);
    }

   

/*
* Contact
*/
    public function contact()
    {
        if(is_null(self::$_instanceTools)){ self::$_instanceTools = new Tools();}
        $tools = self::$_instanceTools;

        if (!empty($_POST)) 
        {
            $errors = false;

            if($_POST['ch_comment'])
            {
                echo json_encode(["statut"=>"ok"]);
            }
            else
            {

		$ch_statut 	= $_POST['ch_statut'] ? filter_input(INPUT_POST, 'ch_statut', FILTER_SANITIZE_STRING) : $errors .= 'Veuillez cocher votre statut'."<br />";
			 
                $ch_email       = filter_input(INPUT_POST, 'ch_email', FILTER_VALIDATE_EMAIL) ? filter_input(INPUT_POST, 'ch_email', FILTER_SANITIZE_EMAIL) : $errors .= 'L\'email semble incorrect'."<br />";
		$ch_objet      = $_POST['ch_objet'] ? filter_input(INPUT_POST, 'ch_objet', FILTER_SANITIZE_STRING) : $errors .= 'Veuillez indiquer l\'objet de votre message'."<br />";

                $ch_message      = $_POST['ch_message'] ? filter_input(INPUT_POST, 'ch_message', FILTER_SANITIZE_STRING) : $errors .= 'Vous n\'avez pas laissé de message'."<br />";
		    
		$message_final = "Objet : ". $ch_objet . "\nStatut : " . $ch_statut . "\r\n". $ch_message ;

                // S'il n'y a pas d'erreur alors on envoie
                if(!$errors){
			
                    $to = App::getInstance()->contact_destinataire;
                    $subject = App::getInstance()->contact_objet;
                    
                    $send = $tools->sendEmail($to, $ch_email, $subject, $message_final);
                    
                    echo json_encode(["statut"=>"ok", "return"=>$send]);

                }
                else
                {
                    echo json_encode(["statut"=>"ko", "error"=>$errors]);
                }
                
            }
        }
    }
    
    
    
    
}
