<?php
class Reviews extends Controller{
    public function index(){
        $model = new Review();
        $data['row'] = $model->getUserReview();
        
    }

    public function add(){

    }

    public function review(){

    }
}
?>