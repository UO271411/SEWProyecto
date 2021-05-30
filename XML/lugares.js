class Meteo {
    constructor(lugar, latitud, longitud){
        this.apikey = "XeM0R_sjjg5ZmrAccJsioLnGpVF_XqJ_z2Mv2QMgfNc";
        this.ciudad = lugar;
        this.latitud = latitud;
        this.longitud = longitud;
        this.url = "https://weather.ls.hereapi.com/weather/1.0/report.xml?product=observation&latitude="+this.latitud+"&longitude="+this.longitud+"&oneobservation=true&apiKey="+this.apikey;
        this.text = "<lugares>" +
                "<lugar>" +
                    "<nombre>Covadonga</nombre>" +
                    "<descripcion>Pequeña parroquia en el concejo de Cangas de Onís. Es una localidad conocida por su historia relacionada con el Rey Pelayo y la reconquista de España.</descripcion>"	+
                    "<recomendacion>Buscar en día despejado. Ojo si llueve, es en grandes cantidades.</recomendacion>" +
                    "<valoracion>5</valoracion>" +
                    "<direccion>Covadonga (Cangas de Onís), Asturias</direccion>" +
                    "<coordenadas>" +
                        "<latitud>43.308491</latitud>" +
                        "<longitud>-5.054789</longitud>" +
                        "<altura>257</altura>" +
                    "</coordenadas>" +
                    "<fotografias>" +
                        "<foto>" +
                            "<imagen>http://www.cantabricoexperience.com/wp-content/uploads/2015/02/lagos-de-covadonga-asturias-620x264.jpg</imagen>" +
                            "<lugar>" +
                                "Los lagos de Covadonga, un paisaje natural precioso, sobre todo, en días despejados. Toda visita a Asturias ha de tener parada aquí." +
                            "</lugar>" +                
                            "<tipo>Panorámica</tipo>" +
                        "</foto>" +
                        "<foto>" +
                            "<imagen>https://www.barcelo.com/guia-turismo/wp-content/uploads/2019/10/basilica-de-covadonga_pal.jpg</imagen>" +
                            "<lugar>" +
                                "Templo religioso de culto católico declarado Basílica menor el 11 de septiembre de 1901." +
                            "</lugar>" +
                            "<tipo>Posado</tipo>" +
                        "</foto>" +
                        "<foto>" +
                            "<imagen>https://www.infocangasdeonis.com/images/cueva-covadonga-santina-capilla.jpg</imagen>" +
                            "<lugar>" +
                                "Santuario de la imágen de la Virgen de Covadonga (popularmente conocida como la Santina)." +
                            "</lugar>" +            
                            "<tipo>Foto sin flash</tipo>" +
                        "</foto>" +
                    "</fotografias>" +
                "</lugar>" +
                "<lugar>" +
                        "<nombre>Llanes</nombre>" +
                        "<descripcion>Llanes es, posiblemente, el pueblo más turístico que visitar en Asturias y en verano se llena hasta los topes. Sigue conservando su gracia natural y es un buen lugar en el que pasar el día. </descripcion>"	+	
                        "<recomendacion>Lleva abrigo, estamos en Asturias amigo.</recomendacion>" +
                        "<valoracion>3</valoracion>" +
                        "<direccion>Llanes, Asturias</direccion>" +
                        "<coordenadas>" +
                            "<latitud>43.425159</latitud>" +
                            "<longitud>-4.759100</longitud>" +
                            "<altura>1177</altura>" +
                        "</coordenadas>" +
                        "<fotografias>" +
                            "<foto>" +
                                "<imagen>https://guiadeasturias.com/wp-content/uploads/2016/02/XXXX5095562XXX88567_6248801593156698112_o.jpg</imagen>" +
                                "<lugar>" +
                                    "El Paseo de San Pedro, se trata de un camino de suaves formas, que contrasta con la dureza de los acantilados que se precipitan a la mar." +
                                "</lugar>" +                
                                "<tipo>Panorámica/posado con paisaje</tipo>" +
                            "</foto>" +
                        "</fotografias>" +
                    "</lugar>" +
                    "<lugar>" +
                        "<nombre>Gijón</nombre>" +
                        "<descripcion>La eterna rival de Oviedo, Gijón, también tiene tanto encanto que te costará elegir entre la una y la otra (no obstante, esta es una batalla que ya tiene completamente ganada).  </descripcion>"	+	
                        "<recomendacion>Si tienes vehículo genial, si no, quizá te convenga usar el autobús.</recomendacion>" +
                        "<valoracion>5</valoracion>" +
                        "<direccion>Gijón, Asturias</direccion>" +
                        "<coordenadas>" +
                            "<latitud>43.543946</latitud>" +
                            "<longitud>-5.665118</longitud>" +
                            "<altura>3</altura>" +
                        "</coordenadas>" +
                        "<fotografias>" +
                            "<foto>" +
                                "<imagen>http://agencia-asturias.com/wp-content/uploads/2017/03/04429_Gijon-cimadevilla.jpg</imagen>" +
                                "<lugar>" +
                                    "Cimadevilla es un barrio de la ciudad Asturiana de Gijón. Es el área más antigua de la ciudad, contando con vestigios arqueológicos de la época de administración romana, conservando también la estética de barrio de pescadores del siglo XIX." +
                                "</lugar>" +               
                                "<tipo>Interés histórico/cultural</tipo>" +
                            "</foto>" +
                            "<foto>" +
                                "<imagen>https://upload.wikimedia.org/wikipedia/commons/9/92/Universidad_Laboral_de_Gij%C3%B3n_estilo_cl%C3%A1sico_%28cropped%29_%28cropped%29.jpg</imagen>" +
                                "<lugar>" +
                                    "Universidad laboral, es la obra arquitectónica más importante realizada en el siglo XX en Asturias." +
                                "</lugar>" +              
                                "<tipo>Reportaje (todo tipo de foto)</tipo>" +
                            "</foto>" +
                        "</fotografias>" +
                    "</lugar>" +
                "</lugares>";

            this.parser = new DOMParser();
            this.xmlDoc = this.parser.parseFromString(this.text, "text/xml");

            // A partir del xml cargamos los elementos del html de forma dinámica
            document.getElementById("titulo1").innerHTML = this.xmlDoc.getElementsByTagName("nombre")[0].childNodes[0].nodeValue;
            document.getElementById("descripcion1").innerHTML = this.xmlDoc.getElementsByTagName("descripcion")[0].childNodes[0].nodeValue;
            document.getElementById("titulo2").innerHTML = this.xmlDoc.getElementsByTagName("nombre")[1].childNodes[0].nodeValue;
            document.getElementById("descripcion2").innerHTML = this.xmlDoc.getElementsByTagName("descripcion")[1].childNodes[0].nodeValue;
            document.getElementById("titulo3").innerHTML = this.xmlDoc.getElementsByTagName("nombre")[2].childNodes[0].nodeValue;
            document.getElementById("descripcion3").innerHTML = this.xmlDoc.getElementsByTagName("descripcion")[2].childNodes[0].nodeValue;
    }
    cargarDatos(idLugar){
        $.ajax({
            dataType: "xml",
            url: this.url,
            method: 'GET',
            success: function(datos){
                    $("pre").text(JSON.stringify(datos, null, 2));
                
                    //Obtencion de datos
                    var totalNodos            = $('*',datos).length; // cuenta los elementos de XML: son los nodos del árbol DOM de XML
                    var ciudad                = $('location',datos).attr("city");
                    var comunidad             = $('location',datos).attr("state");
                    var pais                  = $('location',datos).attr("country");
                    var longitud              = $('location',datos).attr("longitude");
                    var latitud               = $('location',datos).attr("latitude");
                    var temperatura           = $('temperature',datos).text();
                    var temperaturaMin        = $('lowTemperature',datos).text();
                    var temperaturaMax        = $('highTemperature',datos).text();
                    var sensacion             = $('comfort',datos).text();
                    var humedad               = $('humidity',datos).text();
                    var presion               = $('barometerPressure',datos).text();
                    var velocidadViento       = $('windSpeed',datos).text();
                    var direccionViento       = $('windDirection',datos).text();
                    var nombreDireccionViento = $('windDescShort',datos).text();
                    var icon                  = $('iconLink',datos).text();
                
                    //Presentación de los datos contenidos en JSON
                    var stringDatos = "<img class=\"small\" src='" + icon +"'>";
                        stringDatos += "<li><b>Ciudad:</b> " + ciudad + "</li>";
                        stringDatos += "<li><b>Región:</b> " + comunidad + "</li>";
                        stringDatos += "<li><b>País:</b> " + pais + "</li>";
                        stringDatos += "<li><b>Longitud:</b> " + longitud + " grados</li>";
                        stringDatos += "<li><b>Latitud:</b> " + latitud + " grados</li>";
                        stringDatos += "<li><b>Temperatura:</b> " + temperatura + " grados Celsius</li>";
                        stringDatos += "<li><b>Temperatura mínima:</b> " + temperaturaMin + " grados Celsius</li>";
                        stringDatos += "<li><b>Temperatura máxima:</b> " + temperaturaMax + " grados Celsius</li>";
                        stringDatos += "<li><b>Sensación térmica:</b> " + sensacion + " grados Celsius</li>";
                        stringDatos += "<li><b>Humedad:</b> " + humedad + " g/m3</li>";
                        stringDatos += "<li><b>Presión:</b> " + presion + " N/m2</li>";
                        stringDatos += "<li><b>Velocidad del viento:</b> " + velocidadViento + " metros/segundo</li>";
                        stringDatos += "<li><b>Dirección del viento:</b> " + direccionViento + " grados (" + nombreDireccionViento + ")</li>";                        
                    
                    $(idLugar).html(stringDatos);
                },
            error:function(){
                $(idLugar).html("¡Tenemos problemas! No puedo obtener JSON de <a href='https://developer.here.com/'>Weather is Here API</a>"); 
            }
        });
    }
    crearElemento(tipoElemento, texto, insertarAntesDe){
        // Crea un nuevo elemento modificando el árbol DOM
        // El elemnto creado es de 'tipoElemento' con un 'texto' 
        // El elemnto se coloca antes del elemnto 'insertarAntesDe'
        var elemento = document.createElement(tipoElemento); 
        elemento.innerHTML = texto;
        $(insertarAntesDe).before(elemento);
    }
    verJSON(idBoton, idLugar){
        //Muestra el archivo JSON recibido
        this.cargarDatos(idLugar);
        $(idBoton).attr("disabled","disabled");
        $(idBoton).attr("title","La información meteorológica ya se está mostrando");
    }
}
var meteo1 = new Meteo("Covadonga", 43.308491, -5.054789);
var meteo2 = new Meteo("Llanes", 43.425159, -4.759100);
var meteo3 = new Meteo("Gijón", 43.543946, -5.665118);