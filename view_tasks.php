<?php 
include("sidebar.php");
include("includes/operations.php");
 $sql = "SELECT * FROM tasks Order by id DESC;";
            
 $tasks = select_rows($sql);
?>

<div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Dashboard</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="index.html">Home</a></li>
                                <li><span>Table Basic</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <img class="avatar user-thumb" src="assets/images/author/avatar.png" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown">Kumkum Rai <i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Message</a>
                                <a class="dropdown-item" href="#">Settings</a>
                                <a class="dropdown-item" href="#">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner">
                <div class="row">

<div class="col-lg-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Tasks Available</h4>
                                <!-- Search and Filter Section -->
                                <div class="d-flex justify-content-between mb-4">
                                    <input type="text" id="searchBar" class="form-control" placeholder="Search tasks...">
                                    <select id="priorityFilter" class="form-control" onchange="applyFilter()">
                                        <option value="">Filter by Priority</option>
                                        <option value="high">High</option>
                                        <option value="medium">Medium</option>
                                        <option value="low">Low</option>
                                    </select>
                                    <select id="dateFilter" class="form-control" onchange="applyFilter()">
                                        <option value="">Filter by Due Date</option>
                                        <option value="ASC">Soonest First</option>
                                        <option value="DESC">Latest First</option>
                                    </select>
                                </div>
                                <div class="single-table">
                                    <div class="table-responsive">
                                        <table class="table text-dark text-center">
                                            <thead class="text-uppercase">
                                                <tr class="table-active">
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Priority Level</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Date Created</th>
                                                    <th scope="col">action</th>
                                                </tr>
                                            </thead>
                                           <?php foreach ($tasks as $task) {?>
                                            <tbody>
                                                <tr class="table-primary">
                                                    <th scope="row"><?php echo $task["id"]?></th>
                                                    <td><?php echo $task["title"]?></td>
                                                    <td><?php echo $task["description"]?></td>
                                                    <td><?php echo $task["priority_level"]?></td>
                                                    <td><?php echo $task["completion"]?></td>
                                                    <td><?php echo $task["due_date"]?></td>
                                                    
                                                    <td>
                                                        <!-- <i class="ti-trash"></i>
                                                        <i class="ti-pencil"></i> -->
                                                <i class="ti-pencil" onclick="openEditModal(<?php echo htmlspecialchars(json_encode($task)); ?>)"></i>
                                                <i class="ti-trash" onclick="confirmDelete(<?php echo $task['id']; ?>)"></i>
                                                    </td>
                                                </tr>
                                                <?php }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="editTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editTaskForm">
                    <input type="hidden" id="taskId" name="id">
                    <div class="form-group">
                        <label for="taskTitle">Title</label>
                        <input type="text" class="form-control" id="taskTitle" name="title">
                    </div>
                    <div class="form-group">
                        <label for="taskDescription">Description</label>
                        <textarea class="form-control" id="taskDescription" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="taskPriority">Priority Level</label>
                        <select class="form-control" id="taskPriority" name="priority_level">
                            <option>Low</option>
                            <option>Medium</option>
                            <option>High</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-success" onclick="markAsCompleted()">Mark as Completed</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="updateTask()">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                Are you sure you want to delete this task?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="deleteTask()">Yes, delete it</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<?php include("footer.php");?>
<script>
    let selectedTaskId = null;

function openEditModal(task) {
    // Populate the form with task data
    document.getElementById("taskId").value = task.id;
    document.getElementById("taskTitle").value = task.title;
    document.getElementById("taskDescription").value = task.description;
    document.getElementById("taskPriority").value = task.priority_level;
    
    $('#editTaskModal').modal('show');
}

function updateTask() {
    const formData = new FormData(document.getElementById("editTaskForm"));

    fetch('includes/update_task.php', {
        method: 'POST',
        body: formData
    }).then(response => response.text()).then(data => {
        alert(data); // Display server response
        location.reload(); // Refresh the page to show changes
    }).catch(error => console.error(error));
}

function markAsCompleted() {
    const taskId = document.getElementById("taskId").value;
    
    fetch('includes/mark_completed.php', {
        method: 'POST',
        body: JSON.stringify({ id: taskId })
    }).then(response => response.text()).then(data => {
        alert("Task marked as completed!");
        location.reload();
    }).catch(error => console.error(error));
}

function confirmDelete(taskId) {
    selectedTaskId = taskId;
    $('#deleteConfirmModal').modal('show');
}

function deleteTask() {
    fetch('includes/delete_task.php', {
        method: 'POST',
        body: JSON.stringify({ id: selectedTaskId })
    }).then(response => response.text()).then(data => {
        alert("Task deleted successfully!");
        location.reload();
    }).catch(error => console.error(error));
}

</script>
<script>
    // Function to filter tasks based on search and dropdown selection
    function applyFilter() {
        let searchTerm = document.getElementById("searchBar").value.toLowerCase();
        let priorityFilter = document.getElementById("priorityFilter").value;
        let dateFilter = document.getElementById("dateFilter").value;

        let rows = document.querySelectorAll("#taskTable tbody tr");

        rows.forEach(row => {
            let title = row.cells[1].textContent.toLowerCase();
            let priority = row.cells[3].textContent.toLowerCase();
            let dueDate = row.cells[4].textContent;

            let match = true;

            // Search Filter
            if (title.indexOf(searchTerm) === -1) {
                match = false;
            }

            // Priority Filter
            if (priorityFilter && priority !== priorityFilter.toLowerCase()) {
                match = false;
            }

            // Date Filter
            if (dateFilter) {
                if (dateFilter === "ASC" && new Date(dueDate) < new Date()) {
                    match = false;
                } else if (dateFilter === "DESC" && new Date(dueDate) > new Date()) {
                    match = false;
                }
            }

            row.style.display = match ? "" : "none";
        });
    }

    // Search functionality
    document.getElementById("searchBar").addEventListener("input", applyFilter);
</script>
<?php 

$priority = isset($_GET['priority']) ? $_GET['priority'] : '';
$due_date = isset($_GET['due_date']) ? $_GET['due_date'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Base SQL query
$sql = "SELECT * FROM tasks WHERE 1=1";

// Add conditions for search, priority, and due date
if ($priority) {
    $sql .= " AND priority_level = '$priority'";
}

if ($due_date) {
    $sql .= " ORDER BY due_date " . ($due_date == 'ASC' ? 'ASC' : 'DESC');
}

if ($search) {
    $sql .= " AND (title LIKE '%$search%' OR description LIKE '%$search%')";
}

$sql .= " ORDER BY id DESC";  // Default ordering by ID

$tasks = select_rows($sql)
?>