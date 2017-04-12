<section class="wrapper">
        <div class="dashboard">
            <div class="title-row">
                <!-- <a href="add_client.php" class="button fancy title-btn primary">Add new Admin</a> -->
                <h1 class="title">Users</h1>
            </div>
            <div class="dashboard">
                <form action="" method="GET" name="userdata">
                    <fieldset>
                        <legend>Search</legend>
                        <div class="field">
                            <label for="username">Keyword</label>
                            <input type="text" class="textbox1" size="40" name="keyword" value="">
                            <br>
                            <input align="left" type="submit" value="View" name="search" class="button>">
                        </div>
                    </fieldset>
                </form>
            </div>
            
            <div class="data-table">
                <table class="dtable">
                    <thead>
                        <tr>
                            <!-- <th width="20">S.No</th> -->
                            <th>first Name</th>
                            <th>last Name</th>
                            <th>Email Address</th>
                            <th>Create Date</th>
                            <th>Phone</th>
                            <th>action</th>
                    </tr></thead>
                    
                    <tbody>

                    <?php if(count($users)): ?>
                      <?php foreach ($users as $user ) { ?>
                       
                        <tr class="tblrow1" data-row = 'row_<?php echo $user->id; ?>'>
                            <!-- <td>1</td> -->

                            <td><?php echo $user->fname; ?></td>
                            <td><?php echo $user->lname; ?></td>
                            <td><?php echo $user->email; ?></td>
                            <td><?php echo $user->created_at; ?></td>
                            <td>
                                <div style="color:green"><?php echo $user->phone; ?></div>
                            </td>
                            <td style="width:125px">
                                <a href="<?php echo base_url(); ?>admin/edit_user/<?php echo $user->id; ?>" title="Edit" class="edit">Edit</a>
                                <a href="#" data-delete-user='<?php echo $user->id; ?>' class="delete">Delete</a>
                                <span class="ajax-loader" data-user='<?php echo $user->id; ?>'>  </span>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </section>