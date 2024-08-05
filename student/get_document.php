<?php
require("../config/db_connection.php");

if(isset($_POST['document_id'])){
    $document_id = $_POST['document_id'];

    $query = mysqli_query($conn, "SELECT document_id, document, document_type FROM documents WHERE document_id = '$document_id'");
    $data ='';

    if (mysqli_num_rows($query) > 0){
        while($row = mysqli_fetch_assoc($query)){
        $id = $row['document_id'];
        $document = $row['document'];
        $document_type = $row['document_type'];
        $encodedDocumentName = rawurlencode($document);
        $data .='<div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">' . $document_type . '</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <div><iframe src="../assets/documents/' . $id . '_' . $encodedDocumentName . '" width="500" height="600"></iframe></div>
        </div>';
        }
        
    }
    echo $data;
}
?>