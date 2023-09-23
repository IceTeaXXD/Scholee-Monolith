<?php

class ListBeasiswa extends Controller {
  public function index() {
    $data['judul'] = 'List Beasiswa';
    $this->view('templates/header', $data);
    $this->view('listbeasiswa/index');
    $this->view('templates/footer');
  }
}