document.addEventListener('DOMContentLoaded', function() {
    var completeButtons = document.querySelectorAll('.complete-btn');

    completeButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            var taskId = this.getAttribute('data-task-id');
            var listItem = document.getElementById('task-' + taskId);

            // Kirim permintaan POST untuk menandai tugas sebagai selesai
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'index.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Perbarui tampilan setelah berhasil
                    listItem.classList.toggle('completed');

                    // Pindahkan tugas ke daftar yang sudah selesai
                    var completedTaskList = document.getElementById('completed-task-list');
                    completedTaskList.appendChild(listItem);
                }
            };
            xhr.send('complete=' + taskId);
        });
    });
});
