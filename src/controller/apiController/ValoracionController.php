<?php

require_once { ValoracionModel.php }

class ValoracionController {

    function _construct() {
        $model = ValoracionModel::class;
    }

    public function getValoracionesByVideo($id_video) {
        $valoraciones = $this->model->getValoracionesByVideo($id_video);
        $this->view->showValoracionesByVideo($valoraciones)
    }
}
