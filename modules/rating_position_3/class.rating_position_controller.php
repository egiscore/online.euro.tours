<?php
 class Rating_Position_Controller extends Samo_Controller { protected $is_embedable = true; public function default_action() { $this->default_app_env(); $this->view->assign('RESULT', $this->model->rating()) ->render('layout'); } public function allow_js() { return ('embed' !== $this->action); } } 