<?php

require_once { VideoModel.php }
require_once { UserModel.php }

class VideoController {

    function _construct() {
        // Should initialize the models and views
        $userModel = UserModel::class;
        $model = VideoModel::class;
        $view = VideoView::class;
    }

    public function addValoracion($id_usuario, $valoracion, $id_video) {
        if(isset($id_usuario) && isset($valoracion) && isset($id_video)) {
            if($this->userModel->isUserLoggedIn() && $this->verify($id_usuario, $id_video)) {
                $this->model->addValoracion($id_usuario, $valoracion, $id_video);
            }
        } else {
            $this->view->showError();
        }
    }

    /**
     * return true if the video user is different to user id and the user hasn't vote the video
     */
    private function verify($id_usuario, $id_video) {
        return !($this->isOwnVideo($id_usuario, $id_video) &&
            $this->isVotedForUser($id_usuario, $id_video));
    }

    /**
     * return true if the video user id is equal to user id
     */
    private function isOwnVideo($id_usuario, $id_video) {
        return $this->model->isOwnVideo($id_usuario, $id_video);
    }

    /**
     * return true if the user already voted the video
     */
    private function isVotedForUser($id_usuario, $id_video) {
        return $this->model->isVotedForUser($id_usuario, $id_video);
    }

    /**
     * The button for ocultarVideosByValue shouldn't be visible in front for no admin users
     */
    public function ocultarVideosByValue($value) {
        if($this->userModel->isAdmin()) {
            $badVideos = $this->model->findLessThanValueByAvg($value);
            $this->view->ocultarVideos($badVideos);
        }
    }

    public function resume($id_video) {
        if($this->model->existOrExistWithoutValue($id_video)) {
            $video = $this->model->findById($id_video);
            $avgValoraciones = $this->model->findAvgByVideo($id_video);
            $valoraciones = $this->model->findAllByVideoId($id_video);
            $this->view->showResume($video, $avgValoraciones, $valoraciones);
        } else {
            $this->view->showErrorResume($id_video);
        }
    }

    public function editar($id_video, $titulo) {
        if(isset($id_video) && isset($titulo)) {
            $this->model->editar($id_video, $titulo);
        } else {
            $this->view->showError("$id_video and $titulo are required");
        }
    }
}
