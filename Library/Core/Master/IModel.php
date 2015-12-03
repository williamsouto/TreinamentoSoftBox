<?php

/**
 * Arquivo de interface das Models
 * *
 * @category Library
 * @package  Master
 * @author   William Souto Faria
 *
 */

interface IModel {
	
	public function getAll();
	public function get($id);
	public function add($dados);
	public function update($dados);
	public function delete($id);
	
}