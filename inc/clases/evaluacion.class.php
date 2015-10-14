<?php
// Clase Evaluacion

require_once('contenido.class.php');

class Evaluacion extends Contenido {
	private $preguntasYRespuestas = array();
	
	function __construct($id) {
		parent::__construct($id);
		
		// Consulta a tabla de evaluaciones
		$resultados = $this->bd->query("SELECT * FROM evaluaciones WHERE id = " . $this->id);
		
		if($resultados == false) {
			
			echo 'Hubo un error con la base de datos:' . $this->bd->error();
			
		} else {
			
			foreach($resultados as $resultado) {
				$pregunta		=	$resultado['pregunta'];
				$respuesta		=	$resultado['respuesta'];
				
				array_push($this->preguntasYRespuestas, array($pregunta,$respuesta));
			} // foreach($resultados as $resultado) {
			
		} // if($resultados == false) { ... else ...
	} // function __construct($id) {
	
	
	public function getPreguntasYRespuestas() { return $this->preguntasYRespuestas; }
	
	
	public function agregarPreguntaYRespuesta($pregunta, $respuesta) {
		
		$this->bd->query("INSERT INTO evaluaciones (id_contenido,pregunta,respuesta) VALUES (" . $this->id . "," . $this->bd->escapar($pregunta) . "," . $this->bd->escapar($respuesta) . ")");
		
		array_push($this->preguntasYRespuestas, array($pregunta,$respuesta));
	} // public function agregarPreguntaYRespuesta($pregunta, $respuesta) {
	
	
	public function eliminarPreguntaYRespuesta($pregunta = NULL, $respuesta = NULL) {
		$preguntasYRespuestas = NULL;
		
		if(isset($pregunta)) {
			
			$resultado = $this->bd->query("DELETE FROM evaluaciones WHERE id_contenido = " . $this->id . " AND pregunta = " . $this->bd->escapar($pregunta));
			
			if($resultado == false) {
				echo 'Hubo un error con la base de datos:' . $this->bd->error();
			} else {
				// Consulta a tabla de evaluaciones
				$preguntasYRespuestas = $this->bd->query("SELECT * FROM evaluaciones WHERE id_contenido = " . $this->id);
				
				echo 'Pregunta y respuesta eliminadas';
			} // if($resultado == false) { ...  else ...
			
		} elseif(isset($respuesta)) {
			
			$resultado = $this->bd->query("DELETE FROM evaluaciones WHERE id_contenido = " . $this->id . " AND respuesta = " . $this->bd->escapar($respuesta));
			
			if($resultado == false) {
				echo 'Hubo un error con la base de datos:' . $this->bd->error();
			} else {
				// Consulta a tabla de evaluaciones
				$preguntasYRespuestas = $this->bd->query("SELECT * FROM evaluaciones WHERE id_contenido = " . $this->id);
				
				echo 'Pregunta y respuesta eliminadas';
			} // if($resultado == false) { ...  else ...
			
		} else {
			echo 'No hay pregunta/respuesta qué eliminar';
		} // if(isset($pregunta)) { ... elseif ... else ...
		
		if(isset($preguntasYRespuestas)) {
			
			if($preguntasYRespuestas == false) {
				echo 'Hubo un error con la base de datos:' . $this->bd->error();
			} else {
				
				$this->preguntasYRespuestas = array();
				
				foreach($preguntasYRespuestas as $preguntaYRespuesta) {
					$pregunta		=	$preguntaYRespuesta['pregunta'];
					$respuesta		=	$preguntaYRespuesta['respuesta'];
					
					array_push($this->preguntasYRespuestas, array($pregunta,$respuesta));
				} // foreach($preguntasYRespuestas as $preguntaYRespuesta) {
			} // if($preguntasYRespuestas == false) {
		} // if(isset($preguntasYRespuestas)) {
		
	} // public function eliminarPreguntaYRespuesta($pregunta = NULL, $respuesta = NULL) {
	
} // class TipoDeContenido {
?>