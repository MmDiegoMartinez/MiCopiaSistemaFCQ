function cargarGradosYGrupos() {
    // Obtener el valor seleccionado de la carrera
    var carreraSeleccionada = document.getElementById("carrera").value;

    // Realizar la solicitud AJAX para obtener los grados y grupos
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // Limpiar las opciones actuales en los select de semestre y grupo
            document.getElementById("semestre").innerHTML = "";
            document.getElementById("grupo").innerHTML = "";

            // Parsear la respuesta JSON
            var data = JSON.parse(this.responseText);

            // Llenar el select de semestre con los datos obtenidos
            for (var i = 0; i < data.semestres.length; i++) {
                var option = document.createElement("option");
                option.value = data.semestres[i];
                option.text = data.semestres[i];
                document.getElementById("semestre").appendChild(option);
            }

            // Llenar el select de grupo con los datos obtenidos
            for (var i = 0; i < data.grupos.length; i++) {
                var option = document.createElement("option");
                option.value = data.grupos[i];
                option.text = data.grupos[i];
                document.getElementById("grupo").appendChild(option);
            }
        }
    };

    xhr.open("GET", "obtener_grados_grupos.php?carrera=" + carreraSeleccionada, true);
    xhr.send();
}