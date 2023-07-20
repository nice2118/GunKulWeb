     
    <!-- Data Tables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <!-- Page specific script -->
    <script>
    $(document).ready(function () {
        $('#example1').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/th.json',
            },
            order: [[0, 'desc']],
            // pageLength: 20,
            responsive: true,
            columnDefs: [
                { "width": "10%", "targets": 0 },
                { "width": "15%", "targets": 1 },
                { "width": "60%", "targets": 2 },
                { "width": "5%", "targets": 3 },
                { "width": "10%", "targets": 4 },
                {
                    "targets": 0, // คอลัมน์ที่มีวันที่
                    "render": function(data, type, row) {
                        if (type === 'display') {
                            var date = new Date(data);
                            var day = ("0" + date.getDate()).slice(-2); // เพิ่มเติมการเติม 0 นำหน้าถ้าตัวเลขมีเพียงหลักเดียว
                            var month = ("0" + (date.getMonth() + 1)).slice(-2); // เพิ่มเติมการเติม 0 นำหน้าถ้าตัวเลขมีเพียงหลักเดียว
                            var year = date.getFullYear();
                            var formattedDate = day + '/' + month + '/' + year;
                        return formattedDate;
                    }
                        return data;
                    }
                },
            ],
        });
    });
    </script>
    <script>
        // document.querySelectorAll('.dropdown-menu .dropdown-submenu').forEach(function (dropdown) {
        //     dropdown.addEventListener('mouseover', function () {
        //     var dropdownMenu = this.querySelector('.dropdown-menu');
        //     dropdownMenu.classList.add('show');
        //     });

        //     dropdown.addEventListener('mouseout', function () {
        //     var dropdownMenu = this.querySelector('.dropdown-menu');
        //     dropdownMenu.classList.remove('show');
        //     });
        // });
    </script>