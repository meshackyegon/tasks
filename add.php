<?php include("sidebar.php");?>
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
                    
                    <div class="col-lg-12 col-ml-12">
                        <div class="row">
                            <!-- Textual inputs start -->
                            <div class="col-12 mt-5">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Add Task to the system</h4>
                                        <p class="text-muted font-14 mb-4">Here are examples of <code>.form-control</code> applied to each textual HTML5 <code>&lt;input&gt;</code> <code>type</code>.</p>
                                        <form class="needs-validation" novalidate="" method='POST' action="includes/add.php">
                                        <div class="form-group">
                                            <label for="example-text-input" class="col-form-label">Title</label>
                                            <input class="form-control" type="text" name="title"  id="example-text-input">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-search-input" class="col-form-label">Description</label>
                                            <input class="form-control" type="search"name="description"   id="example-search-input">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-email-input" class="col-form-label">Priority level </label>
                                            <select class="form-control" name="priority_level">
                                                <option value="">Select</option>
                                                <option value="high">High</option>
                                                <option value="medium">Medium</option>
                                                <option value="low">Low</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="example-date-input" class="col-form-label">Due date</label>
                                            <input class="form-control" type="date"name="due_date"  id="example-date-input">
                                        </div>
                                     
                                        <button class="btn btn-primary" name="submit" type="submit">Submit form</button>
                                      <form>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                   </div>


</div>
</div>

<?php include("footer.php");?> 