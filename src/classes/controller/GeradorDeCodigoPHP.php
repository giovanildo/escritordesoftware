<?php

/**
 * 
 * @author jefferson
 *
 */

class GeradorDeCodigoPHP extends GeradorDeCodigo{
	
	
	/**
	 * retorna um array de objetos do tipo GeradorDeCodigoPHP
	 * Cada estrutura representa um arquivo de uma classe do software em questao. 
	 * @param Software $software
	 * @return multitype:GeradorDeCodigoPHP |NULL
	 */
	public static function geraClasses(Software $software){
		//primeiro iremos percorrer cada um dos objetos deste software.
		//primeira vez pra criar os codigos
		 
		$listaDeObjetos = $software->getListaDeObjetos();
		if($listaDeObjetos){
			foreach ($listaDeObjetos as $objeto){
			
				//Gera o codigo de cada objeto
				//Gera o nome do arquivo
				$nomedosite = $software->getNome();

				//instancia no geradorDePHP
				//Armazena em Um vetor.
				$gerador = GeradorDeCodigoPHP::geraCodigoDeObjeto($objeto, $nomedosite);
				$geradores[] = $gerador;
			
			
			
			}
		}
		if(isset($geradores))
		{
			return $geradores;
		}
		else
		{
			return null;
		}
		
		
	
	
	}
	/**
	 * retorna um array de objetos do tipo GeradorDeCodigoPHP
	 * Cada estrutura representa um arquivo de uma classe do software em questao. 
	 * @param Software $software
	 * @return multitype:GeradorDeCodigoPHP |NULL
	 */
	public static function geraClassesController(Software $software){
		$listaDeObjetos = $software->getListaDeObjetos();
		if($listaDeObjetos){
			foreach ($listaDeObjetos as $objeto){

				$nomedosite = $software->getNome();
				$gerador = GeradorDeCodigoPHP::geraCodigoDeController($objeto, $nomedosite);
				$geradores[] = $gerador;
			
			
			
			}
		}
		if(isset($geradores))
		{
			return $geradores;
		}
		else
		{
			return null;
		}
		
		
	
	
	}

	public static function geraFormularios(Software $software){
		//primeiro iremos percorrer cada um dos objetos deste software.
		//primeira vez pra criar os codigos
			
		$listaDeObjetos = $software->getListaDeObjetos();
		if($listaDeObjetos){
			foreach ($listaDeObjetos as $objeto){
					
				//Gera o codigo de cada objeto
				//Gera o nome do arquivo
				$nomedosite = $software->getNome();
	
				//instancia no geradorDePHP
				//Armazena em Um vetor.
				$gerador = GeradorDeCodigoPHP::geraForm($objeto, $software);
					
					
				$geradores[] = $gerador;
					
					
					
			}
		}
		if(isset($geradores))
		{
			return $geradores;
		}
		else
		{
			return null;
		}
	
	
	
	
	}
	
