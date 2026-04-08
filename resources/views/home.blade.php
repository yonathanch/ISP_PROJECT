<x-app-layout>
    <div class="p-4">
        <div class="row mb-4">
            <div class="col-4 col-md-1 mb-2">
                <select id="perPage" class="form-select">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>

            <div class="col-12 col-md-6 mb-4">
                <input type="text" id="searchInput" class="form-control" placeholder="Search...">
            </div>
        </div>

        <div class="mb-4">
            <button class="btn btn-dark" onclick="openModal()">Add New</button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Date Wo</th>
                        <th>Branch</th>
                        <th>No Wo Client</th>
                        <th>Type Wo</th>
                        <th>Client</th>
                        <th>Status</th>
                        <th>Teknisi</th>
                    </tr>
                </thead>
                <tbody id="tableBody"></tbody>
            </table>

            <div id="pagination" class="mt-4 d-flex justify-content-center"></div>

            <form id="formServiceTicket">
                <input type="hidden" id="id" name="id">

                <div class="modal fade" id="modalServiceTicket">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5>Service Ticket</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Date Wo</label>
                                    <input type="date" id="date_wo" name="date_wo" class="form-control">
                                    <div class="invalid-feedback" id="error-date_wo"></div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Branch</label>
                                    <input type="text" id="branch" name="branch" class="form-control"
                                        placeholder="Branch...">
                                    <div class="invalid-feedback" id="error-branch"></div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">No WO Client</label>
                                    <input type="text" id="no_wo_client" name="no_wo_client" class="form-control"
                                        placeholder="Nomor WO Client...">
                                    <div class="invalid-feedback" id="error-no_wo_client"></div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Type WO</label>
                                    <input type="text" id="type_wo" name="type_wo" class="form-control"
                                        placeholder="Type WO...">
                                    <div class="invalid-feedback" id="error-type_wo"></div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Client</label>
                                    <input type="text" id="client" name="client" class="form-control"
                                        placeholder="Client...">
                                    <div class="invalid-feedback" id="error-client"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select id="is_active" name="is_active" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Non Active</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Teknisi</label>
                                    <input type="text" id="teknisi" name="teknisi" class="form-control"
                                        placeholder="Nama Teknisi...">
                                    <div class="invalid-feedback" id="error-teknisi"></div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-dark">Save</button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>

        <script>
            let allData = [];
            let currentPage = 1;
            let perPage = 10;

            $(document).ready(function() {
                loadData();

                $('#searchInput').on('keyup', function() {
                    currentPage = 1;
                    renderTable();
                });

                $('#perPage').on('change', function() {
                    perPage = parseInt($(this).val());
                    currentPage = 1;
                    renderTable();
                });
            });

            function loadData() {
                $.get('/service-ticket', function(data) {
                    allData = data;
                    renderTable();
                });
            }

            function renderTable() {
                let search = $('#searchInput').val().toLowerCase();

                let filtered = allData.filter(item =>
                    item.branch.toLowerCase().includes(search) ||
                    item.client.toLowerCase().includes(search) ||
                    item.type_wo.toLowerCase().includes(search)
                );

                let start = (currentPage - 1) * perPage;
                let paginated = filtered.slice(start, start + perPage);

                let html = '';

                paginated.forEach(item => {
                    html += `
                <tr>
                    <td class="d-flex flex-wrap gap-1">
                        <button class="btn btn-sm btn-warning me-1" onclick="editData(${item.id})">
                            <i class="fas fa-edit"></i> 
                        </button>

                        <button class="btn btn-sm btn-danger" onclick="deleteData(${item.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                        <button class="btn btn-sm ${item.is_active == 1 ? 'btn-success' : 'btn-secondary'}"
                            onclick="toggleStatus(${item.id})">
                            ${
                                item.is_active == 1
                                ? '<i class="fas fa-check"></i>'
                                : '<i class="fas fa-times"></i>'
                            }
                        </button>
                    </td>
                    <td>${item.date_wo}</td>
                    <td>${item.branch}</td>
                    <td>${item.no_wo_client}</td>
                    <td>${item.type_wo}</td>
                    <td>${item.client}</td>
                    <td>
                        ${
                            item.is_active == 1
                            ? '<span class="text-success fw-bold"><i class="fas fa-check"></i> Active</span>'
                            : '<span class="text-danger fw-bold"><i class="fas fa-times"></i> Non Active</span>'
                        }
                    </td>
                    <td>${item.teknisi}</td>
                </tr>`;
                });

                $('#tableBody').html(html);

                renderPagination(filtered.length);
            }

            function renderPagination(total) {
                let pages = Math.ceil(total / perPage);
                let html = '';

                for (let i = 1; i <= pages; i++) {
                    html += `
                <button class="btn btn-sm ${i === currentPage ? 'btn-dark' : 'btn-light'} me-1"
                    onclick="goToPage(${i})">
                    ${i}
                </button>`;
                }
                $('#pagination').html(html);
            }

            function goToPage(page) {
                currentPage = page;
                renderTable();
            }

            function openModal() {
                $('#formServiceTicket')[0].reset();
                $('#id').val('');
                new bootstrap.Modal(document.getElementById('modalServiceTicket')).show();
            }

            function editData(id) {
                $.get(`/service-ticket/${id}`, function(data) {
                    $('#id').val(data.id);
                    $('#date_wo').val(data.date_wo);
                    $('#branch').val(data.branch);
                    $('#no_wo_client').val(data.no_wo_client);
                    $('#type_wo').val(data.type_wo);
                    $('#client').val(data.client);
                    $('#is_active').val(data.is_active);
                    $('#teknisi').val(data.teknisi);

                    new bootstrap.Modal(document.getElementById('modalServiceTicket')).show();
                });
            }

            $('#formServiceTicket').submit(function(e) {
                e.preventDefault();
                //reset
                resetValidation();

                let id = $('#id').val();

                let url = id ? `/service-ticket/${id}` : `/service-ticket`;
                let method = id ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    success: function(res) {
                        Swal.fire('Success', res.message, 'success');
                        $('.modal').modal('hide');
                        loadData();
                    },

                    error: function(err) {
                        if (err.status === 422) {
                            let errors = err.responseJSON.errors;

                            for (let field in errors) {
                                let input = $('#' + field);
                                let errorText = $('#error-' + field);

                                input.addClass('is-invalid');
                                errorText.html(errors[field][0]);
                            }
                        }
                    }
                });
            });

            function resetValidation() {
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').html('');
            }

            function deleteData(id) {
                Swal.fire({
                    title: 'Are you sure you want to delete this data?',
                    icon: 'warning',
                    showCancelButton: true
                }).then(result => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/service-ticket/${id}`,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(res) {
                                Swal.fire('Deleted', res.message, 'success');
                                loadData();
                            }
                        });
                    }
                });
            }


            function toggleStatus(id) {
                $.post(`/service-ticket/${id}/toggle`, {
                    _token: $('meta[name="csrf-token"]').attr('content')
                }, function() {
                    loadData();
                });
            }
        </script>
</x-app-layout>
