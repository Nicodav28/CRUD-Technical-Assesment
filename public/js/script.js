let employees = [];
let roles = [];
let departments = [];
let currentMode = 'create';
let currentEmployeeId = null;

const formContainer = document.getElementById('formContainer');
const listContainer = document.getElementById('listContainer');
const employeeForm = document.getElementById('employeeForm');
const formTitle = document.getElementById('formTitle');
const btnSubmit = document.getElementById('btnSubmit');
const btnCancel = document.getElementById('btnCancel');
const btnNewEmployee = document.getElementById('btnNewEmployee');
const employeeTableContainer = document.getElementById('employeeTableContainer');
const employeeTableBody = document.getElementById('employeeTableBody');
const employeeCount = document.getElementById('employeeCount');
const emptyMessage = document.getElementById('emptyMessage');
const employeeRoles = document.getElementById('employeeRoles');
const departmentList = document.getElementById('department');

document.addEventListener('DOMContentLoaded', () => {
    getAllEmployees();
    getAllRoles();
    getAllDepartments();

    btnNewEmployee.addEventListener('click', showCreateForm);
    btnCancel.addEventListener('click', showEmployeeList);
    employeeForm.addEventListener('submit', handleFormSubmit);

    document.getElementById('name').addEventListener('blur', validateField);
    document.getElementById('email').addEventListener('blur', validateField);
    document.getElementById('description').addEventListener('blur', validateField);

    const roleCheckboxes = document.querySelectorAll('.role-checkbox');
    roleCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', validateRoles);
    });
});

function getAllEmployees() {
    let url = document.querySelector('meta[name="employees-index-url"]').content;

    $.get(url, function (data) {
        employees = data.data;
    }, 'json')
        .fail(function (error) {
            console.error("Error al obtener empleados:", error);
        })
        .always(function () {
            renderEmployeeList();
        });
}

function renderEmployeeList() {
    employeeCount.textContent = `${employees.length} ${employees.length === 1 ? 'empleado' : 'empleados'}`;

    if (employees.length === 0) {
        emptyMessage.style.display = 'block';
        employeeTableContainer.style.display = 'none';
        return;
    }

    emptyMessage.style.display = 'none';
    employeeTableContainer.style.display = 'block';

    employeeTableBody.innerHTML = '';

    employees.forEach(employee => {
        const row = document.createElement('tr');
        row.className = 'fade-in';

        row.innerHTML = `
      <td>${employee.nombre}</td>
      <td>${employee.email}</td>
      <td>${employee.sexo}</td>
      <td>${employee.area.nombre}</td>
      <td>
        ${employee.boletin
                ? '<span class="badge bg-success"><i class="fas fa-check me-1"></i>Sí</span>'
                : '<span class="badge bg-secondary"><i class="fas fa-times me-1"></i>No</span>'}
      </td>
      <td>
        <ul class="list-unstyled mb-0">
          ${employee.roles.map(role => `
            <li>
              <small class="role-badge">
                <i class="fas fa-user-tie me-1 text-secondary"></i>
                ${role.nombre}
              </small>
            </li>
          `).join('')}
        </ul>
      </td>
      <td>
        <div class="d-flex justify-content-center gap-2">
          <button
            class="btn btn-sm btn-outline-primary btn-action"
            onclick="editEmployee('${employee.id}')"
            title="Editar"
          >
            <i class="fas fa-edit"></i>
          </button>
          <button
            class="btn btn-sm btn-outline-danger btn-action"
            onclick="deleteEmployee('${employee.id}')"
            title="Eliminar"
          >
            <i class="fas fa-trash"></i>
          </button>
        </div>
      </td>
    `;

        employeeTableBody.appendChild(row);
    });
}

function renderEmployeeRolesList() {
    employeeRoles.innerHTML = '';

    roles.forEach(role => {
        const item = document.createElement('div');
        item.className = 'form-check fade-in';

        item.innerHTML = `
            <input class="form-check-input role-checkbox" type="checkbox"
                id="role-${role.id}" value="${role.id}">
            <label class="form-check-label" for="role-developer">
                ${role.nombre}
            </label>
        `;

        employeeRoles.appendChild(item);
    });
}

function renderEmployeeDepartmentsList() {
    departmentList.innerHTML = '';

    departments.forEach(department => {
        const item = document.createElement('option');
        item.value = department.id;
        item.textContent = department.nombre;

        departmentList.appendChild(item);
    });
}


function getAllRoles() {
    $.get('/roles', function (data) {
        roles = data.data;
    }, 'json')
        .fail(function (error) {
            console.error("Error al obtener roles:", error);
        })
        .always(function () {
            renderEmployeeRolesList();
        });
}

function getAllDepartments() {
    $.get('/deparments', function (data) {
        departments = data.data;
    }, 'json')
        .fail(function (error) {
            console.error("Error al obtener areas:", error);
        })
        .always(function () {
            renderEmployeeDepartmentsList();
        });
}

function showCreateForm() {
    currentMode = 'create';
    currentEmployeeId = null;

    formTitle.innerHTML = '<i class="fas fa-user-plus me-2 text-primary"></i>Crear Empleado';
    btnSubmit.innerHTML = '<i class="fas fa-plus me-2"></i>Guardar';

    employeeForm.reset();
    clearValidationErrors();

    formContainer.style.display = 'block';
    formContainer.classList.add('slide-in');
    listContainer.style.display = 'none';
}

