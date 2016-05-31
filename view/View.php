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

    /**
     *
     */
    private function setRootPath(){
        $this->_dir = dirname(__DIR__);
        $this->_ds = DIRECTORY_SEPARATOR;
    }

    /**
     * @param $moduleName
     * @param array $data
     * @throws Exception
     */
    public function render($moduleName, $data = array(), $url=array()){
        if(!isset($moduleName)){ throw new Exception("Не передано имя метода");}

        if(!isset($url)){
            $url = array();
        }
        $moduleContent = $this->renderModule($moduleName,$data,$url);

        ob_start();

        try{
            $mod_rewrite = Config::getConfig("mod_rewrite");
            $top_menu = "topMenu_rewrite.html";
        }catch(Exception $e){
            $top_menu = "topMenu.html";
        }

        $topMenu = file_get_contents($this->_dir.$this->_ds."template".$this->_ds."menu".$this->_ds.$top_menu);

        //$main_html = $this->_dir.$this->_ds."template".$this->_ds."common".$this->_ds."main.html";
        $main_html = $this->_dir.$this->_ds."template".$this->_ds."common".$this->_ds."index.html";
        include "$main_html";

        $final_html = ob_get_clean();

        echo $final_html;
    }

    /**
     * @param $moduleName
     * @param array $data
     * @return string
     * @throws Exception
     */
    protected function renderModule($moduleName,$data = array(),$url = array()){
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

        return  $template->render(array('data' => $data, 'url' => $url));
    }

}