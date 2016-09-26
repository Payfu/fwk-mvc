<?php
/**
 * Pour la méthode getDb();
 */
use Core\Config;
use Core\DataBase\MysqlDataBase;


/*
 * Ici se trouvent des variables static dont une permettant de sauvegarder la connexion à la base de donnée
 * Pour appeler une méthode statique seule cette syntaxe suffit : App::nomMethode();
 */

/**
 * Description of App : Singleton
 * 
 * Cette classe étant utilisée partout, on peut y faire passer d'autres variables comme les nom de page.
 * @author EmmCall
 */

class App
{
    
    public $title;
    public $description;
    public $keywords;
    public $author;
    public $lang;
    public $copyright;

    public $contact_destinataire;

    private $db_instance;
    
    private static $_instance;
    
    /*
     * Récupération (via config/config.php) des différentes varables comme le nom du site, la description etc...
     */
    public function __construct()
    {
        $config = Config::getInstance(ROOT . '/config/config.php');
        
        $this->title        = $config->get('title');
        $this->description  = $config->get('description');
        $this->keywords     = $config->get('keywords');
        $this->author       = $config->get('author');
        $this->lang         = $config->get('lang');
        $this->copyright    = $config->get('copyright');

        // Les email
        $this->contact_destinataire     = $config->get('contact_destinataire');
        $this->contact_objet            = $config->get('contact_objet');    
        
    }

    
	/**
	 * Si une instance est déjà en cours on ne la relance pas
	 *
	 */
	public static function getInstance()
	{
		if(is_null(self::$_instance)){
	    		self::$_instance = new App();
		}
		
		return self::$_instance;
	}
    
    /**
     * Cette méthode va charger 3 autoloader + un session_start
     * Chaques autoloader chargera les classes dans son dossier respectif
     */
    public static function Load()
    {
	    session_start();

	    //require ROOT . '/app/Autoloader.php';
	    require_once  ROOT . '/app/Autoloader.php';
	    App\Autoloader::register();
        
	    //require ROOT . '/core/Autoloader.php';
	    require_once ROOT . '/core/Autoloader.php';
	    Core\Autoloader::register();
	    
	    // Vendor de composer
	    require_once ROOT.'/vendor/autoload.php';
    }


	/**
	* Cette méthode utlise une Factory permettant d'appeler une succession de tables sans difficulter
	*/
	public function getTable($name_table)
	{
		$class_name = '\\App\\Table\\' . ucfirst($name_table) . 'Table'; // ex : App\Table\CategoriesTable

		// Instanciation de la classe
		return new $class_name($this->getDb());
	}
    
	/**
	* Second Factory pour la base de données
	*/
	public function getDb()
	{
		// On récupère la config
		$config = Config::getInstance(ROOT . '/config/config.php');

		// Si la base n'est pas instanciée
		if(is_null($this->db_instance))
		{
			$this->db_instance = new MysqlDataBase($config->get('db_name'), $config->get('db_pass'), $config->get('db_user'), $config->get('db_host'));
		}
		
		return $this->db_instance;
	}
      
}
