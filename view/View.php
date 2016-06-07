<?php

/**
 * Created by PhpStorm.
 * User: Slimline
 * Date: 19.05.2016
 * Time: 10:09
 */

class View{

    private $_dir;
    private $_ds; //DIRECTORY_SEPARATOR

    public function __construct(){
        $this->setRootPath();
    }

    private function setRootPath(){
        $this->_dir = dirname(__DIR__);
        $this->_ds = DIRECTORY_SEPARATOR;
    }

    /**
     * @param $moduleName
     * @param array $data
     * @throws Exception
     */
    public function render($moduleName, $data = array()){
        if(!isset($moduleName)){ throw new Exception("Не передано имя метода");}

        $ds = DIRECTORY_SEPARATOR;
        $moduleContent = $this->renderModule($moduleName,$data);
        ob_start();
        $topMenu = file_get_contents("template".$ds."menu".$ds."topMenu.html");
        $main_html = "template".$ds."common".$ds."index.html";
        include "$main_html";
        $final_html = ob_get_clean();
        echo $final_html;


    }

    /**
     * @param $moduleName
     * @param array $data
     * @param array $url
     * @return string
     * @throws Exception
     */
    protected function renderModule($moduleName,$data = array()){
        if(!isset($moduleName)){ throw new Exception("Не передано имя метода");}

        if(file_exists("template/module/".$moduleName.".html")){
            $fileName = $moduleName.".html";
            $fileSystem = "template/module/";
        }elseif(file_exists("template/forms/".$moduleName.".html")){
            $fileName = $moduleName.".html";
            $fileSystem = "template/forms/";
        }else{
            $fileName = "empty";
            $fileSystem = "empty";
        }

        $loader = new Twig_Loader_Filesystem($fileSystem);
        $twig = new Twig_Environment($loader);
        $template = $twig->loadTemplate($fileName);

        return  $template->render(array('data' => $data));
    }

}