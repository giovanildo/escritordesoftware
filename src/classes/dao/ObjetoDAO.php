<?php


class ObjetoDAO extends DAO {

	
	/**
	 * Este serve para inserir objeto em um software.  
	 * @param Objeto $objeto
	 * @param Software $software
	 * @return boolean
	 */
	public function inserir(Objeto $objeto, Software $software){
		
		$idSoftware = $software->getId();
		$nomeDoObjeto = $objeto->getNome();
		$persistenciaObjeto = $objeto->getPersistencia();
		$insert = "INSERT into objeto
		(software_id_software, nome, persistencia) 
		values($idSoftware, '$nomeDoObjeto', '$persistenciaObjeto')";
		
		if($this->getConexao()->query($insert)){
			return true;
		}else{
			//echo "<br>".$insert;
			return false;
			
		}

	}
	
	
	
	
	
}


?>