async function cargarTareas() {
    const userId = document.getElementById("userId").value.trim();
    const tbody = document.querySelector("#tareas tbody");
    tbody.innerHTML = "";

    if (!userId) {
        tbody.innerHTML = `<tr><td colspan="5" class="text-center text-danger">Por favor, ingresa un ID válido</td></tr>`;
        return;
    }

    try {
        const response = await fetch(`http://localhost/openatlas/api/tasks.php?user_id=${userId}`);
        const data = await response.json();

        if (!Array.isArray(data) || data.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center text-muted">No se encontraron tareas para el usuario #${userId}</td></tr>`;
            return;
        }

        data.forEach(tarea => {
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