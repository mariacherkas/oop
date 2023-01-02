<?php
namespace Controller;

interface IController{
	public function setEnviroment(array $urlParams) : void;
	public function render() : string;
}