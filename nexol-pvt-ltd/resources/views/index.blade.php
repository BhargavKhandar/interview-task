<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Clients</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>

    <div class="container py-4">
        <h1 class="mb-4 text-center">Client Management</h1>

        <div class="row mb-5">
            <div class="col-md-6">
                <h4>Clients & Manufacturers</h4>
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Client</th>
                            <th>Manufacturer</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            <tr>
                                <td>
                                    <button class="btn btn-link p-0" onclick="checkbox({{ json_encode($client) }})">
                                        {{ $client->name }}
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-link p-0" onclick="checkbox({{ json_encode($client) }})">
                                        {{ $client->manufactuer }}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="col-md-6">
                <h4>Manufacturers</h4>
                <table class="table table-bordered table-hover" id="manufacturer-table">
                    <thead class="table-light">
                        <tr>
                            <th>Manufacturer</th>
                            <th>Enable</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <div id="manufacturer-filters" class="mt-3"></div>
            </div>
        </div>

        <h4>Main Data Table</h4>
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Product Type</th>
                    <th>Price</th>
                    <th>KM</th>
                    <th>Months</th>
                    <th>Vehicle Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="main-table"></tbody>
        </table>
    </div>

    <!-- Add Data Modal -->
    <div class="modal fade" id="addDataModal" tabindex="-1" aria-labelledby="addDataModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="addDataForm" class="needs-validation" novalidate>
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="addDataModalLabel">Add New Client Data</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="modalName" name="name" />
                        <input type="hidden" id="modalManufacturer" name="manufactuer" />

                        <div class="mb-3">
                            <label for="product_type" class="form-label">Product Type</label>
                            <input type="text" class="form-control" id="product_type" name="product_type" required />
                            <div class="invalid-feedback">Please enter a product type.</div>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" required
                                min="0" />
                            <div class="invalid-feedback">Please enter a valid price.</div>
                        </div>
                        <div class="mb-3">
                            <label for="km" class="form-label">KM</label>
                            <input type="number" class="form-control" id="km" name="km" required
                                min="0" />
                            <div class="invalid-feedback">Please enter valid KM.</div>
                        </div>
                        <div class="mb-3">
                            <label for="month" class="form-label">Months</label>
                            <input type="number" class="form-control" id="month" name="month" required
                                min="0" />
                            <div class="invalid-feedback">Please enter valid months.</div>
                        </div>
                        <div class="mb-3">
                            <label for="vehicle_type" class="form-label">Vehicle Type</label>
                            <input type="text" class="form-control" id="vehicle_type" name="vehicle_type" required />
                            <div class="invalid-feedback">Please enter vehicle type.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Data</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const allClients = @json($clients);
        let addDataModal = new bootstrap.Modal(document.getElementById('addDataModal'));

        function renderTable(data) {
            const table = document.getElementById('main-table');
            table.innerHTML = '';

            data.forEach(client => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><input class="form-control form-control-sm" type="text" id="product_type_${client.id}" value="${client.product_type}" /></td>
                    <td><input class="form-control form-control-sm" type="number" id="price_${client.id}" value="${client.price}" /></td>
                    <td><input class="form-control form-control-sm" type="number" id="km_${client.id}" value="${client.km}" /></td>
                    <td><input class="form-control form-control-sm" type="number" id="month_${client.id}" value="${client.month}" /></td>
                    <td><input class="form-control form-control-sm" type="text" id="vehicle_type_${client.id}" value="${client.vehicle_type}" /></td>
                    <td><button class="btn btn-sm btn-warning" onclick="update(${client.id})">Update</button></td>
                `;
                table.appendChild(row);
            });
        }

        function checkbox(client) {
            const tbody = document.querySelector("#manufacturer-table tbody");
            if (document.getElementById(`row-${client.manufactuer}`)) return;

            const row = document.createElement("tr");
            row.id = `row-${client.manufactuer}`;
            row.innerHTML = `
                <td>${client.manufactuer}</td>
                <td>
                    <button class="btn btn-sm btn-primary" onclick="addFilterButton('${client.manufactuer}', '${client.name}')">+</button>
                </td>
            `;
            tbody.appendChild(row);
        }

        function addFilterButton(manufacturer, name) {
            const filterContainer = document.getElementById("manufacturer-filters");

            if (!document.getElementById(`filter-btn-${manufacturer}`)) {
                // Create filter button
                const filterBtn = document.createElement('button');
                filterBtn.innerText = manufacturer;
                filterBtn.id = `filter-btn-${manufacturer}`;
                filterBtn.className = "btn btn-outline-primary me-2 mb-2";

                filterBtn.onclick = () => {
                    // Check current table data
                    const currentRows = document.querySelectorAll("#main-table tr");
                    const filtered = allClients.filter(c => c.manufactuer === manufacturer);

                    // If filtered data is already shown, toggle to show all
                    const showingFiltered =
                        currentRows.length === filtered.length && [...currentRows].every((row, i) =>
                            row.querySelector(`#product_type_${filtered[i].id}`)
                        );

                    if (showingFiltered) {
                        renderTable(allClients); // Show all data
                    } else {
                        renderTable(filtered); // Show filtered
                    }
                };

                // Create "Add Data" button
                const addBtn = document.createElement('button');
                addBtn.innerText = "Add Data";
                addBtn.className = "btn btn-success me-3 mb-2";
                addBtn.onclick = () => openAddDataModal(manufacturer, name);

                // Append both buttons
                filterContainer.appendChild(filterBtn);
                filterContainer.appendChild(addBtn);
            }
        }


        function openAddDataModal(manufacturer, name) {
            document.getElementById('addDataForm').reset();

            document.getElementById('modalManufacturer').value = manufacturer;
            document.getElementById('modalName').value = name;

            addDataModal.show();
        }

        document.getElementById('addDataForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;

            if (!form.checkValidity()) {
                e.stopPropagation();
                form.classList.add('was-validated');
                return;
            }

            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const formData = new FormData(this);

            const data = {};
            formData.forEach((value, key) => data[key] = value);

            $.ajax({
                url: '{{ route('clients.store') }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                data: data,
                success: function(response) {
                    allClients.push(response);
                    renderTable(allClients);
                    addDataModal.hide();
                    form.classList.remove('was-validated');
                },
                error: function() {
                    alert('Failed to save data.');
                }
            });
        });

        function update(id) {
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const updatedClient = {
                id,
                product_type: document.getElementById(`product_type_${id}`).value,
                price: document.getElementById(`price_${id}`).value,
                km: document.getElementById(`km_${id}`).value,
                month: document.getElementById(`month_${id}`).value,
                vehicle_type: document.getElementById(`vehicle_type_${id}`).value
            };

            $.ajax({
                type: 'PUT',
                url: `/clients/${id}`,
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                data: updatedClient,
                success: function() {
                    alert('Updated successfully');
                },
                error: function() {
                    alert('Update failed');
                }
            });
        }

        renderTable(allClients);
    </script>

</body>

</html>
