<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Empleados</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <h1>Lista de Empleados</h1>

    <button onclick="cargarEmpleados()">Cargar Empleados</button>
    <button onclick="$('#addEmployeeModal').show()">Agregar Empleado</button>

    <ul id="employee-list">
        @foreach ($employees as $employee)
            <li id="emp-{{ $employee->id }}">
                {{ $employee->name }}
                <button onclick="editarEmpleado('{{ $employee->id }}')">Editar</button>
                <button onclick="eliminarEmpleado('{{ $employee->id }}')">Eliminar</button>
            </li>
        @endforeach
    </ul>

    <!-- Modal para agregar empleado -->
    <div id="addEmployeeModal" style="display:none;">
        <h2>Agregar Empleado</h2>
        <form id="addEmployeeForm">
            @csrf
            <input type="text" name="name" placeholder="Nombre">
            <button type="submit">Guardar</button>
            <button type="button" onclick="$('#addEmployeeModal').hide()">Cerrar</button>
        </form>
    </div>

    <script>
        function cargarEmpleados() {
            $.get("{{ route('employees.index') }}", function (data) {
                let lista = $("#employee-list");
                lista.empty();
                data.forEach(emp => {
                    lista.append(`
                        <li id="emp-${emp.id}">
                            ${emp.name}
                            <button onclick="editarEmpleado(${emp.id})">Editar</button>
                            <button onclick="eliminarEmpleado(${emp.id})">Eliminar</button>
                        </li>
                    `);
                });
            });
        }

        $("#addEmployeeForm").submit(function (e) {
            e.preventDefault();
            $.post("{{ route('employees.store') }}", $(this).serialize(), function (response) {
                alert(response.message);
                cargarEmpleados();
                $("#addEmployeeModal").hide();
            });
        });

        function editarEmpleado(id) {
            $.post(`/employees/${id}/edit`, function (employee) {
                let newName = prompt("Editar nombre:", employee.name);
                if (newName) {
                    actualizarEmpleado(id, newName);
                }
            });
        }

        function actualizarEmpleado(id, name) {
            $.post(`/employees/${id}/update`, { name, _token: "{{ csrf_token() }}" }, function (response) {
                alert(response.message);
                cargarEmpleados();
            });
        }

        function eliminarEmpleado(id) {
            if (confirm("¿Seguro que deseas eliminar este empleado?")) {
                $.post(`/employees/${id}/delete`, { _token: "{{ csrf_token() }}" }, function (response) {
                    alert(response.message);
                    cargarEmpleados();
                });
            }
        }
    </script>

</body>

</html>
