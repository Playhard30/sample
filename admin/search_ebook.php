<?php
ob_start();
include 'header.php';
?>



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1></h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-12 connectedSortable">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <form method="GET" class="form-horizontal">
                            <center>
                                <h3><strong>Search E-Book</strong></h3>
                            </center>
                            <div class="form-group col-md-12">
                                <input placeholder="Search for Title, Author, Call Number..." type="text" name="search"
                                    class="form-control">
                            </div>
                            <center><button name="submit" class="btn btn-lg btn-primary">Search</button></center>
                        </form>
                    </div>
                </div>
                <hr>
                <div class="box-body">
                    <div class="table-responsive">
                        <table s id="example1" class="table table-bordered">

                            <thead style="background: #ccc">
                                <tr>
                                    <th>Book Image</th>
                                    <th>Acc No./Bcode</th>
                                    <th>Call Number</th>
                                    <th>Author/s</th>
                                    <th>Title</th>
                                    <th>Editor</th>
                                    <th>Edition</th>
                                    <th>Place of Publ.</th>
                                    <th>Publisher</th>
                                    <th>Date of Publ.</th>
                                    <th>No. of Pages</th>
                                    <th>Series</th>
                                    <th>Notation 1</th>
                                    <th>Notation 2</th>
                                    <th>ISBN No.</th>
                                    <th>ISSN No.</th>
                                    <th>Subject</th>
                                    <th>Abstract</th>
                                    <th>Moa</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_GET['submit'])) {


                                    $return_query = mysqli_query($con, "SELECT * from ebooks
        LEFT JOIN tbl_moa USING(moa_id)
        LEFT JOIN tbl_publishers USING(publisher_id)
        LEFT JOIN tbl_placeofpublications USING(pop_id)
        where call_no LIKE '%$_GET[search]%' or title LIKE '%$_GET[search]%' or subject LIKE '%$_GET[search]%' or author LIKE '%$_GET[search]%' or accession_no LIKE '%$_GET[search]%' or remarks LIKE '%$_GET[search]%'") or die(mysqli_error($con));
                                    while ($row = mysqli_fetch_array($return_query)) {
                                        $id = $row['ebook_id'];
                                ?>
                                <tr>
                                    <!--- either this <td><a target="_blank" href="view_book_barcode.php?code=<?php // echo $row['book_barcode']; 
                                                                                                                        ?>"><?php // echo $row['book_barcode']; 
                                                                                                                            ?></a></td> -->
                                    <td><?php echo (empty($row['ebook_img'])) ? '<img src="../img/default_book.jpg" class="zoom" alt="ebook img" width="80" height="100">' : '<img src="data:image/jpeg;base64,' . base64_encode($row['ebook_img']) . '"
                                            class="zoom" alt="ebook img" width="80" height="100">' ?>
                                    </td>
                                    <td><?php echo $row['accession_no']; ?></td>
                                    <td style="word-wrap: break-word; width: 10em;"><?php echo $row['call_no']; ?></td>
                                    <td style="word-wrap: break-word; width: 10em;"><?php echo $row['author']; ?></td>
                                    <td style="word-wrap: break-word; width: 10em;"><?php echo $row['title']; ?></td>
                                    <td><?php echo $row['editor']; ?></td>
                                    <td><?php echo $row['edition']; ?></td>
                                    <td><?php echo $row['placeofpublication']; ?></td>
                                    <td><?php echo $row['publisher']; ?></td>
                                    <td><?php echo $row['date_of_publ']; ?></td>
                                    <td><?php echo $row['page_no']; ?></td>
                                    <td><?php echo $row['series']; ?></td>
                                    <td><?php echo $row['notation1']; ?></td>
                                    <td><?php echo $row['notation2']; ?></td>
                                    <td><?php echo $row['isbn_no']; ?></td>
                                    <td><?php echo $row['issn_no']; ?></td>
                                    <td><?php echo $row['subject']; ?></td>
                                    <td><?php echo $row['abstract']; ?></td>
                                    <td><?php echo $row['moa']; ?></td>
                                    <td><?php echo $row['remarks']; ?></td>
                                    <td>
                                        <form action="../../ebooks/view_ebook.php" method="POST">
                                            <input type="text" value="<?php echo $id; ?>" name="ebook_id" hidden>
                                            <button class="btn btn-default" type="submit">
                                                <i class="fa fa-eye"></i> View
                                            </button>
                                        </form>
                                        <?php if ($_SESSION['role'] == "Administrator") { ?>

                                        <a class="btn btn-primary" for="ViewAdmin"
                                            href="edit_ebook.php<?php echo '?ebook_id=' . $id; ?>">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <a class="btn btn-success" for="ViewAdmin"
                                            href="archive_ebook.php<?php echo '?ebook_id=' . $id; ?>">
                                            <i class="fa fa-send"></i> Put to...
                                        </a>
                                        <a class="btn btn-danger" for="DeleteBook" href="#delete<?php echo $id; ?>"
                                            data-toggle="modal" data-target="#delete<?php echo $id; ?>">
                                            <i class="glyphicon glyphicon-trash icon-white"></i> Delete
                                        </a>


                                        <!-- delete modal book -->
                                        <div class="modal fade" id="delete<?php echo $id; ?>" tabindex="-1"
                                            role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 style="font-weight: bold" class="modal-title"
                                                            id="myModalLabel"><i class="glyphicon glyphicon-user"></i>
                                                            Delete Book</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="alert alert-danger">
                                                            Are you sure you want to delete
                                                            <?php echo $row['title']; ?>?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-inverse" data-dismiss="modal"
                                                                aria-hidden="true"><i
                                                                    class="glyphicon glyphicon-remove icon-white"></i>
                                                                No</button>
                                                            <a href="delete_ebook.php<?php echo '?ebook_id=' . $id; ?>"
                                                                style="margin-bottom:5px;" class="btn btn-primary"><i
                                                                    class="glyphicon glyphicon-ok icon-white"></i>
                                                                Yes</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php }
                                } ?>

                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">

                    </div>
                </div>
            </section>
            <!-- /.Left col -->
        </div>
        <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
</div>


<?php include 'script.php'; ?>