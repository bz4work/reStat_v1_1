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
    public function render($moduleName, $data = array()){
        if(!isset($moduleName)){ throw new Exception("Не передано имя метода");}

        $moduleContent = $this->renderModule($moduleName,$data);

        ob_start();

        $topMenu = file_get_contents($this->_dir.$this->_ds."template".$this->_ds."menu".$this->_ds."topMenu.html");

        $main_html = $this->_dir.$this->_ds."template".$this->_ds."common".$this->_ds."main.html";
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
    protected function renderModule($moduleName,$data = array()){
        if(!isset($moduleName)){ throw new Exception("Не передано имя метода");}

        extract($data);

        //for table "Refill statistic" in "My Cabinet"
        for ($i = 1; $i < count($data)+1; $i++){
            $dataKey[] = $i;
        }

        ob_start();

        $moduleContent = $this->_dir.$this->_ds."template".$this->_ds."module".$this->_ds.$moduleName.".html";

        //не крсивый участок, попробовать через switch чтоли
        if (!file_exists($moduleContent)){
            $moduleContent = $this->_dir.$this->_ds."template".$this->_ds."forms".$this->_ds.$moduleName.".html";
        }

        include "$moduleContent";

        $moduleDataHtml = ob_get_clean();
        return $moduleDataHtml;
    }

    /**
     * @param string $form_name
     * @return string
     * @throws Exception
     */
    public function renderFormAddRecord($form_name = "addRefills"){
        ob_start();
        $moduleContent =
            $this->_dir.$this->_ds."template".$this->_ds."forms".$this->_ds.$form_name.".html";

        if(file_exists($moduleContent)){
            include "$moduleContent";
        }else{
            throw new Exception ("файл addRefills.html не существует или переименован");
        }

        $formAddRecordHTML = ob_get_clean();
        return $formAddRecordHTML;
    }

}