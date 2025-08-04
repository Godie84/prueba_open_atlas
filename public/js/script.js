async function cargarTareas() {
    const userId = document.getElementById("userId").value.trim();//Trae el ID del usuario
    const tbody = document.querySelector("#tareas tbody");//Seleccionamos la tabla
    tbody.innerHTML = "";//limpiar el contenido de la tabla

    if (!userId) {//Valida si el ID del usuario esta vacio
        tbody.innerHTML = `<tr><td colspan="5" class="text-center text-danger">Por favor, ingresa un ID válido</td></tr>`;//mensaje cuando no hay un ID
        return;
    }

    try {
        const response = await fetch(`http://localhost/openatlas/api/tasks.php?user_id=${userId}`);// Aqui se envia la peticion a la API
        const data = await response.json();

        //validcion de la respuesta, si no es un array o esta vacio
        if (!Array.isArray(data) || data.length === 0) {
            //Mernsaje cuando no hay tareas
            tbody.innerHTML = `<tr><td colspan="5" class="text-center text-muted">No se encontraron tareas para el usuario #${userId}</td></tr>`;
            return;
        }

        data.forEach(tarea => {//Iteracion de la tabla tareas para mostrar los datos solicitados 
            const row = `
            <tr>
                <td>${tarea.user_name}</td>
                <td>${tarea.project_name}</td>
                <td>${parseFloat(tarea.rate).toFixed(2)}</td>
            </tr>`;
            tbody.innerHTML += row;
        });
    } catch (error) {
        console.error("Error:", error);
        tbody.innerHTML = `<tr><td colspan="5" class="text-center text-danger">Error al cargar datos</td></tr>`;
    }
}