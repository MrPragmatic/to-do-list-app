<form id="addTaskForm" action="add_task.php" method="post">
    <label for="task">New Task:</label>
    <input type="text" id="task" name="task" required>
    <button type="submit">Add Task</button>
</form>

<?php if (!empty($tasks) && is_array($tasks)): ?>
    <ul id="taskList">
        <?php foreach ($tasks as $task): ?>
            <li data-task-id="<?= $task['id']; ?>">
                <?= htmlspecialchars($task['task'], ENT_QUOTES, 'UTF-8'); ?>
                <button class="removeTask">Remove</button>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No tasks available.</p>
<?php endif; ?>

 <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addTaskForm = document.getElementById('addTaskForm');
            const taskList = document.getElementById('taskList');
            const taskInput = document.getElementById('task');

            addTaskForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const taskValue = taskInput.value.trim();

                if (taskValue !== '') {
                    // Send a request to add the task to the database
                    fetch('add_task.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams({
                            task: taskValue,
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // If the task was added successfully, update the UI
                            const li = document.createElement('li');
                            li.dataset.taskId = data.taskId;
                            li.innerHTML = `${taskValue} <button class="removeTask">Remove</button>`;
                            taskList.appendChild(li);
                            taskInput.value = ''; // Clear the input field after adding a task
                        } else {
                            console.error('Failed to add task:', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error adding task:', error);
                    });
                }
            });

            taskList.addEventListener('click', function(event) {
                if (event.target.classList.contains('removeTask')) {
                    const li = event.target.closest('li');
                    if (li) {
                        const taskId = li.dataset.taskId;

                        // Send a request to remove the task from the database
                        fetch('remove_task.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: new URLSearchParams({
                                taskId: taskId,
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // If the task was removed successfully, update the UI
                                li.remove();
                            } else {
                                console.error('Failed to remove task:', data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error removing task:', error);
                        });
                    }
                }
            });
        });
    </script>