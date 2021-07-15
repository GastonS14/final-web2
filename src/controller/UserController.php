<?php

require_once { UserModel.php }

class UserController {

    function _construct() {
        $model = UserModel::class;
    }

    public function isUserLoggedIn() {
        return $this->model->isUserLoggedIn();
    }

    public function isAdmin() {
        return $this->model->isAdmin();
    }
}
