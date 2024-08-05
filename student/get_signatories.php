<?php
require("../config/db_connection.php");

if(isset($_POST['document_id'])){
	$document_id = $_POST['document_id'];

	$query = mysqli_query($conn, "SELECT d.document_id, d.document, u.user_id, u.name, u.picture, ds.signatory_id, ds.approval_status, ds.comments, ds.remarks, ds.conversation, ds.approval_time FROM documents d INNER JOIN document_status ds ON d.document_id = ds.document_id INNER JOIN users u ON ds.signatory_id = u.user_id WHERE d.document_id = '$document_id'");
	$approved = mysqli_query($conn, "SELECT d.document_id, d.document, u.user_id, u.name, u.picture, ds.approval_status, ds.comments, ds.remarks, ds.approval_time FROM documents d INNER JOIN document_status ds ON d.document_id = ds.document_id INNER JOIN users u ON ds.signatory_id = u.user_id WHERE d.document_id = '$document_id' AND ds.approval_status = 'Approved' AND NOT EXISTS ( SELECT 1 FROM document_status ds2 WHERE ds2.document_id = d.document_id AND ds2.approval_status IN ('Pending', 'Rejected') )");
	$notApproved = mysqli_query($conn, "SELECT d.document_id, d.document, u.user_id, u.name, u.picture, ds.approval_status, ds.comments, ds.remarks, ds.approval_time FROM documents d INNER JOIN document_status ds ON d.document_id = ds.document_id INNER JOIN users u ON ds.signatory_id = u.user_id WHERE d.document_id = '$document_id' AND ds.approval_status IN ('Pending', 'Rejected') AND EXISTS ( SELECT 1 FROM document_status ds2 WHERE ds2.document_id = d.document_id AND ds2.approval_status = 'Approved' )");
	$pending = mysqli_query($conn, "SELECT d.document_id, d.document, u.user_id, u.name, u.picture, ds.approval_status, ds.comments, ds.remarks, ds.approval_time FROM documents d INNER JOIN document_status ds ON d.document_id = ds.document_id INNER JOIN users u ON ds.signatory_id = u.user_id WHERE d.document_id = '$document_id' AND ds.approval_status IN ('Pending', 'Rejected') AND NOT EXISTS ( SELECT 1 FROM document_status ds2 WHERE ds2.document_id = d.document_id AND ds2.approval_status = 'Approved' )");
	
	$data = '';

    if (mysqli_num_rows($approved) > 0) {
        while ($row = mysqli_fetch_assoc($approved)) {
            $document_name = $row['document'];

            $data .= '<div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">' . $document_name . '</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <button type="button" class="btn btn-primary mb-4 float-right" onclick="otpVerification('.$document_id.')">Download</button>
            <div class="row">';
            break;
        }
    }

    else if (mysqli_num_rows($notApproved) > 0) {
        while ($row = mysqli_fetch_assoc($notApproved)) {
            $document_name = $row['document'];

            $data .= '<div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">' . $document_name . '</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="row">';
            break;
        }
    }

    else {
       if (mysqli_num_rows($pending) > 0) {
        while ($row = mysqli_fetch_assoc($pending)) {
            $document_name = $row['document'];

            $data .= '<div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">' . $document_name . '</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="row">';
            break;
        }
    }
}

if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        $document_id = $row['document_id'];
        $user_id = $row['user_id'];
        $signatory_id = $row['signatory_id'];
        $name = $row['name'];
        $picture = $row['picture'];
        $status = $row['approval_status'];
        $comments = $row['comments'];
        $remarks = $row['remarks'];
        $conversation = $row['conversation'];
        $approval_time = $row['approval_time'] ? date_create($row['approval_time']) : null;

        if (is_null($approval_time)) {
            $approval_time = 'N/A';
        } else {
            $approval_time = date_format($approval_time, 'F j, Y, g:i a');
        }


        $data .= '<div class="col-lg-3 col-md-6 col-sm-12 mb-4">
        <div class="card">
        <img src="../assets/img/profiles/' . $picture . '" class="card-img-top img-fluid" alt="Profile Image">
        <div class="card-body">
        <h5 class="card-title">' . $name . '</h5>
        <ul class="list-group list-group-flush card-text">';
        if (!is_null($conversation) && $status != "Pending"){
            $data .= '<li class="list-group-item">' . $status . '</li>
            <li class="list-group-item">' . $approval_time . '</li>
            <li class="list-group-item"><button type="button" class="w-100 btn btn-primary view-button mb-2" data-bs-toggle="modal" data-bs-target="#showConversation" onclick="showConversation('.$document_id.', '.$signatory_id.')">View Conversation</button></li>';
        } 
        else {
            $data .= '<li class="list-group-item">' . $status . '</li>
            <li class="list-group-item">' . $approval_time . '</li>
            <li class="list-group-item">' . $comments . '</li>
            <li class="list-group-item">' . $remarks . '</li>';
        }
        $data .= '</ul>
        </div>
        </div>
        </div>';
    }
}

// Close the remaining divs
$data .= '</div></div></div><div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>';

echo $data;
}
?>