	/**
	 * Retorna uma estrutura que representa o codigo e o caminho de cada 
	 * Objeto responsÃ¡vel por insersao de objetos no banco de dados. 
	 * @param Software $software
	 * @return GeradorDeCodigoPHP|NULL
	 */
	
	
	public static function geraDaos(Software $software){

		$listaDeObjetos = $software->getListaDeObjetos();
		if($listaDeObjetos){
			foreach ($listaDeObjetos as $objeto){
					
				//Gera o codigo de cada objeto
				//Gera o nome do arquivo
				$nomedosite = $software->getNome();
		
				//instancia no geradorDePHP
				//Armazena em Um vetor.
				$gerador = GeradorDeCodigoPHP::geraCodigoDeObjetoDAO($objeto, $nomedosite);
					
					
				$geradores[] = $gerador;
					
					
					
			}
		}
		if(isset($geradores))
		{
			return $geradores;
		}
		else
		{
			return null;
		}
		
		
	}
	public static function geraClasseDao(Software $software){
		$nomeDoSite = $software->getNome();
		
		$codigo  = '<?php
		
/**
 * Cria uma conexão. 
 * @author Jefferson Uchôa Ponte
 *
 */
class DAO {
	protected $conexao;
	
	public function DAO(PDO $conexao = null){
		if($conexao != null){
			$this->conexao = $conexao;
		}else{
			$this->fazerConexao();
				
		}
	}
	public function fazerConexao(){
		$this->conexao = new PDO(\'mysql:host=localhost;dbname=NomeBanco\', \'usuarioBanco\', \'SenhaBanco\', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		
	}
	
	public function getConexao(){
		return $this->conexao;
		
	}
				
}
?>';
		
		$gerador = new GeradorDeCodigoPHP();
		$gerador->codigo = $codigo;
		$gerador->caminho = 'sistemasphp/'.$nomeDoSite.'/classes/dao/DAO.php';
		return $gerador;
		
	}
	/**
	 * 
	 * Gera cÃ³digos das classes do pacote DAO
	 * @param Objeto $objeto
	 * @param String $nomeDoSite
	 * @return GeradorDeCodigoPHP
	 */
	public static function geraCodigoDeObjetoDAO(Objeto $objeto, $nomeDoSite){
		$geradorDeCodigo = new GeradorDeCodigoPHP();
		$nomeDoObjeto = strtolower($objeto->getNome());
		$nomeDoObjetoMA = strtoupper(substr($objeto->getNome(), 0, 1)).substr($objeto->getNome(), 1,100);
		$nomeDoObjetoDAO = strtoupper(substr($objeto->getNome(), 0, 1)).substr($objeto->getNome(), 1,100).'DAO';

		$codigo  = '<?php
		
/**
 * Classe feita para manipulação do objeto '.$nomeDoObjetoMA.'
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson Uchôa Ponte
 *
 *
 */
class '.$nomeDoObjetoDAO.' extends DAO {
	
	
	public function inserir('.$nomeDoObjetoMA.' $'.$nomeDoObjeto.'){
		
		$sql = "INSERT INTO usuario(';
		$i = 0;
		foreach ($objeto->getAtributos() as $atributo){
			$i++;
			$codigo .= $atributo->getNome();
			if($i != count($objeto->getAtributos())){
				$codigo .= ', ';
			}
		}
		$codigo .= ')
				VALUES(';
		$i = 0;
		foreach ($objeto->getAtributos() as $atributo){
			$i++;
			$codigo .= ':'.$atributo->getNome();
			if($i != count($objeto->getAtributos())){
				$codigo .= ', ';
			}
		}
		
		$codigo .= ')";';
		foreach ($objeto->getAtributos() as $atributo){
			$nomeDoAtributoMA = strtoupper(substr($atributo->getNome(), 0, 1)).substr($atributo->getNome(), 1,100);
			$codigo .= '
			$'.$atributo->getNome().' = $'.$nomeDoObjeto.'->get'.$nomeDoAtributoMA.'();';
			
		}
		
		$codigo .= '
		try {
			$db = $this->getConexao();
			$stmt = $db->prepare($sql);';
		foreach ($objeto->getAtributos() as $atributo){
			$codigo .= '
			$stmt->bindParam("'.$atributo->getNome().'", $'.$atributo->getNome().', PDO::PARAM_STR);';
		}
		
		$codigo .= '
			$result = $stmt->execute();
			return $result;
			 
		} catch(PDOException $e) {
			echo \'{"error":{"text":\'. $e->getMessage() .\'}}\';
		}
	}
	public function excluir('.$nomeDoObjetoMA.' $'.$nomeDoObjeto.'){
		$'.$objeto->getAtributos()[0]->getNome().' = $'.$nomeDoObjeto.'->getId();
		$sql = "DELETE FROM '.$nomeDoObjeto.' WHERE '.$objeto->getAtributos()[0]->getNome().' = :'.$objeto->getAtributos()[0]->getNome().'";
		
		try {
			$db = $this->getConexao();
			$stmt = $db->prepare($sql);
			$stmt->bindParam("id", $id, PDO::PARAM_INT);
			return $stmt->execute();
	
		} catch(PDOException $e) {
			echo \'{"error":{"text":\'. $e->getMessage() .\'}}\';
		}
	}
	public function alterar(){
		//Aqui vc escreve o codigo pra alterar '.$nomeDoObjeto.'
	
	}
	
	public function retornaLista() {
		$lista = array ();
		$sql = "SELECT * FROM '.$nomeDoObjeto.' LIMIT 1000";
		$result = $this->getConexao ()->query ( $sql );
	
		foreach ( $result as $linha ) {
				
			$'.$nomeDoObjeto.' = new '.$nomeDoObjetoMA."();\n";
		
		foreach ($objeto->getAtributos() as $atributo){
			$nomeDoAtributoMA = strtoupper(substr($atributo->getNome(), 0, 1)).substr($atributo->getNome(), 1,100);
			
			$codigo .= '
			$'.$nomeDoObjeto.'->set'.$nomeDoAtributoMA.'( $linha [\''.$atributo->getNome().'\'] );'
;
			
		}
		$codigo .= '
			$lista [] = $'.$nomeDoObjeto.';
		}
		return $lista;
	}			
				
}';
		
		$gerador = new GeradorDeCodigoPHP();
		$gerador->codigo = $codigo;
		$gerador->caminho = 'sistemasphp/'.$nomeDoSite.'/classes/dao/'.$nomeDoObjetoDAO.'.php'; 
		return $gerador;
		
	}
	/**
	 * @param Objeto $objeto
	 * @return GeradorDeCodigoPHP
	 */
	public static function geraCodigoDeController(Objeto $objeto, $nomeDoSite){
		$geradorDeCodigo = new GeradorDeCodigoPHP();
		$nomeDoObjeto = strtolower($objeto->getNome());
		$nomeDoObjetoMa = strtoupper(substr($objeto->getNome(), 0, 1)).substr($objeto->getNome(), 1,100);
		
		$codigo  = '<?php	

/**
 * Classe feita para manipulação do objeto '.$nomeDoObjetoMa.'
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson UchÃ´a Ponte <j.pontee@gmail.com>
 */
class '.$nomeDoObjetoMa.'Controller {
	private $post;
	private $view;
	public function '.$nomeDoObjetoMa.'Controller(){		
		$this->view = new '.$nomeDoObjetoMa.'View();
		foreach($_POST as $chave => $valor){
			$this->post[$chave] = $valor;
		}
	}
	public function cadastrar() {
		$this->view->mostraFormInserir();
		if (! ( ';
		$i = 0;
		foreach ($objeto->getAtributos() as $atributo){
			$i++;
			$codigo .= 'isset ( $this->post [\''.$atributo->getNome().'\'] )';
			if($i != count($objeto->getAtributos())){
				$codigo .= ' && ';
			}
			
		}
		
		$codigo .= ')) {
			if(isset($this->post[\'cadastrar\'])){
				echo "Incompleto";
			}
			return;
		}
	
		$usuario = new Usuario ();';
		foreach ($objeto->getAtributos() as $atributo){
			$nomeDoAtributoMA = strtoupper(substr($atributo->getNome(), 0, 1)).substr($atributo->getNome(), 1,100);
			$codigo .= '		
		$usuario->set'.$nomeDoAtributoMA.' ( $this->post [\''.$atributo->getNome().'\'] );';			
		}
		
		$codigo .= '	
		$usuarioDao = new UsuarioDAO ();
		if ($usuarioDao->inserir ( $usuario )) {
			echo "Sucesso";
		} else {
			echo "Fracasso";
		}
	}
				
	public function listarJSON() {
		$'.$objeto->getNome().'Dao = new '.$nomeDoObjetoMa.'DAO ();
		$lista = $usuarioDao->retornaLista ();
		$listaUsuarios [\''.$nomeDoObjeto.'\'] = array ();
		foreach ( $lista as $linha ) {
			$usuarios [\''.$nomeDoObjeto.'\'] [] = array (';
		$i = 0;
		foreach($objeto->getAtributos() as $atributo){
			$i++;
			$nomeDoAtributoMA = strtoupper(substr($atributo->getNome(), 0, 1)).substr($atributo->getNome(), 1,100);
			$codigo .= '
					\''.$atributo->getNome().'\' => $linha->get'.$nomeDoAtributoMA.' ()';
			if($i != count($objeto->getAtributos())){
				$codigo .= ', ';
			}
		}
		
		$codigo .= '
						
						
			);
		}
		echo json_encode ( $usuarios );
	}			
				
	
		';

		$codigo .='
}
?>';
		
		$geradorDeCodigo->codigo = $codigo;
		$geradorDeCodigo->caminho = 'sistemasphp/'.$nomeDoSite.'/classes/controller/'.strtoupper(substr($objeto->getNome(), 0, 1)).substr($objeto->getNome(),1,100).'Controller.php';
		
		return $geradorDeCodigo;
	}
	
	public static function geraCodigoDeObjeto(Objeto $objeto, $nomeDoSite){
		$geradorDeCodigo = new GeradorDeCodigoPHP();
		$nomeDoObjeto = $objeto->getNome();
		$nomeDoObjetoMa = strtoupper(substr($objeto->getNome(), 0, 1)).substr($objeto->getNome(), 1,100);
	
		$codigo  = '<?php
	
/**
 * Classe feita para manipulaÃ§Ã£o do objeto '.$nomeDoObjetoMa.'
 * feita automaticamente com programa gerador de software inventado por
 * @author Jefferson UchÃ´a Ponte <j.pontee@gmail.com>
 */
class '.$nomeDoObjetoMa.' {';
		if($objeto->getAtributos())
		{
			foreach ($objeto->getAtributos() as $atributo)
			{
				$nome = $atributo->getNome();
				$nome2 = strtoupper(substr($atributo->getNome(), 0, 1)).substr($atributo->getNome(), 1, 100);
	
				$codigo .= '
	private $'.$nome.';';
	
			}
				
				
			foreach ($objeto->getAtributos() as $atributo)
			{
					
				$nome = $atributo->getNome();
				$nome2 = strtoupper(substr($atributo->getNome(), 0, 1)).substr($atributo->getNome(), 1, 100);
				$tipo = $atributo->getTipo();
	
	
				if($atributo->getTipo() == 'int' || $atributo->getTipo() == 'float' || $atributo->getTipo() == 'string')
				{
	
					$codigo .= '
	public function set'.$nome2.'($'.$nome.') {';
					$codigo .= '
		$this->'.$nome2.' = $'.$nome.';
	}';
				}
				else
				{
					$codigo .= '
	public function set'.$nome2.'('.$atributo->getTipo().' $'.$nome.') {';
						
					$codigo .= '
		$this->'.$nome2.' = $'.$nome.';
	}';
				}//fecha o caso contrario. o atributo sendo objeto
	
				$codigo .= '
	public function get'.$nome2.'() {
		return $this->'.$nome2.';
	}';
	
			}//fecha foreach dos atributos
				
				
				
		}
	
		$codigo .='
}
?>';
	
		$geradorDeCodigo->codigo = $codigo;
		$geradorDeCodigo->caminho = 'sistemasphp/'.$nomeDoSite.'/classes/model/'.strtoupper(substr($objeto->getNome(), 0, 1)).substr($objeto->getNome(),1,100).'.php';
	
		return $geradorDeCodigo;
	}
	public function geraIndex(Software $software){
		$this->caminho = "sistemasphp/".$software->getNome().'/index.php';
		$this->codigo = '<?php

function __autoload($classe) {
				
	if (file_exists ( \'classes/dao/\' . $classe . \'.php\' )){
		include_once \'classes/dao/\' . $classe . \'.php\';
	}
	else if (file_exists ( \'classes/model/\' . $classe . \'.php\' )){
		include_once \'classes/model/\' . $classe . \'.php\';
	}
	else if (file_exists ( \'classes/controller/\' . $classe . \'.php\' )){
		include_once \'classes/controller/\' . $classe . \'.php\';
	}
	else if (file_exists ( \'classes/util/\' . $classe . \'.php\' )){
		include_once \'classes/util/\' . $classe . \'.php\';
	}
	else if (file_exists ( \'classes/view/\' . $classe . \'.php\' )){
		include_once \'classes/view/\' . $classe . \'.php\';
	}
}

?>
<!DOCTYPE html>
<html>
  	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>'.$software->getNome().'</title>
	</head>
  	<body>
		<div id="topo">
			<h1>'.$software->getNome().'</h1>
		</div>
		<div id="menu">
			<ul>
				<li><a href="">Item  do Menu</a></li>
				<li><a href="">Outro Item do Menu</a></li>
			</ul>
		</div>
		<div id="corpo">
			<div id="esquerda">
			<?php
				$controller = new '.$software->getListaDeObjetos()[0]->getNome().'Controller();
				$controller->cadastrar();
			?>
			</div>
					
			<div id="direita">
			<h1>Listagem em JSON</h1>
			<?php

				 $controller->listarJSON();
						
			?>
						
			</div>		
			
		</div>
		<div id="footer">
			<p>Base do site</p>
		</div>
					
		
	</body>
</html>';
		
	}
	public function geraStyle(Software $software){
		
		$this->caminho = "sistemasphp/".$software->getNome().'/css/style.css';
		$this->codigo = "/*Esse Ã© um arquivo css*/
body{
	background-color:#5DD0C0;	
	font:Arial, Helvetica, sans-serif;
	color:#FFF;
	
}
#topo{
	width: 1000px;
	height:223px;
	margin: 0px auto;
	padding: 0px 0px 0px 0px;		
}		
#menu{
	background-color:#00685A;
	width: 1000px;
	height:100px;
	margin: 0px auto;
	padding: 0px 0px 0px 0px;		
}
#menu ul
{
	list-style: none;
}		
#menu li
{
	display: inline-block;
	margin-top:5px;
	width:200px;
	height:30px;
}
#menu a{
	font-size:24px;	
}			
#corpo{

	background-color:#00A08A;
	width: 1000px;
	height:1000px;
	margin: 0px auto;
	padding: 0px 0px 0px 0px;
}
#footer{
	background-color:#00A08A;
	width: 1000px;
	height:200px;
	margin: 0px auto;
	padding: 0px 0px 0px 0px;
}				
#esquerda{
	padding-left:10px;
	padding-right:10px;
	margin-left:20px;
	margin-top:40px;
	width:440px;
	float:left;
	background-color:#00685A;
}
#esquerda .classe {
	background-color:#00A08A;
}
#esquerda .classe li{
	list-style: none;
}
#esquerda .classe h1{
	background-color:#1E786C;
}
#direita{
	padding-left:10px;
	padding-right:10px;
	margin-left:20px;
	margin-top:40px;
	width:440px;
	float:left;
	background-color:#00685A;
	
}
a{
	color:#FFF;	
}
fieldset{
	border:none;	
}
fieldset legend{
	font-size:30px;
}
label{
	font-size:30px;
	display: block;
}
input{
	margin-top:5px;
	margin-left:30px;
	border:none;
	width:300px;	
	height:30px;
	display: block;
	color: #00685A;
	font-size: 13px;
}
select{
	margin-top:5px;
	margin-left:30px;
	width:300px;	
	height:30px;
	border:none;	
	color: #00685A;
	font-size: 13px;
}
#topo img{
	margin-left:200px;
	margin-top:30px;
}			
				
";
		
	}
	
	public function geraCriadorDeBanco(Software $software){		
		$sgdb = $software->getBancoDeDados()->getSistemaGerenciadorDeBancoDeDados();
		
	}
	
	
	public static function geraForm(Objeto $objeto, Software $software){
		
		$nomeDoObjeto = $objeto->getNome();
		$nomeDOObjeto = strtolower($objeto->getNome());
		$nomeDoObjetoMa = strtoupper(substr($objeto->getNome(), 0, 1)).substr($objeto->getNome(), 1,100);
		
		$nomeDoSite = $software->getNome();
		$codigo = '<?php
				
/**
 * Classe de visao para '.$nomeDoObjetoMa.'
 * @author Jefferson UchÃ´a Ponte <j.pontee@gmail.com>
 *
 */				
class '.$nomeDoObjetoMa.'View {
	public function mostraFormInserir() {	
		echo \'<form action="" method="post">
					<fieldset>
						<legend>
							Adicionar '.$nomeDoObjetoMa.'
						</legend>';
		
		$atributos = $objeto->getAtributos();
		
		foreach ($atributos as $atributo)
		{
			$variavel = $atributo->getNome();
			$tipo = $atributo->getTipo();

			$indice = $atributo->getIndice();
			if($tipo == 'string' || $tipo == 'int' && $indice != 'primary_key'){
				$codigo .= '
						<label for="'.$variavel.'">'.$variavel.':</label>'.'
						<input type="text" name="'.$variavel.'" id="'.$variavel.'" />';
			}

		}
		
		
		$codigo .='
						<input type="submit" name="cadastrar" value="Cadastrar">
					</fieldset>
				</form>\';
	}	
}';
		$gerador = new GeradorDeCodigoPHP();
		$gerador->caminho = 'sistemasphp/'.$nomeDoSite.'/classes/view/'.$nomeDoObjetoMa.'View.php';
		$gerador->codigo = $codigo;
		return $gerador;
		
	
	}
	

	
}


?>