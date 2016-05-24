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

        ob_start();

        $moduleContent = $this->renderModule($moduleName,$data);

        $topMenu = file_get_contents($this->_dir.$this->_ds."template".$this->_ds."menu".$this->_ds."topMenu.html");

        $main_html = $this->_dir.$this->_ds."template".$this->_ds."common".$this->_ds."main.html";
        include "$main_html";

        $final_html = ob_get_clean();

        echo $final_html;
    }

    /**
     * @param $moduleName
     * @param array $data
     * @param array $decorate
     * @return string
     * @throws Exception
     */

    protected function renderModule($moduleName,$data = array()){
        if(!isset($moduleName)){ throw new Exception("Не передано имя метода");}


        /** если в пришедших данных есть ячейка с доп. формами или кнопками
         * включим их в шаблон  */
        if(array_key_exists("decorate",$data)){
            $data_decorate = $data['decorate'];
            extract($data_decorate);
        }

        //данные из БД лежат в ячейке $data['dataDB']
        if(array_key_exists("dataDB",$data)){
            //переопрделим значение $data для цикла for ниже
            $data = $data['dataDB'];
            extract($data);
        }else{
            extract($data);
        }


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
     * @return string
     */
    public function renderFormAddRecord(){
        ob_start();
        $moduleContent =
            $this->_dir.$this->_ds."template".$this->_ds."forms".$this->_ds."addRefills.html";

        include "$moduleContent";

        $formAddRecordHTML = ob_get_clean();
        return $formAddRecordHTML;
    }

}