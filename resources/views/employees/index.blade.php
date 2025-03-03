<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="employees-index-url" content="{{ route('employees.index') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistema de Gestión de Empleados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="display-5 mb-0">
                        <i class="fas fa-user-tie me-2 text-primary"></i>
                        Sistema de Gestión de Empleados
                    </h1>
                    <button class="btn btn-primary" id="btnNewEmployee">
                        <i class="fas fa-user-plus me-2"></i>
                        Nuevo Empleado
                    </button>
                </div>
                <hr class="my-3">
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12" id="formContainer" style="display: none;">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h2 class="mb-4" id="formTitle">
                            <i class="fas fa-user-plus me-2 text-primary"></i>
                            Crear Empleado
                        </h2>

                        <div class="alert alert-info mb-4">
                            <i class="fas fa-info-circle me-2"></i>
                            Los campos con asteriscos (*) son obligatorios
                        </div>

                        <form id="employeeForm">
                            <input type="hidden" id="employeeId">

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">
                                        <i class="fas fa-user me-2"></i>
                                        Nombre completo *
                                    </label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Nombre completo del empleado" required>
                                    <div class="invalid-feedback" id="nameError"></div>
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-2"></i>
                                        Correo electrónico *
                                    </label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Correo electrónico" required>
                                    <div class="invalid-feedback" id="emailError"></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-venus-mars me-2"></i>
                                        Sexo *
                                    </label>
                                    <div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" id="genderMale"
                                                value="M" checked>
                                            <label class="form-check-label" for="genderMale">
                                                Masculino
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" id="genderFemale"
                                                value="F">
                                            <label class="form-check-label" for="genderFemale">
                                                Femenino
                                            </label>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback d-block" id="genderError"></div>
                                </div>

                                <div class="col-md-6">
                                    <label for="department" class="form-label">
                                        <i class="fas fa-briefcase me-2"></i>
                                        Área *
                                    </label>
                                    <select class="form-select" id="department" name="department" required>

                                    </select>
                                    <div class="invalid-feedback" id="departmentError"></div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">
                                    <i class="fas fa-file-alt me-2"></i>
                                    Descripción *
                                </label>
                                <textarea class="form-control" id="description" name="description" rows="4"
                                    placeholder="Descripción de la experiencia del empleado" required></textarea>
                                <div class="invalid-feedback" id="descriptionError"></div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter">
                                    <label class="form-check-label" for="newsletter">
                                        <i class="fas fa-bell me-2"></i>
                                        Deseo recibir boletín informativo
                                    </label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="fas fa-user-tie me-2"></i>
                                    Roles *
                                </label>
                                <div id="employeeRoles" class="flex-wrap d-flex gap-2">
                                </div>
                                <div class="invalid-feedback d-block" id="rolesError"></div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary" id="btnSubmit">
                                    <i class="fas fa-plus me-2"></i>
                                    Guardar
                                </button>
                                <button type="button" class="btn btn-secondary" id="btnCancel">
                                    <i class="fas fa-times me-2"></i>
                                    Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-12" id="listContainer">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2>
                                <i class="fas fa-list me-2 text-primary"></i>
                                Lista de Empleados
                            </h2>
                            <span class="badge bg-primary rounded-pill" id="employeeCount">
                                0 empleados
                            </span>
                        </div>

                        <div id="emptyMessage" class="alert alert-info">
                            No hay empleados registrados. Haga clic en "Nuevo Empleado" para agregar uno.
                        </div>

                        <div class="table-responsive" id="employeeTableContainer" style="display: none;">
                            <table class="table table-hover table-striped align-middle" id="employeeTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>
                                            <i class="fas fa-user me-2"></i>
                                            Nombre
                                        </th>
                                        <th>
                                            <i class="fas fa-envelope me-2"></i>
                                            Email
                                        </th>
                                        <th>
                                            <i class="fas fa-venus-mars me-2"></i>
                                            Sexo
                                        </th>
                                        <th>
                                            <i class="fas fa-briefcase me-2"></i>
                                            Área
                                        </th>
                                        <th>
                                            <i class="fas fa-bell me-2"></i>
                                            Boletín
                                        </th>
                                        <th>Roles</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="employeeTableBody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>