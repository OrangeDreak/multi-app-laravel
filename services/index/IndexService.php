<?php
namespace Index;
use active\ActiveModel;
class IndexService {
	
	public function __construct(){
		$this->model = new ActiveModel();
	}

	public function index(){
		return $this->model->index();
	}
}