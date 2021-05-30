<?php
class Logger{
    public $username;
    public $isLogged;
    public $isSigningUp;
    private $password;
    protected $servername="localhost";
    protected $bdusername="DBUSER2020";
    protected $bdpassword="DBPSWD2020";
    protected $nombrebd = "eventos";
    
    public function __constructor(){
        $this->username='';
        $this->password='';
        $this->isLogged = false;
        $this->isSigningUp = false;  //modo
    }
    public function login(){
        $db = new mysqli($this->servername, $this->bdusername, $this->bdpassword, $this->nombrebd);
        if ($db->connect_error) {
            exit("<p>ERROR de conexión:" . $db->connect_error . "</p>");
        }
        
        $consultaPre = $db->prepare("SELECT * FROM `usuarios` where `email`=? AND `password`=?");
        $consultaPre->bind_param('ss', $_POST["ID"], $_POST["Password"]);
        $consultaPre->execute();
        $result = $consultaPre->get_result();
        if ($result->fetch_assoc()!=NULL) {    // Coincidencia de credenciales
            $result->data_seek(0);              //Seposiciona al inicio del resultado de búsqueda
            $fila = $result->fetch_assoc();
            $this->username=$_POST["ID"];
            $this->password=$_POST["Password"];
            $this->isLogged=true;
            $consultaPre->close();
            $db->close(); 
            header("Location: https://localhost/SEW/PHP/agenda.php#");
        } 
        $consultaPre->close();
        $db->close(); 
    }
    public function signup(){
        $db = new mysqli($this->servername, $this->bdusername, $this->bdpassword, $this->nombrebd);
        if ($db->connect_error) {
            exit("<p>ERROR de conexión:" . $db->connect_error . "</p>");
        }
        
        $consultaPre = $db->prepare("INSERT INTO `usuarios` (`email`, `password`, `nombre`, `apellidos`) VALUES (?,?,?,?)");
        $consultaPre->bind_param('ssss', $_POST["ID"], $_POST["Password"], $_POST["nombre"], $_POST["apellidos"]);
        $consultaPre->execute();
        $result = $consultaPre->get_result();
        if (!$result) {    // Registro correcto
            $this->username=$_POST["ID"];
            $this->password=$_POST["Password"];
            $this->isLogged=true;
            $consultaPre->close();
            $db->close(); 
            header("Location: https://localhost/SEW/PHP/agenda.php#");
        } else{ // No se pudo crear la cuenta (email repetido)
            $consultaPre->close();
            $db->close(); 
            header("Location: https://localhost/SEW/PHP/error.html#");
        }
    }
    public function createEvent(){
        $db = new mysqli($this->servername, $this->bdusername, $this->bdpassword, $this->nombrebd);
        if ($db->connect_error) {
            exit("<p>ERROR de conexión:" . $db->connect_error . "</p>");
        }
        
        $consultaPre = $db->prepare("INSERT INTO `evento` (`titulo`, `descripcion`, `fecha`, `usuario`) VALUES (?,?,?,?)");
        $consultaPre->bind_param('ssss', $_POST["titulo"], $_POST["descripcion"], $_POST["fecha"], $this->username);
        $consultaPre->execute();
        $result = $consultaPre->get_result();
        if (!$result) {    // Creacion correcta
            //Recargamos la página para actualizar con el nuevo evento
            $consultaPre->close();
            $db->close(); 
            header("Location: https://localhost/SEW/PHP/agenda.php#");
        } else{ // No se pudo crear el evento
            $consultaPre->close();
            $db->close(); 
            header("Location: https://localhost/SEW/PHP/error.html#");
        }
    }
    public function createAnnotation(){
        $db = new mysqli($this->servername, $this->bdusername, $this->bdpassword, $this->nombrebd);
        if ($db->connect_error) {
            exit("<p>ERROR de conexión:" . $db->connect_error . "</p>");
        }
        
        $consultaPre = $db->prepare("INSERT INTO `anotacion` (`titulo`, `texto`, `usuario`) VALUES (?,?,?)");
        $consultaPre->bind_param('sss', $_POST["tituloAnotacion"], $_POST["texto"], $this->username);
        $consultaPre->execute();
        $result = $consultaPre->get_result();
        if (!$result) {    // Creacion correcta
            //Recargamos la página para actualizar con el nuevo evento
            $consultaPre->close();
            $db->close(); 
            header("Location: https://localhost/SEW/PHP/agenda.php#");
        } else{ // No se pudo crear el evento
            $consultaPre->close();
            $db->close(); 
            header("Location: https://localhost/SEW/PHP/error.html#");
        }
    }
    public function deleteEvent(){
        $db = new mysqli($this->servername, $this->bdusername, $this->bdpassword, $this->nombrebd);
        if ($db->connect_error) {
            exit("<p>ERROR de conexión:" . $db->connect_error . "</p>");
        }
        
        $consultaPre = $db->prepare("DELETE FROM `evento` WHERE `id` = ?");
        $consultaPre->bind_param('s', $_POST["idEvento"]);
        $consultaPre->execute();
        $result = $consultaPre->get_result();
        //Recargamos la página para actualizar
        $consultaPre->close();
        $db->close(); 
        header("Location: https://localhost/SEW/PHP/agenda.php#");
    }
    public function deleteAnnotation(){
        $db = new mysqli($this->servername, $this->bdusername, $this->bdpassword, $this->nombrebd);
        if ($db->connect_error) {
            exit("<p>ERROR de conexión:" . $db->connect_error . "</p>");
        }
        
        $consultaPre = $db->prepare("DELETE FROM `anotacion` WHERE `id` = ?");
        $consultaPre->bind_param('s', $_POST["idAnotacion"]);
        $consultaPre->execute();
        $result = $consultaPre->get_result();
        //Recargamos la página para actualizar
        $consultaPre->close();
        $db->close(); 
        header("Location: https://localhost/SEW/PHP/agenda.php#");
    }
    public function getFormularioLogin(){
        return "<p>En esta sección podrá visualizar y gestionar sus eventos y anotaciones.</p>
                <h1>Iniciar Sesión</h1>
                <form action='#' method='post' name='log-form'>
                    <p>
                        <label for='ID'>Email: </label>
                         <input type='text' name='ID'/>     
                    </p>
                    <p>
                        <label for='Password'>Contraseña: </label>
                         <input type='password' name='Password'/>     
                    </p>
                    <input type='submit' name='log' value='Iniciar Sesión'/>
                    <p>¿No tienes cuenta?</p>
                    <input type='submit' name='signup-form' value='Regístrate aquí'/>
                </form>";
    }
    public function getFormularioRegistro(){
        return "<p>En esta sección podrá visualizar y gestionar sus eventos y anotaciones.</p>
                <h1>Registrarse</h1>
                <form action='#' method='post' name='signup-form'>
                    <p>
                        <label for='username'>Email: </label>
                         <input type='text' name='ID'/>     
                    </p>
                    <p>
                        <label for='Password'>Contraseña: </label>
                         <input type='password' name='Password'/>     
                    </p>
                    <p>
                        <label for='nombre'>Nombre: </label>
                         <input type='text' name='nombre'/>     
                    </p>
                    <p>
                        <label for='apellidos'>Apellidos: </label>
                         <input type='text' name='apellidos'/>     
                    </p>
                    <input type='submit' name='signup' value='Registrarse'/>
                    <p>¿Ya tienes cuenta?</p>
                    <input type='submit' name='login-form' value='Iniciar Sesión'/>
                </form>";
    }
    public function getContenidoEventos(){
        $db = new mysqli($this->servername, $this->bdusername, $this->bdpassword, $this->nombrebd);
        if ($db->connect_error) {
            exit("<p>ERROR de conexión:" . $db->connect_error . "</p>");
        }
        $contenido="<p><b>Bienvenid@ " . $this->username . "</b></p>
                <p>En esta sección podrá visualizar y gestionar sus eventos y anotaciones.</p>";
        $consultaPre = $db->prepare("SELECT * FROM `evento` where `usuario`=?");
        $consultaPre->bind_param('s', $this->username);
        $consultaPre->execute();
        $result = $consultaPre->get_result();
        $contenido.="<div><h2><u>Mis Eventos</u></h2>";
        foreach($result as $evento){
            $contenido.="<div class='elemento'>
                         <p><b>Título: </b>".$evento['titulo']."</p>
                         <p><b>Fecha: </b>".$evento['fecha']."</p>
                         <p><b>Descripción: </b>".$evento['descripcion']."</p>
                         <p><b>ID del Evento: </b>".$evento['id']."</p>
                         </div>";
        }
        $contenido.="</div>";
        $contenido .= "<div>
                    <h3><em>Crear Evento</em></h3>
                    <p>Para crear elementos correctamente asegúrese de rellenar todos los campos</p>
                    <form action='#' method='post' name='event-form'>
                        <p>
                            <label for='titulo'>Título: </label>
                             <input type='text' name='titulo'/>     
                        </p>
                        <p>
                            <label for='descripcion'>Descripcion: </label>
                             <input type='text' name='descripcion'/>     
                        </p>
                        <p>
                            <label for='fecha'>Fecha: </label>
                             <input type='date' name='fecha'/>     
                        </p>
                        <input type='submit' name='event' value='Crear evento'/>
                    </form>
                </div>
                <div>
                    <h3><em>Borrar Evento</em></h3>
                    <form action='#' method='post' name='event-delete-form'>
                        <p>
                            <label for='idEvento'>ID del evento a borrar: </label>
                             <input type='text' name='idEvento'/>     
                        </p>
                        <input type='submit' name='eventDelete' value='Borrar evento'/>
                    </form>
                </div>";
        $consultaPre->close();
        $db->close(); 
        return $contenido;
    }
    public function getContenidoAnotaciones(){
        $db = new mysqli($this->servername, $this->bdusername, $this->bdpassword, $this->nombrebd);
        if ($db->connect_error) {
            exit("<p>ERROR de conexión:" . $db->connect_error . "</p>");
        }
        $contenido="";
        $consultaPre = $db->prepare("SELECT * FROM `anotacion` where `usuario`=?");
        $consultaPre->bind_param('s', $this->username);
        $consultaPre->execute();
        $result = $consultaPre->get_result();
        $contenido.="<div><h2><u>Mis Anotaciones</u></h2>";
        foreach($result as $anotacion){
            $contenido.="<div class='elemento'>
                         <p><b>Título: </b>".$anotacion['titulo']."</p>
                         <p><b>Texto: </b>".$anotacion['texto']."</p>
                         <p><b>ID de la Anotación: </b>".$anotacion['id']."</p>
                         </div>";
        }
        $contenido.="</div>";
        $contenido .= "<div>
                    <h3><em>Crear Anotación</em></h3>
                    <p>Para crear elementos correctamente asegúrese de rellenar todos los campos</p>
                    <form action='#' method='post' name='event-form'>
                        <p>
                            <label for='tituloAnotacion'>Título: </label>
                             <input type='text' name='tituloAnotacion'/>     
                        </p>
                        <p>
                            <label for='texto'>Texto: </label>
                             <input type='text' name='texto'/>     
                        </p>
                        <input type='submit' name='annotation' value='Crear anotación'/>
                    </form>
                </div>
                <div>
                    <h3><em>Borrar Anotación</em></h3>
                    <form action='#' method='post' name='annotation-delete-form'>
                        <p>
                            <label for='idAnotacion'>ID de la anotación a borrar: </label>
                             <input type='text' name='idAnotacion'/>     
                        </p>
                        <input type='submit' name='annotationDelete' value='Borrar anotación'/>
                    </form>
                </div>";
        $consultaPre->close();
        $db->close(); 
        return $contenido;
    }
    public function getContenido(){
        if($this->isLogged){    // Sesion iniciada
            return $this->getContenidoEventos() . $this->getContenidoAnotaciones();
        } else{
            if(!$this->isSigningUp){
                return $this->getFormularioLogin();
            } else{
                return $this->getFormularioRegistro();
            }
        }
    }
}
session_start();
if(!isset($_SESSION['inicioSesion']))
{
    $_SESSION['inicioSesion'] = new Logger();
    $logger = $_SESSION['inicioSesion'];
}
else{
    $logger = $_SESSION['inicioSesion'];
}
if (count($_POST)>0){
     if(isset($_POST['log'])){                  // Iniciar sesion
         if($_POST['ID'] != '' && $_POST['Password'] != ''){
            $logger->login(); 
         }
     } elseif(isset($_POST['signup'])){            // Registrarse
         if($_POST['ID'] != '' && $_POST['Password'] != '' && $_POST['nombre'] != '' && $_POST['apellidos'] != ''){
            $logger->signup(); 
         }
     } elseif(isset($_POST['signup-form'])){    // Cambiar al registro
         $logger->isSigningUp = true;
         header("Location: https://localhost/SEW/PHP/agenda.php#");
     } elseif(isset($_POST['login-form'])){     // Cambiar al login
         $logger->isSigningUp = false;
         header("Location: https://localhost/SEW/PHP/agenda.php#");
     } elseif(isset($_POST['event'])){     // Crear evento
         if($_POST['titulo'] != '' && $_POST['descripcion'] != '' && $_POST['fecha'] != ''){
            $logger->createEvent(); 
         }
     } elseif(isset($_POST['annotation'])){     // Crear anotacion
         if($_POST['tituloAnotacion'] != '' && $_POST['texto'] != ''){
            $logger->createAnnotation(); 
         }
     } elseif(isset($_POST['eventDelete'])){     // Borrar evento
         if($_POST['idEvento'] != ''){
            $logger->deleteEvent(); 
         }
     } elseif(isset($_POST['annotationDelete'])){     // Borrar Anotacion
         if($_POST['idAnotacion'] != ''){
            $logger->deleteAnnotation(); 
         }
     }
}
echo"
<!DOCTYPE html>
        <html lang='es'>
            <head>
                <meta charset='UTF-8'>
                <title>Inicio de Sesi&oacute;n - OrganizaT</title>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <link rel='stylesheet' type='text/css' href='../estilo.css'/>
                <link rel='stylesheet' type='text/css' href='estilo_agenda.css'/>
            </head>
            <body>
                <header>
                    <nav>
                        <div>
                            <a class='nav-link' href='../index.html'>Organiza-T</a>
                        </div>
                    </nav>
                </header>
                <main>
                    <div> " 
                    . $logger->getContenido() ."</div>
                </main>
                <footer>
                    <div>Creado por <em>UO271411</em></div>
                </footer>
            </body>
        </html>";
?>
