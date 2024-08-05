<?php
require("../config/db_connection.php");

if(isset($_POST['document_id'])){
    $document_id = $_POST['document_id'];
    $signatory_id = $_POST['signatory_id'];

    $query = mysqli_query($conn, "SELECT DS.conversation, DS.signatory_id, D.document FROM document_status DS INNER JOIN documents D ON DS.document_id = D.document_id WHERE DS.document_id = $document_id AND DS.signatory_id = $signatory_id LIMIT 1");
    $data ='';

    if (mysqli_num_rows($query) > 0){
        while($row = mysqli_fetch_assoc($query)){
        $conversation = $row['conversation'];
        $signatory_id = $row['signatory_id'];
        $document = $row['document'];

        $data .='<div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">' . $document . '</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <div><iframe src="'.$conversation.'" width="500" height="600"></iframe></div>
        </div>';
        }
        
    }
    echo $data;
}
?>