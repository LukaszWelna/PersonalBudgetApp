<?php

namespace Core;

/**
 * View
 * 
 */

 class View {

    /**
     * Render a view file
     * 
     * @param string $view The view file
     * 
     * @return void
     * 
     */
    public static function render($view, $args = []) {

        extract($args, EXTR_SKIP);

        $file = "../App/Views/$view"; // relative to Core directory

        if (is_readable($file)) {
            require $file;
        } else {
            //echo "$file not found";
            throw new \Exception("$file not found");
        }
    }

     /**
     * Render a view template using Twig
     * 
     * @param string $template The template file
     * @param array $args Associative array of data to display in the view (optional)
     * 
     * @return void
     * 
     */
    public static function renderTemplate($template, $args = []) {

        echo static::getTemplate($template, $args);
        
    }

    /**
     * Get the contents of a view template using Twig
     * 
     * @param string $template The template file
     * @param array $args Associative array of data to display in the view (optional)
     * 
     * @return void
     * 
     */
    public static function getTemplate($template, $args = []) {
        static $twig = null;

        if ($twig === null) {
            
            $loader = new \Twig\Loader\FilesystemLoader('../App/Views');
            $twig = new \Twig\Environment($loader);
            $twig -> addGlobal('currentUser', \App\Auth::getUser());
            $twig -> addGlobal('flashMessages', \App\Flash::getMessages());
            $twig -> addGlobal('currentDate', \App\Date::getCurrentDate());
            $twig -> addGlobal('actualPage', $_SESSION["page"]);
            
        }
        return $twig -> render($template, $args);
    }

 }