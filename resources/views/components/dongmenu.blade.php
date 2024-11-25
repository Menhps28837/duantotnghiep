<script>
    // document.getElementById('sidebarToggle').addEventListener('click', function () {
    //   const sidebar = document.getElementById('accordionSidebar');
    //   sidebar.classList.toggle('toggled');
    //   });

    document.getElementById('sidebarToggle').addEventListener('click', function() {
        const col1 = document.getElementById('col1');
        const col2 = document.getElementById('col2');

        // Thay đổi lớp cột
        if (col1.classList.contains('col-2')) {
            col1.classList.remove('col-2');
            col1.classList.add('col-1');
            col2.classList.remove('col-10');
            col2.classList.add('col-11');
        } else {
            col1.classList.remove('col-1');
            col1.classList.add('col-2');
            col2.classList.remove('col-11');
            col2.classList.add('col-10');
        }
    });
</script>
    