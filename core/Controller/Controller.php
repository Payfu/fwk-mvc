<?php
namespace Core\Controller;

/*
    10-06-2016 : Ajout de filter_var URL dans scripts();
*/


/**
 * Description of Controller
 *
 * @author EmmCall
 */
class Controller
{
    /*
     * C'est variable son créer dans App\AppController
     */
    protected $viewPath;
    protected $template;

    protected $jsPath;
    protected $cssPath;



    protected function render($view, $variables = []/*, $variables2 = []*/)
    {
        $content = '';
        //var_dump($this->viewPath. str_replace('.', '/', $view));
        ob_start();
        
        // Les variables récupéré ici sont utilisé en aval dans le template
        extract($variables);
        
        // On charge le chemin de la page à afficher
        require ($this->viewPath . str_replace('.', '/', $view) . '.php');
        
        // La variable $content est envoyée dans le template
        $content = ob_get_clean();
        
        // On charge le template
        require($this->viewPath . 'templates/' . $this->template . '.php');
        
    }

	// Cette fonction est peut-être inutile (à voir sur le long terme)
    protected function renderJson($view, $variables = [])
    {
        $content = '';
        
        ob_start();
        
        // Les variables récupéré ici sont utilisé en aval dans le template
        extract($variables);
        
        // On charge le chemin de la page à afficher
        require ($this->viewPath . str_replace('.', '/', $view) . '.php');

        // La variable $content est envoyée dans le template
        $content = ob_get_clean();

        // On retourne la page dans un tableau pour Json, le echo est indispensable.
        echo json_encode(["view"=>$content]);
        
    }

    /*
     * Appel des scripts JS et CSS en fonction des pages
     * Avec la syntaxe suivante : $tab = $this->scripts(['upload.css', 'upload.js', 'https://domaine.fr/script.min.js']);
     */
    protected function scripts($tab=[])
    {
        $scripts_js = $scripts_css = '';
        if(!empty($tab))
        {   
            foreach ($tab as $value) {
                $sanitize_name = str_replace(' ', '', $value); // On supprime les éventuelles espaces
                $ext = strtolower(substr(strrchr($sanitize_name, '.'), 1)); // On récupère l'extension sans le point

                if(filter_var($sanitize_name, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED))
                { $url = filter_var($sanitize_name, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED); $type= 'isUrl'; }
                else{$url = $sanitize_name; $type = 'isNotUrl';}

                if    ($ext === 'css' and $type === 'isUrl') { $scripts_css .= "\t".'<link rel="stylesheet" href="'.$url.'">'."\n"; }
                elseif($ext === 'css' and $type === 'isNotUrl') { $scripts_css .= "\t".'<link rel="stylesheet" href="'.$this->cssPath.$url.'">'."\n"; }
                elseif( $ext === 'js' and $type === 'isUrl') { $scripts_js .= "\t".'<script src="'.$url.'"></script>'."\n"; }
                elseif( $ext === 'js' and $type === 'isNotUrl') { $scripts_js .= "\t".'<script src="'.$this->jsPath.$url.'"></script>'."\n"; }
            }
        }
        return compact('scripts_js', 'scripts_css');
    }


    
    
    /**
     * Renvoie les bon header en fonction de la situation
     */
    protected function forbidden()
    {
        header('HTTP/1.0 403 Forbidden');
        die('Acces refusé');
    }
    
    protected function notFound()
    {
        header('HTTP/1.0 404 Not Found');
        die('Page Introuvable');
    }
}