function showEditForm(employee) {
    currentMode = 'edit';
    currentEmployeeId = employee.id;

    formTitle.innerHTML = '<i class="fas fa-edit me-2 text-primary"></i>Editar Empleado';
    btnSubmit.innerHTML = '<i class="fas fa-check me-2"></i>Actualizar';

    document.getElementById('name').value = employee.nombre;
    document.getElementById('email').value = employee.email;
    document.getElementById('genderMale').checked = employee.sexo === 'M';
    document.getElementById('genderFemale').checked = employee.sexo === 'F';
    document.getElementById('department').value = employee.area.id;
    document.getElementById('description').value = employee.descripcion;
    document.getElementById('newsletter').checked = employee.boletin;

    const roleCheckboxes = document.querySelectorAll('.role-checkbox');
    roleCheckboxes.forEach(checkbox => {
        checkbox.checked = employee.roles.some(role => role.id == checkbox.value);
    });

    clearValidationErrors();

    formContainer.style.display = 'block';
    formContainer.classList.add('slide-in');
    listContainer.style.display = 'none';
}

function showEmployeeList() {
    formContainer.style.display = 'none';
    listContainer.style.display = 'block';
    listContainer.classList.add('fade-in');
}

function handleFormSubmit(event) {
    event.preventDefault();

    if (!validateForm()) {
        return;
    }

    const employeeData = {
        nombre: document.getElementById('name').value.trim(),
        email: document.getElementById('email').value.trim(),
        sexo: document.querySelector('input[name="gender"]:checked').value,
        area_id: document.getElementById('department').value,
        descripcion: document.getElementById('description').value.trim(),
        boletin: document.getElementById('newsletter').checked,
        roles: Array.from(document.querySelectorAll('.role-checkbox:checked')).map(cb => cb.value)
    };

    if (currentMode === 'create') {
        createEmployee(employeeData);
    } else {
        updateEmployee(employeeData);
    }

}

function createEmployee(data) {
    $.ajax({
        url: '/employees',
        method: "POST",
        data: data,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        success: function (response) {
            showNotification('¡Empleado creado exitosamente!', 'success');
            getAllEmployees();
            showEmployeeList();
        },
        error: function (error) {
            showNotification('Un error ocurrió al intentar crear el empleado', 'error');
            console.error("Error:", error.responseText);
        }
    });
}

function updateEmployee(data) {
    $.ajax({
        url: `/employees/${currentEmployeeId}`,
        method: "PUT",
        data: data,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        success: function (response) {
            showNotification('¡Empleado actualizado exitosamente!', 'success');
            getAllEmployees();
            showEmployeeList();
        },
        error: function (error) {
            showNotification('Un error ocurrió al intentar actualizar el empleado', 'error');
            console.error("Error:", error.responseText);
        }
    });
}

function editEmployee(id) {
    $.get(`/employees/${id}`, function (data) {
        showEditForm(data.data);
    }, 'json')
        .fail(function (error) {
            showNotification('¡Empleado no encontrado!', 'error');
        });
}

function deleteEmployee(id) {
    if (!confirm('¿Está seguro que desea eliminar este empleado?')) {
        return;
    }

    $.ajax({
        url: `/employees/${id}`,
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        success: function (response) {
            getAllEmployees();
            showNotification('Empleado eliminado correctamente', 'info');
        },
        error: function (xhr) {
            console.error("Error al eliminar el empleado:", xhr.responseText);
            showNotification("No se pudo eliminar el empleado", "error");
        }
    });
}

function validateForm() {
    let isValid = true;

    if (!validateField({ target: document.getElementById('name') })) {
        isValid = false;
    }

    if (!validateField({ target: document.getElementById('email') })) {
        isValid = false;
    }

    if (!validateField({ target: document.getElementById('description') })) {
        isValid = false;
    }

    if (!validateRoles()) {
        isValid = false;
    }

    return isValid;
}

function validateField(event) {
    const field = event.target || event;
    const fieldId = field.id;
    const fieldValue = field.value.trim();
    const errorElement = document.getElementById(`${fieldId}Error`);

    field.classList.remove('is-invalid');
    errorElement.textContent = '';

    switch (fieldId) {
        case 'name':
            if (!fieldValue) {
                field.classList.add('is-invalid');
                errorElement.textContent = 'El nombre es obligatorio';
                return false;
            }
            break;

        case 'email':
            if (!fieldValue) {
                field.classList.add('is-invalid');
                errorElement.textContent = 'El correo electrónico es obligatorio';
                return false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(fieldValue)) {
                field.classList.add('is-invalid');
                errorElement.textContent = 'Ingrese un correo electrónico válido';
                return false;
            }
            break;

        case 'description':
            if (!fieldValue) {
                field.classList.add('is-invalid');
                errorElement.textContent = 'La descripción es obligatoria';
                return false;
            }
            break;
    }

    return true;
}

function validateRoles() {
    const roleCheckboxes = document.querySelectorAll('.role-checkbox:checked');
    const errorElement = document.getElementById('rolesError');

    errorElement.textContent = '';

    if (roleCheckboxes.length === 0) {
        errorElement.textContent = 'Seleccione al menos un rol';
        return false;
    }

    return true;
}

function clearValidationErrors() {
    const invalidFields = document.querySelectorAll('.is-invalid');
    invalidFields.forEach(field => field.classList.remove('is-invalid'));

    const errorMessages = document.querySelectorAll('.invalid-feedback');
    errorMessages.forEach(element => element.textContent = '');
}

function showNotification(message, type = 'default') {
    Toastify({
        text: message,
        duration: 3000,
        close: true,
        gravity: 'top',
        position: 'right',
        className: `toastify-${type}`,
        stopOnFocus: true
    }).showToast();
}
