<?php
require("../config/db_connection.php");
session_start();

if(isset($_POST['document_id'])){
	$document_id = $_POST['document_id'];
  $owner_id = $_POST['owner_id'];

  $filename = '';

  $sql = "SELECT d.document_id, d.document, u.user_id, ds.comments, ds.remarks, ds.approval_status
  FROM documents d 
  INNER JOIN document_status ds ON d.document_id = ds.document_id 
  INNER JOIN users u ON ds.signatory_id = u.user_id 
  WHERE d.document_id = '$document_id' AND u.user_id = '" . $_SESSION['id'] . "'";

  $manuscript = "SELECT file_name FROM thesis_document WHERE user_id = '$owner_id' ORDER BY id DESC LIMIT 1";
  $manuscriptQuery = mysqli_query($conn, $manuscript);

  if (mysqli_num_rows($manuscriptQuery) > 0) {
    $manuscriptRow = mysqli_fetch_assoc($manuscriptQuery);
    $filename = $manuscriptRow['file_name']; // Get the file name from the query result
  }


  $query = mysqli_query($conn, $sql);

  $data = '';

  if (mysqli_num_rows($query) > 0) {
    while($row = mysqli_fetch_assoc($query)){
     $document_id = $row['document_id'];
     $name = $row['document'];
     $faculty_id = $row['user_id'];
     $comments = $row['comments'];
     $remarks = $row['remarks'];
     $approval_status = $row['approval_status'];

     $data .= '<div class="modal-header">
     <h5 class="modal-title" id="exampleModalLabel">'.$name.'</h5>
     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
     </div>
     <div class="modal-body">
     <div class="container-fluid">
     <div class="row">
     <div class="col-lg-12 d-flex flex-column justify-content-between aligin-items-center ">
     <div class="d-grid gap-2">';
      if ($filename == '') {
          $data .= '<button class="btn btn-lg mt-4 d-block" onclick="alert(\'No manuscript available.\')">Show Manuscript</button>';
      } else {
          $data .= '<button class="btn btn-lg mt-4 d-block" onclick="window.open(\'../student/uploads/' . $filename . '\', \'_blank\')">Show Manuscript</button>';
      }
     $data .= '<button class="btn btn-lg mt-4 d-block" onclick="window.open(\'../assets/documents/'.$document_id.'_'.$name.'\', \'_blank\')">Show Document</button>';
     if($approval_status != "Pending"){
       if(is_null($comments) || is_null($remarks) || $comments == '' || $remarks == ''){
        $comments = "N/A";
        $remarks = "N/A";
      }
      $data .= '<ul class="list-group list-group-flush card-text">
      <li class="list-group-item"><strong>Comment</strong><br>' . $comments . '</li>
      <li class="list-group-item"><strong>Remarks</strong><br>' . $remarks . '</li>
      </ul>';
    }else{
     $data .= '<form id="approvalForm">
     <input class="col-lg-12 col-md-12 col-xs-12 form-control" type="text" name="comment" placeholder="Comment" required>
     <input class="col-lg-12 col-md-12 col-xs-12 form-control" type="text" name="remarks" placeholder="Remarks" required></div>
     <div class="d-grid gap-2">
     <button class="btn btn-lg mt-4 d-block" onclick="formProcess('.$document_id.', '.$faculty_id.',\'Approved\')">Approve</button>
     <button class="btn btn-lg mt-4 d-block" onclick="formProcess('.$document_id.', '.$faculty_id.',\'Rejected\')">Reject</button>
     </div>';
   }   
   $data .= '
   </form>
   </div>
   </div>
   </div>
   </div>';
 }
}

echo $data;
}

?>